<?php
/**
 * 用户表
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB COMMENT="用户"';
            $table->increments('id')->comment('用户ID');
            $table->string('uname')->index()->default('')->unique()->comment('用户名@sometimes|required|alpha_dash|between:6,18|unique:users,uname');
            $table->string('password')->default('')->comment('密码$password@sometimes|required|digits_between:6,18');
            $table->string('name')->default('')->comment('昵称@required');
            $table->string('email')->index()->default('')->unique()->comment('电子邮箱@sometimes|required|email|unique:users,email');
            $table->string('mobile_phone',11)->index()->default('')->unique()->comment('电话@sometimes|required|mobile_phone|digits:11|unique:users,mobile_phone');
            $table->integer('qq')->index()->default(0)->unique()->comment('QQ号码@integer');
            $table->rememberToken();
            $table->tinyInteger('status')->default(0)->comment('状态:0-未激活,1-已激活$radio');
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
        Schema::drop('users');
    }
}
