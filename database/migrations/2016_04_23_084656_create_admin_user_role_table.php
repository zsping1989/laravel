<?php
/**
 * 角色-后台用户关联表
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_role', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('user_id')->index()->defualt(0)->comment('用户ID');
            $table->integer('role_id')->index()->defualt(0)->comment('角色ID');
            $table->primary(['user_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_user_role');
    }
}
