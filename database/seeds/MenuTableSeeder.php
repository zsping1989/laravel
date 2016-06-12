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
        //顶级菜单 ID:1
        factory(\App\Models\Menu::class)->create([
            'name'=>'菜单列表',
            'url'=>'',
            'description' => '根节点,所有菜单的父节点'
        ]);

        //ID:2
        factory(\App\Models\Menu::class)->create([
            'name'=>'控制面板',
            'icons'=>'fa-dashboard',
            'url'=>'',
            'description' => '',
            'parent_id'=>1,
            'status'=>1
        ]);
        //ID:3
        factory(\App\Models\Menu::class)->create([
            'name'=>'开发工具',
            'icons'=>'fa-circle-o',
            'url'=>'',
            'description' => '开发模块',
            'parent_id'=>1,
            'status'=>1
        ]);

        //ID:4
        factory(\App\Models\Menu::class)->create([
            'name'=>'前端模块',
            'icons'=>'fa-wrench',
            'url'=>'',
            'description' => '前端所有路由',
            'parent_id'=>1,
            'status'=>1
        ]);
        //ID:5
        factory(\App\Models\Menu::class)->create([
            'name'=>'用户管理',
            'icons'=>'fa-users',
            'url'=>'',
            'description' => '用户模块',
            'parent_id'=>1,
            'status'=>1
        ]);
        //ID:6
        factory(\App\Models\Menu::class)->create([
            'name'=>'个人中心',
            'icons'=>'fa-heart',
            'url'=>'',
            'description' => '个人资料',
            'parent_id'=>1,
            'status'=>1
        ]);
        //ID:7
        factory(\App\Models\Menu::class)->create([
            'name'=>'其它板块',
            'icons'=>'fa-wrench',
            'url'=>'',
            'description' => '后台登录',
            'parent_id'=>1,
            'status'=>1
        ]);
        //ID:8
        factory(\App\Models\Menu::class)->create([
            'name'=>'创建代码',
            'icons'=>'fa-mouse-pointer',
            'prefix'=>'#',
            'url'=>'/admin/create-code',
            'description' => '创建代码',
            'parent_id'=>3,
            'status'=>1
        ]);
        //ID:9
        factory(\App\Models\Menu::class)->create([
            'name'=>'接口文档',
            'icons'=>'fa-asterisk',
            'prefix'=>'#',
            'url'=>'/admin/api',
            'description' => '接口说明',
            'parent_id'=>3,
            'status'=>1
        ]);
        //ID:10
        factory(\App\Models\Menu::class)->create([
            'name'=>'登录页面',
            'icons'=>'fa-th',
            'url'=>'/home/auth/login',
            'description' => '后台首页',
            'method'=>2,
            'parent_id'=>4,
            'status'=>1
        ]);
        //ID:11
        factory(\App\Models\Menu::class)->create([
            'name'=>'退出登录',
            'icons'=>'fa-th',
            'prefix'=>'',
            'url'=>'/home/auth/logout',
            'description' => '后台首页',
            'parent_id'=>4,
            'status'=>1
        ]);
        //ID:12
        factory(\App\Models\Menu::class)->create([
            'name'=>'后台主页',
            'icons'=>'fa-th',
            'prefix'=>'#',
            'url'=>'/admin/index',
            'description' => '后台首页',
            'parent_id'=>2,
            'status'=>1
        ]);
        //ID:13
        factory(\App\Models\Menu::class)->create([
            'name'=>'菜单管理',
            'icons'=>'fa-th',
            'prefix'=>'#',
            'url'=>'/admin/menu/index',
            'description' => '后台首页',
            'parent_id'=>2,
            'status'=>1
        ]);
        //ID:14
        factory(\App\Models\Menu::class)->create([
            'name'=>'测试接口',
            'icons'=>'fa-th',
            'prefix'=>'#',
            'url'=>'/admin/111ex',
            'description' => '后台首页',
            'parent_id'=>13,
            'status'=>1
        ]);



        //新建假数据3条
        //factory(\App\Models\Menu::class,3)->create();
    }
}
