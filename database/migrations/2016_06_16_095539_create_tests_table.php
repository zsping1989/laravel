<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('权限ID');
            $table->string('name')->default('')->comment('菜单名称@required');
            $table->integer('method')->default(1)->comment('请求方式:1-get,2-post,3-put');
            $table->tinyInteger('status')->default(2)->comment('状态:1-显示,2-不显示');

            //$table->marginTree(); //树状结构
            $table->integer('parent_id')->default(0)->comment('父级ID');
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
        Schema::drop('tests');
    }
}
