<?php

/**
 * 通过 PhpStorm 创建.
 * 创建人: 21498
 * 日期: 2016/7/15
 * 时间: 17:01
 */
trait Message{
    //用户-用户消息
    public function messages(){
        return $this->hasMany('App\Exceptions\message\src\Models\Message');
    }


}