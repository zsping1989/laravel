<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class NotificationCategorieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        DB::table('notification_categories')->truncate(); //消息分类数据
        Artisan::call('notifynder:create:category', ['name'=>'user.following','text'=>'{from.name}发送了一条消息给你!']);
        Artisan::call('notifynder:create:category', ['name'=>'user.tasks','text'=>'{from.name}任务提醒']);
        Artisan::call('notifynder:create:category', ['name'=>'user.reminds','text'=>'{from.name}消息']);

    }
}
