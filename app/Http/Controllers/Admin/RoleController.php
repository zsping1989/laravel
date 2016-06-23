<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

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
     * 获取角色对应的用户
     * @param $id
     * 返回: mixed
     */
    public function getUserList($id){
        $admin = $this->bindModel->find($id)->adminUsers;
        return User::whereIn('id',$admin->pluck('user_id'))->get();
    }

    /**
     * 编辑数据页面
     * @param null $id
     */
    public function getEdit($id=null){
        $data = [];
        $id AND $data['row'] = $this->bindModel->find($id);
        //当前角色拥有权限
        $have = $data['row']->menus->pluck('id')->all();

        //查询当前用户拥有权限
        $data['permissions'] = collect(Session::get('admin')['menus'])->map(function($item) use ($have){
            if(in_array($item['id'],$have)){
                $item['checked'] = 1;
            }else{
                $item['checked'] = 0;
            }
            return $item;
        });
        return Response::returns($data);
    }
}