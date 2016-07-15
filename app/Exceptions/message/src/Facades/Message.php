<?php

/**
 * 通过 PhpStorm 创建.
 * 创建人: 21498
 * 日期: 2016/7/15
 * 时间: 17:19
 */
namespace App\Exceptions\message\src\Facades;

interface Message{

    /**
     * 读取一条消息,并标记为已读
     * @param $id
     * 返回: mixed
     */
    public function readOne($id);

    /**
     * 获取最新的一条消息
     * @param $user_id
     * @param null $msgtpl_id
     * 返回: mixed
     */
    public function getLastMessage($user_id,$msgtpl_id=null);

    /**
     * 获取所有未读消息
     * @param $user_id
     * @param null $msgtpl_id
     * 返回: mixed
     */
    public function getAllNotRead($user_id,$msgtpl_id=null);
}