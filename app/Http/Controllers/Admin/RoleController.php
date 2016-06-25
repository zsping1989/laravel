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
     * 列表数据展示页面
     * @return mixed
     */
    public function getIndex(){
        $data['list'] = $this->getList(); //角色列表
        $roles = Session::get('admin')['roles']; //当前用户角色

        //处理用户是否可操作对应角色
        $data['list']['data'] = collect($data['list']['data'])->map(function($item) use($roles){
            $flog = false;
            foreach($roles as $role){
                if($role['left_margin']<$item['left_margin']&& $role['right_margin']>$item['right_margin']){
                    $flog = true;
                }
            }
            $item['handle'] = $flog;
            return $item;
        });
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
        $data['canEdit'] = in_array($id,$this->rolesChildsId());
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
        if ($id) {
            $res = $this->bindModel->find($id)->update($request->all());
            if ($res === false) {
                return Response::returns(['alert' => alert(['content' => '修改失败!'], 500)]);
            }
            //修改菜单-角色关系
            return Response::returns(['alert' => alert(['content' => '修改成功!'])]);
        }

        $res = $this->bindModel->create($request->except('id'));
        if ($res === false) {
            return Response::returns(['alert' => alert(['content' => '新增失败!'], 500)]);
        }
        //添加菜单-角色关系
        return Response::returns(['alert' => alert(['content' => '新增成功!'])]);
    }

    /**
     * 获取当前用户角色的子角色
     * @return array
     */
    protected function rolesChildsId(){
        $roles = Session::get('admin')['roles']; //当前用户角色
        $rolesChilds = collect([]);
        collect($roles)->each(function($item)use (&$rolesChilds){
            $rolesChilds->push($this->bindModel->find($item['id'])->childs());
        });
        return $rolesChilds->collapse()->pluck('id')->toArray();
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