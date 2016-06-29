<?php

namespace App\Providers;

use App\Exceptions\BaseBlueprint;
use App\Exceptions\CustomValidator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //注册自定义验证
        $this->app['validator']->resolver(function($translator, $data, $rules, $messages)
        {
            return new CustomValidator($translator, $data, $rules, $messages);
        });

        //处理请求参数
        Request::offsetSet('order',json_decode(Request::input('order','[]')));
        Request::offsetSet('where',collect(Request::input('where',[]))->map(function($item){
            if($item){
                return json_decode($item);
            }
        })->toArray());



    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
