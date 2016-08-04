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
            $table->engine = 'InnoDB COMMENT="菜单"';
            $table->increments('id')->comment('权限ID');
            $table->string('name')->default('')->comment('菜单名称@required');
            $table->string('icons')->default('')->comment('图标@alpha_dash');
            $table->string('description')->default('')->comment('描述$textarea');
            $table->string('prefix')->default('')->comment('URL前缀:-跳转刷新,#-前端刷新$radio');
            $table->string('url')->default('')->comment('URL路径');

            //$table->marginTree(); //树状结构
            $table->integer('parent_id')->default(0)->comment('父级ID@sometimes|required|exists:menus,id');
            $table->integer('method')->default(1)->comment('请求方式:1-get,2-post,3-put$radio@in:1,2,3');
            $table->integer('is_page')->default(0)->comment('是否为页面:0-否,1-是$radio@in:0,1');
            $table->tinyInteger('status')->default(2)->comment('状态:1-显示,2-不显示$radio@in:1,2');
            $table->smallInteger('level')->default(0)->comment('层级');
            $table->integer('left_margin')->default(0)->comment('左边界');
            $table->integer('right_margin')->default(0)->comment('右边界');
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
