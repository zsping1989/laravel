<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //初始化数据表
        DB::table('roles')->truncate(); //角色表
        DB::table('menu_role')->truncate(); //角色权限关联表
        //添加最高权限角色
        factory(\App\Models\Role::class)->create([
            'name'=>'超级管理员',
            'description' => '拥有所有操作权限'
        ]);
        //添加测试用户角色
        $role = factory(\App\Models\Role::class)->create([
            'name'=>'观察用户',
            'description' => '只拥有查看权限',
        ]);
        //添加测试用户权限列表
        $role->menus()->saveMany(
            \App\Models\Menu::whereIn('id',[2,5,12,22,23,24,25,37,39])->get()->all()
          );

        factory(\App\Models\Role::class)->create([
            'name'=>'观察者下级用户',
            'description' => '只拥有查看权限',
            'parent_id'=>$role->id
        ]);
    }
}
