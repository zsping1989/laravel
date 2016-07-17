<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * 后台首页
     * 返回: mixed
     */
    public function getIndex(){
        User::find(1)->sendMessage(2,'messages','你好!');
        return Response::returns([]);
    }

    /**
     * 404错误页面
     * 返回: mixed
     */
    public function getPage404(){
        return Response::returns([]);
    }

    /**
     *  500错误页面
     * 返回: mixed
     */
    public function getPage500(){
        return Response::returns([]);
    }






}
