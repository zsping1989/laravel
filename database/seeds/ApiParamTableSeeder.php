<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ApiParamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('api_params')->truncate(); //参数表

        //登录参数
        factory(\App\Models\ApiParam::class)->create([
            'menu_id'=>10,
            'name'=>'username',
            'title'=>'用户名/邮箱/手机号',
            'description'=>'填写用户名或者邮箱或手机号',
            'example'=>'13699411148',
            'required'=>1
        ]);
        factory(\App\Models\ApiParam::class)->create([
            'menu_id'=>10,
            'name'=>'password',
            'title'=>'密码',
            'description'=>'填写密码',
            'example'=>'123456',
            'required'=>1
        ]);
    }
}
