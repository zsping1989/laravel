<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class MakeController extends Controller
{
    public function anyExe(){
        //处理没有值的参数
        $parameters = collect(Request::except('artisan','where','order'))->filter(function($item){
            return $item;
        })->toArray();
        //$parameters = ['name'=>'Admin/TestController','--resource'=>true];
        //执行命令
        $exitCode = Artisan::call(Request::input('artisan'), $parameters);
        return Response::returns(['alert'=>alert(['content'=>'操作成功!'])]);
    }
}
