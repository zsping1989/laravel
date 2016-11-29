<?php

namespace App\Http\Controllers\Admin;

use Custom\Commands\Controllers\ResourceController;
use App\Http\Controllers\Controller;
use App\Logics\Facade\MenuLogic;
use App\Logics\Facade\UserLogic;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request as ValidateRequest;

class RoleController extends Controller
{
    use ResourceController; //资源控制器
    protected $treeOrder = true;
    /**
     * 模型绑定
     * MenuController constructor.
     * 参数: Menu $bindModel
     */
    public function __construct(Role $bindModel){
        $this->bindModel = $bindModel;
    }

    /**
     * 新增或修改,验证规则获取
     * 返回: array
     */
    protected function getValidateRule(){
        return ['name'=>'required','parent_id'=>'sometimes|required|exists:roles,id'];
    }


    /**
     * 列表数据展示页面
     * @return mixed
     */
    public function getIndex(){
        $data['list'] = $this->getList(); //角色列表

        return Response::returns($data);
    }

    /**
     * 获取角色对应的用户
     * @param $id
     * 返回: mixed
     */
    public function getUserList($id){
        $admin = $this->bindModel->findOrFail($id)->admins;
        return User::whereIn('id',$admin->pluck('user_id'))->get();
    }


    /**
     * 编辑数据页面
     * @param null $id
     */
    public function getEdit($id=null){
        $data = [];
        if(!$id){
            $data['canEdit']  = true;
            //查询当前用户拥有权限
            $data['permissions'] = MenuLogic::getMainCheckedMenus([]);
            return Response::returns($data);
        }

        $data['row'] = $this->bindModel->findOrFail($id);
        //当前角色对应的用户
        $data['users'] = $this->getUserList($id);
        //当前用户是否可编辑当前角色
        $data['canEdit'] = in_array($id,$this->rolesChildsId()) || UserLogic::getUserInfo('isSuperAdmin');

        //查询当前用户拥有权限,并选中当前角色权限
        $data['permissions'] = MenuLogic::getMainCheckedMenus($data['row']->menus)->map(function($item)use($data){
            $item['checked'] = $data['row']['id']==1 ? true:$data['row']['menus']->contains('id',$item['id']);
            $item['chkDisabled'] = ($data['row']['id']==1 || !$data['canEdit']);
            $item['url'] = '';
            return $item;
        });

        return Response::returns($data);
    }

    /**
     * 执行修改或添加
     * 参数 Request $request
     */
    public function postEdit(ValidateRequest $request){
        //验证数据
        $this->validate($request,$this->getValidateRule());
        $id = $request->get('id');

        //验证是否有修改权限
        if($id && !UserLogic::getUserInfo('isSuperAdmin') && !in_array($id,$this->rolesChildsId())){ //无权修改
            return Response::returns(['name'=>['你无权修改该角色!']],422);
        };

        //添加或修改角色父ID权限判断
        if(!UserLogic::getUserInfo('isSuperAdmin')){
            $parent_id = $request->get('parent_id');
            if(!$parent_id || !in_array($parent_id,$this->rolesChildsId(true))){
                return Response::returns(['parent_id'=>['只能设置你有权限的角色分组ID']],422);
            }
        }

        //当前用户拥有的权限
        $have = collect(UserLogic::getUserInfo('menus'))->pluck('id')->all();
        //新角色权限
        $new_permissions = collect($request->get('new_permissions'))->filter(function ($item) {
            return $item > 0;
        })->intersect($have)->all();

        if ($id) {
            $role = $this->bindModel->find($id);
            $res = $role->update($request->all());
            if ($res === false) {
                return Response::returns(['alert' => alert(['content' => '修改失败!'], 500)]);
            }
            //修改菜单-角色关系
            if($id!=1){
                //当前用户拥有该角色的旧权限
                $old_permissions = $role->menus->pluck('id')
                    ->intersect($have)
                    ->all();
                //删除旧的权限,添加新权限
                $add_permissions = collect($new_permissions)->diff($old_permissions)->all();
                $del_permissions = collect($old_permissions)->diff($new_permissions)->all();
                $del_permissions AND $role->menus()->detach($del_permissions);
                $role->menus()->attach($add_permissions);
                //新增权限父节点都将拥有
                $role->parents()->each(function($item) use($add_permissions){
                    $add_permissions AND $item->menus()->detach($add_permissions);
                    $item->menus()->attach($add_permissions);
                });
                //删除节点权限子节点都删除
                $role->childs()->each(function($item) use($del_permissions){
                    $del_permissions AND $item->menus()->detach($del_permissions);
                });
            }
            //更新用户信息
            UserLogic::loginCacheInfo();
            return Response::returns(['alert' => alert(['content' => '修改成功!'])]);
        }

        $role = $this->bindModel->create($request->except('id'));
        if ($role === false) {
            return Response::returns(['alert' => alert(['content' => '新增失败!'], 500)]);
        }
        //所有父节点添加对应权限
        $role->parents(true)->each(function($item)use($new_permissions){
            $new_permissions AND $item->menus()->detach($new_permissions);
            $item->menus()->attach($new_permissions);
        });

        //更新用户信息
        UserLogic::loginCacheInfo();
        //添加菜单-角色关系
        return Response::returns(['alert' => alert(['content' => '新增成功!'])]);
    }

    /**
     * 获取当前用户角色的子角色
     * @return array
     */
    protected function rolesChildsId($all=false){
        return UserLogic::getAdminRolesAndChilds($all)->pluck('id')->toArray();
    }

    /**
     * 删除数据
     * @return mixed
     */
    public function getDestroy(){
        //查询用户角色的所有下级角色ID,可删除的角色ID
        $ids = $this->rolesChildsId();
        $qids = Request::input('ids',[]);
        $qids = is_array($qids) ? $qids : [$qids];
        if(collect($qids)->diff($ids)->toArray()){
            return Response::returns(['alert'=>alert(['content'=>'有未授权删除的用户角色!'],422)],422);
        }
        //角色删除
        $res = $this->bindModel->destroy($qids);
        if($res===false){
            return Response::returns(['alert'=>alert(['content'=>'删除失败!'],500)]);
        }
        return Response::returns(['alert'=>alert(['content'=>'删除成功!'])]);
    }
}