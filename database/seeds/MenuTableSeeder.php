<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //初始化数据表
        DB::table('menus')->truncate(); //菜单权限表

        //创建权限数据
        factory(\App\Models\Menu::class)->create([
            'name'=>'菜单列表',
            'url'=>'',
            'description' => '根节点'
        ]);

        factory(\App\Models\Menu::class)->create([
            'name'=>'菜单目录',
            'icons'=>'fa-dashboard',
            'url'=>'',
            'description' => '后台首页',
            'parent_id'=>1,
            'status'=>1
        ]);
        factory(\App\Models\Menu::class)->create([
            'name'=>'前端模块',
            'icons'=>'fa-wrench',
            'url'=>'',
            'description' => '后台登录',
            'parent_id'=>1,
            'status'=>1
        ]);
        factory(\App\Models\Menu::class)->create([
            'name'=>'登录页面',
            'icons'=>'fa-th',
            'url'=>'/home/auth/login',
            'description' => '后台首页',
            'parent_id'=>3,
            'status'=>1
        ]);
        factory(\App\Models\Menu::class)->create([
            'name'=>'后台主页',
            'icons'=>'fa-th',
            'url'=>'/admin/index',
            'description' => '后台首页',
            'parent_id'=>2,
            'status'=>1
        ]);

        factory(\App\Models\Menu::class)->create([
            'name'=>'菜单管理',
            'icons'=>'fa-th',
            'url'=>'/admin/menu/index',
            'description' => '后台首页',
            'parent_id'=>2,
            'status'=>1
        ]);

        factory(\App\Models\Menu::class)->create([
            'name'=>'创建代码',
            'icons'=>'fa-circle-o',
            'url'=>'',
            'description' => '后台登录',
            'parent_id'=>1,
            'status'=>1
        ]);
        factory(\App\Models\Menu::class)->create([
            'name'=>'用户管理',
            'icons'=>'fa-users',
            'url'=>'',
            'description' => '后台登录',
            'parent_id'=>1,
            'status'=>1
        ]);
        factory(\App\Models\Menu::class)->create([
            'name'=>'个人中心',
            'icons'=>'fa-heart',
            'url'=>'',
            'description' => '后台登录',
            'parent_id'=>1,
            'status'=>1
        ]);
        factory(\App\Models\Menu::class)->create([
            'name'=>'其它板块',
            'icons'=>'fa-wrench',
            'url'=>'',
            'description' => '后台登录',
            'parent_id'=>1,
            'status'=>1
        ]);

        //新建假数据3条
        //factory(\App\Models\Menu::class,3)->create();
    }
}
