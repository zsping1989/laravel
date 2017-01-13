<?php

namespace App\Providers;

use App\Logics\Facade\MenuLogic;
use App\Logics\Facade\UserLogic;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
               return $factory->jsonp(Request::input('callback'),$value,$status);
            }elseif(Request::input('define')=='AMD'){ //AMD
                $macro->addData($value);
                $value = 'define([],function(){ return '.collect($value)->toJson().';});';
            }elseif(Request::input('define')=='CMD'){ //CMD
                $macro->addData($value);
                $value = 'define([],function(){ return '.collect($value)->toJson().';});';
            }elseif(Request::has('dd')){ //数据打印页面
                dd($value->toArray());
            }elseif(Request::ajax() || Request::wantsJson() || Request::has('json')){ //json
                return $factory->json($value,$status);
            }elseif(Request::has('script')){ //页面
                $value = 'var '.Request::input('script').' = '.collect($value)->toJson().';';
            }else{
                $macro->addData($value);
                //return $factory->json($value,$status);
                return view(Route::getCurrentRoute()->getCompiled()->getStaticPrefix(),['data'=>$value]);
            }
            return $factory->make($value,$status);
        });
    }

    /**
     * 添加全局数据
     * @param $value
     */
    public function addData(&$value){
        $user = UserLogic::getUser();
        $global = [];
        $route_key = md5(app('request')->getPathInfo());
        $navs = Cache::get(config('cache-key.menu_navbar'),[]);
        $global['nav'] = array_get($navs,$route_key,function()use($navs,$route_key){
            $navs[$route_key] = MenuLogic::getNavbar();
            Cache::put(config('cache-key.menu_navbar'), $navs, 1440);
            return $navs[$route_key];
        });
        $global['navkeys'] = collect($global['nav'])->keys()->all();
        $global['user'] = $user; //用户信息
        $global['menus'] = $global['user'] ? UserLogic::getUserInfo('navigation') : null; //菜单数据

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
