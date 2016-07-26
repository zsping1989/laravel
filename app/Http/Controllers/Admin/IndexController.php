<?php

namespace App\Http\Controllers\Admin;

use App\Logics\Facade\UserLogic;
use App\User;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Controller;
use Message\Facades\Message;

class IndexController extends Controller
{
    /**
     * 后台首页
     * 返回: mixed
     */
    public function getIndex(){

        //dd(Message::getCountNotReadByMsgtpl(1,['messages','system.message'])->toArray());
        //dd(UserLogic::getCountNotReadByMsgtpl(['messages','user','system'])->toArray());

       /* dd(User::find(2)->sendMessage('system.message',[
            'user_id'=>1,
            'subject'=>'你好!',
            'content'=>'你好你好'
        ]));*/
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
