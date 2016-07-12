<?php
/**
 * 个人中心
 */
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Logics\Facade\UserLogic;
use Illuminate\Support\Facades\Auth;
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
        //确认旧密码
        if(!Auth::validate(['email' => $user['email'], 'password' => $request->input('old_password')])){
            return Response::returns(['old_password'=>'密码错误请重新输入!'],422);
        }
        $user->update(['password'=> bcrypt($request->input('password'))]);
        return ['alert'=>alert(['content'=>'修改密码成功!'])];
    }

    /**
     * 修改密码重置验证
     * 返回: array
     */
    protected function getValidateRestPasswordRule(){
        return ['old_password'=>'required','password'=>'required|digits_between:6,18|confirmed'];
    }

    /**
     * 个人资料修改
     */
    public function getInfo(){
        return Response::returns(['row'=>UserLogic::getUser()]);
    }





}