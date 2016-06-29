<?php

namespace App\Providers;

use App\Logics\Facade\MenuLogic;
use App\Logics\UserLogic;
use Illuminate\Support\ServiceProvider;

class LogicServiceProvider extends ServiceProvider
{
    protected $defer = true; //缓载
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * 注册逻辑对象到容器
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //用户逻辑
        $this->app->singleton('user.logic', function($app){
            return new UserLogic();
        });
        //菜单逻辑
        $this->app->singleton('menu.logic', function($app){
            return new MenuLogic();
        });
    }

    /**
     * 注册对象,用于缓载
     * 返回: array
     */
    public function provides()
    {
        return ['menu.logic','user.logic'];
    }
}
