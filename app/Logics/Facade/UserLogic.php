<?php

/**
 * 通过 PhpStorm 创建.
 * 创建人: 21498
 * 日期: 2016/6/28
 * 时间: 11:07
 */
namespace App\Logics\Facade;
use Illuminate\Support\Facades\Facade;

class UserLogic extends Facade{
    /**
     * 取得组件的注册名称
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'user.logic'; }
}