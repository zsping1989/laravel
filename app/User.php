<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //软删除
    use SoftDeletes;

    //批量赋值白名单
    protected $fillable = [
        'uname','password', 'email' , 'name','mobile_phone','qq','status'
    ];



    //日期字段
    protected $dates = ['deleted_at'];

    //隐藏输出字段
    protected $hidden = [
        'password', 'remember_token','deleted_at'
    ];
    //关系模型
    public function adminUser(){
        return $this->hasOne('App\Models\AdminUser');
    }


}
