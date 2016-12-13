<?php

/**
 * @SWG\Swagger(
 *     basePath="",
 *     host="www.laravels.com",
 *     schemes={"http"},
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="接口API",
 *         @SWG\Contact(name="张世平", url="http://www.laravels.com"),
 *         @SWG\License(name="大家好", url="http://creativecommons.org/licenses/by/4.0/")
 *     ),
 *     @SWG\Tag(name="Admin", description="验证模块"),
 *     @SWG\Tag(name="Index", description="用户模块"),
 *     @SWG\Definition(
 *         definition="Error",
 *         required={"code", "message"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     )
 * )
 */

namespace App\Http\Controllers\Admin;

use App\Logics\Facade\UserLogic;
use App\User;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Message\Facades\Message;

class IndexController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/admin/index/show",
     *   summary="显示所有用户",
     *   tags={"Index"},
     *   @SWG\Parameter(name="Authorization", in="header", required=false, description="用户凭证", type="string"),
     *   @SWG\Parameter(name="aa", in="header", required=false, description="用户凭证", type="string"),
     *     @SWG\Response(
     *     response=200,
     *     description="all users"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function getShow() {
        return User::all();
    }
    /**
     * @SWG\Get(path="/store/inventory",
     *   tags={"store"},
     *   summary="Returns pet inventories by status",
     *   description="Returns a map of status codes to quantities",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   parameters={},
     *   @SWG\Response(
     *     response=200,
     *     description="successful operation",
     *     @SWG\Schema(
     *       type="object",
     *       additionalProperties={
     *         "type":"integer",
     *         "format":"int32"
     *       }
     *     )
     *   ),
     *   security={{
     *     "api_key":{}
     *   }}
     * )
     */



    /**
     * 后台首页
     * 返回: mixed
     */
    public function getIndex(){
        //dd(Storage::disk('f')->put('file.txt', 'Contents'));

  /*      $name = '学院君';
        $flag = Mail::send('emails.register',['name'=>$name],function($message){
            //dd($message);
            $to = '214986304@qq.com';
            $message ->to($to)->subject('测试邮件');
        });
        if($flag){
            echo '发送邮件成功，请查收！';
        }else{
            echo '发送邮件失败，请重试！';
        }
        dd(1);*/
        //dd(sendSMS('13699411148','register',['code'=>'1299'])); //发送短信功能

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
