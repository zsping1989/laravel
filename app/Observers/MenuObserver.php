<?php
/**
 * Created by PhpStorm.
 * User: zhangshiping
 * Date: 2016/12/28
 * Time: 10:28
 */

namespace App\Observers;


use App\Logics\Facade\UserLogic;
use App\Models\Menu;
use Illuminate\Support\Facades\Cache;

class MenuObserver{

    /**
     * 监听菜单目录变化
     * @return bool
     */
    public function saved(){
        UserLogic::loginCacheInfo(); //重新构建菜单目录
        Cache::forget(config('cache-key.menu_navbar')); //去除菜单相关缓存
        return true;
    }

}