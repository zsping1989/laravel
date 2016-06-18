<?php

use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 返回: void
     */
    public function up()
    {
        DB::statement("CREATE TABLE `".config('database.connections.mysql.prefix')."tests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限ID',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称@required',
  `method` int(11) NOT NULL DEFAULT '1' COMMENT '请求方式:1-get,2-post,3-put',
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '状态:1-显示,2-不显示',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `level` smallint(6) NOT NULL DEFAULT '0' COMMENT '层级',
  `left_margin` int(11) NOT NULL DEFAULT '0' COMMENT '左边界',
  `right_margin` int(11) NOT NULL DEFAULT '0' COMMENT '右边界',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='测试'}");
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        DB::statement('drop table '.config('database.connections.mysql.prefix').'tests');
    }
}
