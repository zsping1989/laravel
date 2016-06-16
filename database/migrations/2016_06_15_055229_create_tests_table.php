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
            $table->increments('id');
            $table->string('name')->default('')->comment('菜单名称@required');

            //$table->marginTree(); //树状结构
            $this->integer('parent_id')->default(0)->comment('父级ID');
            $this->smallInteger('level')->default(0)->comment('层级');
            $this->integer('left_margin')->default(0)->comment('左边界');
            $this->integer('right_margin')->default(0)->comment('右边界');
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
