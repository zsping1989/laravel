<?php

use Illuminate\Database\Migrations\Migration;

class CreateMsgtplsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 返回: void
     */
    public function up()
    {
        DB::statement("CREATE TABLE `".config('database.connections.mysql.prefix')."msgtpls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '消息模板名称@sometimes|required|alpha_dash',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '消息提醒',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '模板说明',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID@sometimes|required|exists:msgtpls,id',
  `level` smallint(6) NOT NULL DEFAULT '0' COMMENT '层级',
  `left_margin` int(11) NOT NULL DEFAULT '0' COMMENT '左边界',
  `right_margin` int(11) NOT NULL DEFAULT '0' COMMENT '右边界',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='消息模板'");
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        DB::statement('drop table '.config('database.connections.mysql.prefix').'msgtpls');
    }
}
