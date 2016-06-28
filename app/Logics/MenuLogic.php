<?php

/**
 * 通过 PhpStorm 创建.
 * 创建人: 21498
 * 日期: 2016/6/28
 * 时间: 11:14
 */
namespace App\Logics;

class MenuLogic{
    /**
     * 后台权限白名单(菜单ID)
     * 返回: array
     */
    public function getAdminWhiteListIds(){
        return [2,12,41,42];
    }

}