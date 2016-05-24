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


} 