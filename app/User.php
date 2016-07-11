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
    public function admin(){
        return $this->hasOne('App\Models\Admin');
    }

    public function scopeOptions($query,array $options=[])
    {
        //条件筛选
        collect($options['where'])->each(function($item,$key) use(&$query){
            $val = $item->exp=='like' ? '%'.preg_replace('/([_%])/','\\\$1', $item->val).'%' : $item->val;
            $item and $query->where($item->key,$item->exp,$val);
        });
        //排序
        collect($options['order'])->each(function($item,$key) use (&$query){
            $item and $query->orderBy($key,$item);
        });
        return $query;
    }


}
