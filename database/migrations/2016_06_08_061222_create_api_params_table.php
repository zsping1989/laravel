<?php
/**
 * api接口参数表
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_params', function (Blueprint $table) {
            $table->engine = 'InnoDB COMMENT="接口参数"';
            $table->increments('id')->comment('参数ID');

            $table->integer('menu_id')->index()->default(0)->comment('接口ID@required|exists:menus,id');
            $table->string('name')->default('')->comment('参数名称@required');
            $table->string('title')->default('')->comment('提示@required');
            $table->string('description')->default('')->comment('描述$textarea');
            $table->string('example')->default('')->comment('事例值');
            $table->tinyInteger('required')->default(0)->comment('状态:0-选填,1-必填$radio@in:1,2');

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
        Schema::drop('api_params');
    }
}
