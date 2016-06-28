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
use Illuminate\Support\Facades\Auth;

class UserLogic{
    //存储后台用户信息
    protected $admin;
    //用户信息
    protected $user;

    public function __construct(){
        $this->user = Auth::user();
        $this->admin = $this->user ? $this->user->admin : null;
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
    public function getAdminRolesAndChilds(){
        $roles = $this->admin->roles; //当前用户角色
        $roleModel = new Role(); //角色模型
        //查询所有包含自己及子节点
        foreach($roles as $role){
            $roleModel->orWhere(function($query) use($role){
                $query->where('left_margin', '>=', $role->left_margin)
                    ->where('right_margin', '<=',$role->right_margin);
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
            })->orderBy('left_margin')->orWhereIn('id',MenuLogic::getAdminWhiteListIds())->get();
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
        return $this->putCacheUserInfo($data);
    }

}