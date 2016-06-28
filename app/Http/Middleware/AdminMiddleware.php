<?php

namespace App\Http\Middleware;

use App\Logics\Facade\UserLogic;
use Closure;
use Illuminate\Support\Facades\Route;

class AdminMiddleware{
    /**
     * 脚本运行时调用
     *
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        //不是管理员,跳转到前台首页
        if(!UserLogic::isAdmin()){
            return orRedirect('/');
        }

        //不是超级管理员,需要验证权限
        if(!UserLogic::isSuperAdmin()){
            //当前用户拥有的菜单权限
            $menus = UserLogic::getAdminMenus();

            //当前路由
            $route = Route::getCurrentRoute()->getCompiled()->getStaticPrefix();

            //判断当前路由是否在拥有权限url中
            $hasPermission = false;
            $menus->each(function($item) use (&$hasPermission,$route){
               if(strpos($item->url,$route)===0){
                   $hasPermission = true;
               }
            });

            //没有权限,
            if(!$hasPermission){
                return orRedirect('/admin/page404');
            }
        }

        $response = $next($request);
        //后置操作
        return $response;
    }


    /**
     *
     * 结果返回到客户端后调用
     *
     * Handle an incoming request.
     *
     * param  \Illuminate\Http\Request  $request
     * param  \Closure  $next
     * return mixed
     */
    public function terminate($request, $response)
    {
        // 结果成功返回到客户端后执行
    }
}
