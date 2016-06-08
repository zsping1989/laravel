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
            $table->increments('id');

            $table->integer('menu_id')->index()->default(0)->comment('接口ID');
            $table->string('name')->default('')->comment('参数名称@required');
            $table->string('title')->default('')->comment('提示');
            $table->string('description')->default('')->comment('描述');
            $table->string('example')->default('')->comment('事例值');
            $table->tinyInteger('required')->default(0)->comment('状态:0-选填,1-必填');

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
