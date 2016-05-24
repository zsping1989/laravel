<?php
/**
 * 后台用户表
 */
namespace App\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUser extends BaseModel
{
    /* 软删除 */
    use SoftDeletes;
    protected $fillable = [
        'user_id'
    ];

    /* 用户信息 */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /* 角色信息 */
    public function roles(){
        return $this->belongsToMany('App\Models\Role','admin_user_role','role_id','user_id');
    }

    /* 菜单信息 */
    public function menus(){

    }
}
