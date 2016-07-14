<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //初始化数据表
        DB::table('users')->truncate(); //用户表
        DB::table('admins')->truncate(); //后台用户表
        DB::table('admin_role')->truncate(); //角色关联表
        //创建一个超级管理员用户
        $superUser = factory(\App\User::class)->make([
            'uname'=>'zsping1989',
            'name'=>'系统',
            'email'=>'214986304@qq.com',
            'password'=>bcrypt(123456),
            'mobile_phone'=>'13699411148',
            'qq'=>214986304
        ]);
        $superUser->save(); //创建用户
        $superUser->admin() //访问关联
         ->save(factory(App\Models\Admin::class)->make()) //创建关联后台用户
         ->roles()->save(\App\Models\Role::find(1)); //分配超级管理员角色
        //创建一个只有查看权限的后台普通用户
        $admin = factory(\App\User::class)->make([
            'uname'=>'zsping',
            'name'=>'张世平',
            'email'=>'21498630@qq.com',
            'password'=>bcrypt(123456),
            'mobile_phone'=>'1369941114'
        ]);
        $admin->save(); //创建用户
        $admin->admin() //访问关联
            ->save(factory(App\Models\Admin::class)->make()) //创建关联后台用户
            ->roles()->save(\App\Models\Role::find(2)); //分配超级管理员角色

        factory(\App\User::class,3)->create(); //随机数据3个前台用户
    }
}
