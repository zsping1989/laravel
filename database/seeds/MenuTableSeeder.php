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
            'url'=>'#',
            'description' => '根节点'
        ]);

        factory(\App\Models\Menu::class)->create([
            'name'=>'后台首页',
            'icons'=>'fa-dashboard',
            'url'=>'/Admin/index',
            'description' => '后台首页',
            'parent_id'=>1,
            'status'=>1
        ]);
        factory(\App\Models\Menu::class)->create([
            'name'=>'登录页面',
            'icons'=>'fa-circle-o',
            'url'=>'/Admin/login',
            'description' => '后台登录',
            'parent_id'=>1,
            'status'=>1
        ]);
        factory(\App\Models\Menu::class)->create([
            'name'=>'菜单测试',
            'icons'=>'fa-th',
            'url'=>'/Admin/index',
            'description' => '后台首页',
            'parent_id'=>2,
            'status'=>1
        ]);
        factory(\App\Models\Menu::class)->create([
            'name'=>'菜单测一',
            'icons'=>'fa-th',
            'url'=>'/Admin/index',
            'description' => '后台首页',
            'parent_id'=>2,
            'status'=>1
        ]);
        //新建假数据3条
        //factory(\App\Models\Menu::class,3)->create();
    }
}
