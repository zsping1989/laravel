<?php

/**
 * 通过 PhpStorm 创建.
 * 创建人: 21498
 * 日期: 2016/6/28
 * 时间: 11:14
 */
namespace App\Logics;

use App\Models\Menu;
use Illuminate\Support\Facades\Route;

class MenuLogic{
    /**
     * 后台权限白名单(菜单ID)
     * 返回: array
     */
    public function getAdminWhiteListIds(){
        return [2,12,41,42];
    }

    /**
     * 导航条
     * 返回: array|static
     */
    public function getNavbar(){
        $route = Route::getCurrentRoute()->getCompiled()->getStaticPrefix(); //当前路由
        $menu = Menu::where('url','like',$route.'%')->orderBy('right_margin')->first(); //最底层路由
        $menu AND $menu->url = 'end';
       return $menu ? collect($menu->parents()->toArray())->push($menu)->keyBy('id') : [];
    }

}