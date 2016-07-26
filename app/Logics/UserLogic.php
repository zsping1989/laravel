<?php

/**
 * 通过 PhpStorm 创建.
 * 创建人: 21498
 * 日期: 2016/6/28
 * 时间: 11:14
 */
namespace App\Logics;

use App\Models\Menu;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Message\Facades\Message;

class UserLogic{
    //存储后台用户信息
    protected $admin;
    //用户信息
    protected $user;



    public function __construct(){
        $this->user = $this->getUser();
        $this->admin = $this->user ? $this->user->admin : null;
    }

    /**
     * 获取登录用户
     * 返回: mixed
     */
    public function getUser(){
       return Auth::user();
    }

    /**
     * 后台权限白名单(菜单ID)
     * 返回: array
     */
    public function getMenuWhiteListIds(){
        return [7,2,12,41,42];
    }

    /**
     * 获取当前用户的后台角色信息
     * 返回: mixed
     */
    public function getAdmin(){
        return $this->admin;
    }


    /**
     * 判断当前登录用户是否是后台管理员
     * 返回: bool
     */
    public function isAdmin(){
        return !!$this->admin;
    }

    /**
     * 判断当前用户是否是管理员
     * 返回: mixed
     */
    public function isSuperAdmin(){
        return $this->admin->roles->contains('id',1);
    }

    /**
     * 获取当前后台用户角色的所有角色及下属角色
     * 返回: mixed
     */
    public function getAdminRolesAndChilds($all=true){
        $roles = $this->admin->roles; //当前用户角色
        $roleModel = Role::where('id','<',0); //角色模型
        $exp = $all ? '=':'';
        //查询所有包含自己及子节点
        foreach($roles as $role){
            $roleModel->orWhere(function($query) use($role,$exp){
                $query->where('left_margin', '>'.$exp, $role->left_margin)
                    ->where('right_margin', '<'.$exp,$role->right_margin);
            });
        }
        return $roleModel->get();
    }

    /**
     * 获取当前后台用户拥有的后台菜单
     */
    public function getAdminMenus(){
        //是超级管理员
        if($this->isSuperAdmin()){
            $menus = Menu::orderBy('left_margin')->get();
        }else{
            //获取当前用户角色及下属角色ID
            $roles_id = $this->getAdminRolesAndChilds()->pluck('id');
            //获取含有的权限url
            $menus = Menu::whereHas('roles',function ($q) use ($roles_id){
                $q->whereIn('id',$roles_id);
            })->orderBy('left_margin')->orWhereIn('id',$this->getMenuWhiteListIds())->get();
        }
        return $menus;
    }

    /**
     * 缓存用户信息
     * @param $data
     * @param bool $key
     */
    public function putCacheUserInfo($data,$key=false){
        $userInfo  = session('userInfo') ?: [];
        if($key){
            $userInfo[$key] = $data;
        }else{
            foreach($data as $k=>$value){
                $userInfo[$k] = $value;
            }
        }
        return session()->put('userInfo',$userInfo);
    }

    /**
     * 登录成功缓存信息
     * 返回: mixed
     */
    public function loginCacheInfo(){
        $data = $this->user->toArray();
        $this->admin AND $this->admin->roles;
        $data['admin'] = $this->admin ? $this->admin->toArray() : null;
        $data['menus'] = $this->admin ? $this->getAdminMenus()->toArray(): null;
        $data['isSuperAdmin'] = $this->admin ? $this->isSuperAdmin() : false;
        return $this->putCacheUserInfo($data);
    }


    /**
     * 获取用户缓存信息
     * param string $key
     * 返回: mixed
     */
    public function getUserInfo($key=''){
        $key and $key = '.'.$key;
        return session('userInfo'.$key);
    }


    /**
     * 检查用户是否可被当前用户编辑
     * param $user
     * 返回: bool
     */
    public function checkEditUser(User $user){
        $no_disabled = false;
        $admin = $user->admin;
        $admin and $admin->roles ;
        //判断该用户是否可被当前随便修改
        $main_roles = $this->getAdminRolesAndChilds(true); //当前用户角色,数组
        //如果被编辑用户的角色在用户的
        foreach($main_roles as $main_role){
            $flog = true; //拥有编辑权限标记
            if(!isset($admin->roles)){
                $no_disabled = true;
                break;
            }
            foreach($admin->roles as $role){
                if(!($role->left_margin>$main_role['left_margin'] && $role->right_margin<$main_role['right_margin'])){
                    $flog = false;
                }
            }
            $flog AND $no_disabled = true;
        }
        return $no_disabled;
    }

    /**
     * 获取用户所有未读消息
     * 返回: static
     */
    public function getAllNotRead($msgtpl=null){
        return Message::getAllNotRead($this->getUserInfo('id'),$msgtpl);
    }

    /**
     * 获取未读消息分组的前三条数据
     * param $msgtpl
     * param int $limit
     * 返回: mixed
     */
    public function getAllNotReadLimit($msgtpl,$limit=3){
       return Message::getAllNotReadLimit($this->getUserInfo('id'),$msgtpl,$limit);
    }

    public function getCountNotReadByMsgtpl($msgtpl=null){
        return Message::getCountNotReadByMsgtpl($this->getUserInfo('id'),$msgtpl);
    }

}