<?php
/**
 * 个人中心
 */
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Logics\Facade\UserLogic;
use App\User;
use Fenos\Notifynder\Facades\Notifynder;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request as ValidateRequest;

class ProfileController extends Controller{


    /**
     * 修改密码
     */
    public function getPassword(){
        return Response::returns(['row'=>['token'=>csrf_token()]]);
    }

    /**
     * 执行密码修改
     * 返回: mixed
     */
    public function postPassword(ValidateRequest $request){
        //验证
        $this->validate($request,$this->getValidateRestPasswordRule());
        $user = UserLogic::getUser();
        $user->update(['password'=> bcrypt($request->input('password'))]);
        return ['alert'=>alert(['content'=>'修改密码成功!'])];
    }

    /**
     * 修改密码重置验证
     * 返回: array
     */
    protected function getValidateRestPasswordRule(){
        return ['old_password'=>'required|ckeck_password','password'=>'required|digits_between:6,18|confirmed'];
    }

    /**
     * 个人资料修改
     */
    public function getInfo(){
        return Response::returns(['row'=>UserLogic::getUser()]);
    }

    /**
     * 执行修改资料
     */
    public function postInfo(ValidateRequest $request){
        //验证字段
        $this->validate($request,$this->getValidateUserInfo());
        //只允许修改字段
        $only = $request->has('mobile_phone') ? ['mobile_phone','name'] : ['name'];
        //修改个人资料
        UserLogic::getUser()->update($request->only($only));
        //弹窗消息
        return ['alert'=>alert(['content'=>'修改资料!'])];
    }

    /**
     * 个人资料修改验证规则
     * 返回: array
     */
    protected function getValidateUserInfo(){
        return [
            'mobile_phone'=>'sometimes|required|mobile_phone|digits:11|unique:users,mobile_phone',
            'name'=>'required'
        ];
    }





}