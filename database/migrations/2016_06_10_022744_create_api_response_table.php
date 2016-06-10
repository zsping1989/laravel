<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_responses', function (Blueprint $table) {
            $table->increments('id')->comment('响应说明ID');

            $table->integer('menu_id')->index()->default(0)->comment('接口ID');
            $table->string('name')->default('')->comment('结果字段@required');
            $table->string('description')->default('')->comment('描述');

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
        Schema::drop('api_responses');
    }
}
