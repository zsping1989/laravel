<?php
/**
 * @SWG\Swagger(
 *   @SWG\Info(
 *     title="接口API",
 *     version="1.0.0"
 *   ),
 *   @SWG\Tag(name="Admin", description="验证模块"),
 *   @SWG\Tag(name="Index", description="用户模块"),
 *   schemes={"http"},
 *   host="www.laravels.com",
 *   basePath="/data/admin"
 * )
 */

namespace App\Http\Controllers\Admin;

use App\Logics\Facade\UserLogic;
use App\User;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Controller;
use Message\Facades\Message;

class IndexController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/show",
     *   summary="显示所有用户",
     *   tags={"Index"},
     *   @SWG\Parameter(name="Authorization", in="header", required=false, description="用户凭证", type="string"),
     *   @SWG\Response(
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
