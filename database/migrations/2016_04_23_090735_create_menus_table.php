<?php
/**
 * 后台菜单表
 */

use Illuminate\Database\Migrations\Migration;
use \Illuminate\Database\Schema\Blueprint;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('权限ID');
            $table->string('name')->default('')->comment('菜单名称@required');
            $table->string('icons')->default('')->comment('图标');
            $table->string('description')->default('')->comment('描述');
            $table->string('prefix')->default('')->comment('URL前缀:-跳转刷新,#-前端刷新');
            $table->string('url')->default('')->comment('URL路径');
            $table->tinyInteger('status')->default(2)->comment('状态:1-显示,2-不显示');

            $table->marginTree(); //树状结构
            $table->timestamps(); //时间戳记录
            $table->softDeletes(); //软删除
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menus');
    }
}
