<?php
/**
 * 通过 PhpStorm 创建.
 * 创建人: zhangshiping
 * 日期: 16-5-3
 * 时间: 上午11:19
 *
 * 验证扩展类
 *
 */

namespace App\Exceptions;


use App\Logics\Facade\UserLogic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class CustomValidator extends Validator{

    /**
     * 验证手机号码
     * 参数: $attribute
     * 参数: $value
     * 参数: $parameters
     * 返回: bool
     */
    public function validateMobilePhone($attribute, $value, $parameters)
    {
        if(!$value) return false;
        return preg_match("/^1[34578]\\d{9}$/", $value);
    }

    /**
     * 验证是否为空
     * 参数: $attribute
     * 参数: $value
     * 参数: $parameters
     * 返回: bool
     */
    public function validateIsNull($attribute, $value, $parameters)
    {
        return empty($value);
    }

    /**
     * 验证用户输入密码是否正确
     * @param $attribute
     * @param $value
     * @param $parameters
     * 返回: mixed
     */
    public function validateCkeckPassword($attribute, $value, $parameters){
        $user = UserLogic::getUser(); //获取当前用户
        return Auth::validate(['uname' => $user['uname'], 'password' => $value]); //验证
    }

    /**
     * 验证验证码
     * 参数: $attribute
     * 参数: $value
     * 参数: $parameters
     * 返回: bool
     */
    public function validateVerifyCode($attribute, $value, $parameters)
    {
        $verify_code_key = config('auth.verify_code_key');
        if($value!=\Session::get($verify_code_key)){
            return false;
        }
        \Session::forget($verify_code_key);
        return true;
    }

} 