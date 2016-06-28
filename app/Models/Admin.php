<?php
/**
 * 后台用户表
 */
namespace App\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends BaseModel
{
    /* 软删除 */
    use SoftDeletes;
    protected $fillable = ['user_id'];

    //隐藏输出字段
    protected $hidden = ['deleted_at'];
    /* 用户信息 */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /* 角色信息 */
    public function roles(){
        return $this->belongsToMany('App\Models\Role','admin_role','admin_id','role_id');
    }


}
