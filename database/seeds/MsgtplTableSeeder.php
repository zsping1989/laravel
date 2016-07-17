<?php

use Message\Models\Msgtpl;
use Illuminate\Database\Seeder;

class MsgtplTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('msgtpls')->truncate(); //消息模板表

        //ID:1
        Msgtpl::create([
            'name'=>'messages',
            'title'=>'消息通知',
            'description'=>'',
        ]); //顶级消息分类

        //ID:2
        Msgtpl::create([
            'name'=>'user',
            'title'=>'{from.name}发来消息',
            'description'=>'用户消息组',
            'parent_id'=>1
        ]); //用户消息组

        //ID:3
        Msgtpl::create([
            'name'=>'user.message',
            'title'=>'{from.name}给你发来一封新邮件',
            'description'=>'用户消息普通消息',
            'parent_id'=>2
        ]); //用户消息

        //ID:4
        Msgtpl::create([
            'name'=>'user.like',
            'title'=>'{from.name}给你点了赞',
            'description'=>'用户消息普通消息',
            'parent_id'=>2
        ]); //用户消息

        //ID:5
        Msgtpl::create([
            'name'=>'system',
            'title'=>'系统提醒',
            'description'=>'系统消息分组',
            'parent_id'=>1
        ]); //系统提醒组

        //ID:5
        Msgtpl::create([
            'name'=>'system.message',
            'title'=>'{to.name}的邮箱认证失败',
            'description'=>'系统提醒普通消息',
            'parent_id'=>5
        ]); //系统提醒组



    }
}
