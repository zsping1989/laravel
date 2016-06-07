<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Config;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE TABLE `".Config::get('database.connections.mysql.prefix')."areas` (
                      `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '区域ID',
                      `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称@required',
                      `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态:1-显示,2-不显示',
                      `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
                      `level` smallint(6) NOT NULL DEFAULT '0' COMMENT '层级',
                      `left_margin` int(11) NOT NULL DEFAULT '0' COMMENT '左边界',
                      `right_margin` int(11) NOT NULL DEFAULT '0' COMMENT '右边界',
                      `created_at` timestamp NULL DEFAULT NULL,
                      `updated_at` timestamp NULL DEFAULT NULL,
                      `deleted_at` timestamp NULL DEFAULT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop table '.Config::get('database.connections.mysql.prefix').'areas');
    }
}
