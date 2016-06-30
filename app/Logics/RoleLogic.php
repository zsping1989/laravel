<?php

/**
 * 通过 PhpStorm 创建.
 * 创建人: 21498
 * 日期: 2016/6/28
 * 时间: 11:14
 */
namespace App\Logics;


use App\Logics\Facade\UserLogic as FacadeUserLogic;

class RoleLogic{
    /**
     * 检查角色列表是否当前用户可编辑
     * @param $roles
     * 返回: mixed
     */
    public function checkIsHandle($roles){
        $main_roles = FacadeUserLogic::getUserInfo('admin.roles'); //当前用户角色
        foreach($roles as &$item){
            $flog = false;
            foreach($main_roles as $role){
                if($role['left_margin']<$item['left_margin']&& $role['right_margin']>$item['right_margin']){
                    $flog = true;
                }
            }
            $item['handle'] = $flog;
        }
        return $roles;
    }

}