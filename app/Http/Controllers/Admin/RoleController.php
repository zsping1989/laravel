<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
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
     * 获取菜单数据
     * @return static
     */
    public function getList(){
        $this->handleRequest();
        //树状结构限制排序
        if(isset($this->treeOrder)){
            $obj = $this->bindModel->orderBy('left_margin');
        }else{
            $obj = $this->bindModel;
        }
        $data = $obj->options(Request::only('where', 'order'))->paginate();
        $roles = Session::get('admin')['roles']; //当前用户角色
        foreach($data as &$item){
            $flog = false;
            foreach($roles as $role){
                if($role['left_margin']<$item['left_margin']&& $role['right_margin']>$item['right_margin']){
                    $flog = true;
                }
            }
            $item['handle'] = $flog;
        }
        $param = [
            'order'=> Request::input('order',[]), //排序
            'where'=>Request::input('where',[]), //条件查询
        ];

        return collect($data)->merge($param);
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
        $admin = $this->bindModel->find($id)->admins;
        return User::whereIn('id',$admin->pluck('user_id'))->get();
    }

    /**
     * 判断是否是超级管理员
     * @return bool
     */
    protected function isSuper(){
        return collect(Session::get('admin')['roles'])->pluck('id')->contains(1);
    }

    /**
     * 编辑数据页面
     * @param null $id
     */
    public function getEdit($id=null){
        $data = [];
        $id AND $data['row'] = $this->bindModel->find($id);
        //当前角色拥有权限
        $have = $id ? $data['row']->menus->pluck('id')->all() : [];

        //查询当前用户拥有权限
        $data['permissions'] = collect(Session::get('admin')['menus'])->map(function($item) use ($have){
            if(in_array($item['id'],$have)){
                $item['checked'] = 1;
            }else{
                $item['checked'] = 0;
            }
            return $item;
        });
        $data['users'] = $id ? $this->getUserList($id) : [];
        $data['canEdit'] = $id ? (in_array($id,$this->rolesChildsId()) || $this->isSuper()) : true;
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
        if(!$this->isSuper() && !in_array($id,$this->rolesChildsId())){ //无权修改
            return Response::returns(['name'=>['你无权修改该角色!']],422);
        };

        //添加或修改角色父ID权限判断
        if(!$this->isSuper()){
            $parent_id = $request->get('parent_id');
            if(!$parent_id || !in_array($parent_id,$this->rolesChildsId(true))){
                return Response::returns(['parent_id'=>['只能设置你有权限的角色分组ID']],422);
            }
        }

        //当前用户拥有的权限
        $have = collect(Session::get('admin')['menus'])->pluck('id')->all();
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
        
        //添加菜单-角色关系
        return Response::returns(['alert' => alert(['content' => '新增成功!'])]);
    }

    /**
     * 获取当前用户角色的子角色
     * @return array
     */
    protected function rolesChildsId($all=false){
        $roles = Session::get('admin')['roles']; //当前用户角色
        $rolesChilds = collect([]);
        collect($roles)->each(function($item)use (&$rolesChilds){
            $rolesChilds->push($this->bindModel->find($item['id'])->childs());
        });
        $rolesChilds = $rolesChilds->collapse()->pluck('id');
        if(!$all){
            return $rolesChilds->toArray();
        }
        return $rolesChilds->merge(collect($roles)->pluck('id'))->toArray();
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