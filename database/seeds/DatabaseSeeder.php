<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('AreaTableSeeder'); //城市区域数据
        $this->call('MenuTableSeeder'); //创建权限url数据
        $this->call('ApiParamTableSeeder'); //创建权限url数据
        $this->call('RoleTableSeeder'); //创建角色,包括分配权限
        $this->call('UserTableSeeder'); //创建普通用户,分配后台用户,分配后台用户角色
        $this->call('MsgtplTableSeeder'); //创建普通用户,分配后台用户,分配后台用户角色
    }
}
