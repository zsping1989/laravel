<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;

class MakeController extends Controller
{
    public function postExe(){
        //处理没有值的参数
        $parameters = collect(Request::except('artisan','where','order'))->filter(function($item){
            return $item;
        })->toArray();
        //执行命令
        $exitCode = Artisan::call(Request::input('artisan'), $parameters);
        dd($exitCode);
    }
}
