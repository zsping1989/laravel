<?php

namespace App\Http\Controllers\Admin;

use App\Logics\Facade\UserLogic;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * 后台首页
     * 返回: mixed
     */
    public function getIndex(){


       /* return User::find(2)->sendMessage('user.message',[
            'user_id'=>1,
            'subject'=>'你好!',
            'content'=>'你好你好'
        ]);*/
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
