<?php
/**
 * 角色表
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('角色ID');
            $table->string('name')->default('')->comment('角色名称@required');
            $table->string('description')->default('')->comment('描述');

            //$table->marginTree(); //树状结构
            $table->integer('parent_id')->default(0)->comment('父级ID');
            $table->smallInteger('level')->default(0)->comment('层级');
            $table->integer('left_margin')->default(0)->comment('左边界');
            $table->integer('right_margin')->default(0)->comment('右边界');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
    }
}
