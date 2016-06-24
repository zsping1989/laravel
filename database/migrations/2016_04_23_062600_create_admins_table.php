<?php
/**
 * 后台用户表
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->engine = 'InnoDB COMMENT="后台用户"';
            $table->increments('id')->comment('后台用户ID');
            $table->integer('user_id')->index()->unique()->default(0)->comment('用户ID@required|exists:users,id|unique:admins,user_id');
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
        Schema::drop('admins');
    }
}
