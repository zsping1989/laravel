<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\View;
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
            $data = [
                'order'=> Request::input('order',[]), //排序
                'where'=>Request::input('where',[]) //条件查询
            ];
            $value = collect($value)->merge($data);
            if(Request::input('callback')){ //jsonp
               return $factory->jsonp(Request::input('callback'),$value);
            }elseif(Request::input('define')=='AMD'){ //AMD
                $macro->addData($value);
                $value = 'define([],function(){ return '.collect($value)->toJson().';});';
            }elseif(Request::input('define')=='CMD'){ //CMD
                $macro->addData($value);
                $value = 'define([],function(){ return '.collect($value)->toJson().';});';
            }elseif(Request::has('dd')){ //数据打印页面
                dd($value->toArray());
            }elseif(Request::ajax() || Request::wantsJson()){ //json
                $value = collect($value)->toJson();
            }elseif(Request::has('script')){ //页面
                $value = 'var data = '.collect($value)->toJson().';';
            }else{
                $macro->addData($value);
                $value['user'] = Auth::user(); //用户信息
                $value['menus'] = session('admin.menus');
                return view('index',['data'=>$value]);
            }
            return $factory->make($value,$status);
        });
    }
    public function addData(&$value){
        $data = [
            'order'=> Request::input('order',[]), //排序
            'where'=>Request::input('where',[]), //条件查询
            'route'=>Request::getPathInfo()  //路由信息
        ];


        $value = collect($value)->merge($data);
        $menu = Menu::where('url','=',$value->get('route'))->first();
        $value['nav'] = $menu ? collect($menu->parents(true)->toArray())->keyBy('id') : [];
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
