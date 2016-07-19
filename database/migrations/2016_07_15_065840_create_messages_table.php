<?php

use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 返回: void
     */
    public function up()
    {
        DB::statement("CREATE TABLE `".config('database.connections.mysql.prefix')."messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `from_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送消息用户ID',
  `msgtpl_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '消息模板ID',
  `subject` varchar(255) NOT NULL DEFAULT '' COMMENT '消息主题',
   `url` varchar(255) NOT NULL DEFAULT '' COMMENT '消息跳转地址',
  `content` text NOT NULL COMMENT '消息内容',
  `read` tinyint(4) NOT NULL COMMENT '是否已读:0-未读,1-已读',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户消息'");
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        DB::statement('drop table '.config('database.connections.mysql.prefix').'messages');
    }
}
