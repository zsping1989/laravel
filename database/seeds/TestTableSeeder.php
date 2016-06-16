<?php

use Illuminate\Database\Seeder;

class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //初始化数据表
        DB::table('tests')->truncate(); //菜单权限表
        factory(\App\Models\Test::class,30)->create();
    }
}
