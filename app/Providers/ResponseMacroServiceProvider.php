<?php

namespace App\Providers;

use App\Logics\Facade\MenuLogic;
use App\Logics\Facade\UserLogic;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @param  ResponseFactory  $factory
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $macro = $this;
        $factory->macro('returns', function ($value,$status=200) use ($factory,$macro) {

            $value = collect($value);
            if(Request::input('callback')){ //jsonp
               return $factory->jsonp(Request::input('callback'),$value);
            }elseif(Request::input('define')=='AMD'){ //AMD
                if($redirect = $value->get('redirect')){
                    //页面跳转
                    $value = 'window.location.href = \''.$redirect.'\';';
                }else{
                    $macro->addData($value);
                    $value = 'define([],function(){ return '.collect($value)->toJson().';});';
                }
            }elseif(Request::input('define')=='CMD'){ //CMD
                $macro->addData($value);
                $value = 'define([],function(){ return '.collect($value)->toJson().';});';
            }elseif(Request::has('dd')){ //数据打印页面
                dd($value->toArray());
            }elseif(Request::ajax() || Request::wantsJson()){ //json
                $value = collect($value)->toJson();
            }elseif(Request::has('script')){ //页面
                $value = 'var '.Request::input('script').' = '.collect($value)->toJson().';';
            }else{
                $macro->addData($value);
                $value['user'] = UserLogic::getUser(); //用户信息
                $value['menus'] = $value['user'] ? UserLogic::getUserInfo('menus') : null;
                return view('index',['data'=>$value]);
            }
            return $factory->make($value,$status);
        });
    }

    /**
     * 添加全局数据
     * @param $value
     */
    public function addData(&$value){
        $global = [];
        $global['route'] = preg_replace('/^\/?data(.*)$/','$1',Request::getPathInfo());  //路由信息
        $global['nav'] = MenuLogic::getNavbar(); //导航数据
        if(Request::input('global')=='all'){ //获取当前用户菜单数据,用户信息
            $global['user'] = UserLogic::getUser(); //用户信息
            $global['menus'] = $global['user'] ? UserLogic::getUserInfo('menus') : null; //菜单数据
        }
        $value['global'] = $global;
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
