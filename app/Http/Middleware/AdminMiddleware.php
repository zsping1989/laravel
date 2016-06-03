<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Request;

class AdminMiddleware
{
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
        //获取管理员用户
        $admin = Auth::user()->adminUser;

        //不是管理员
        if(!$admin){
            return orRedirect('/');
        }

        //获取用户所有角色,跟其下属角色
        $roles = $admin->roles;

        //不是超级管理员
        if(!$roles->contains('id',1)){

            //用户所含角色的下级角色
            $lower_level = [];
            $roles->each(function ($item,$k) use(&$lower_level){
                $lower_level[] = $item->childs()->toArray(); //获取所有下级角色
            });
            $lower_level_ids = collect($lower_level)->collapse()->pluck('id')->toArray();

            //后台用户的角色ID
            $roles_id = $roles->pluck('id')->toArray();
            $roles_id = array_merge($roles_id,$lower_level_ids);

            //含有的权限url
            $menus = Menu::whereHas('roles',function ($q) use ($roles_id){
                $q->whereIn('id',$roles_id);
            })->orderBy('left_margin')->get();

            //判断权限
            if(!$menus->contains('url',app('request')->getPathInfo())){
                return orRedirect('/admin/index');
            }
        }else{
            $menus = Menu::orderBy('left_margin')->get();
        }
        //dd($menus->toArray());
        $admin->menus = $menus->toArray();
        //存储后台用户信息
        Session::put('admin',$admin->toArray());


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
