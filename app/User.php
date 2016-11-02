<?php

namespace App;

use Message\Message;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //软删除
    use SoftDeletes;
    use Message;

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

    //用户-后台用户
    public function admin(){
        return $this->hasOne('App\Models\Admin');
    }



    public function scopeOptions($query,array $options=[])
    {
        //条件筛选
        collect($options['where'])->each(function($item,$key) use(&$query){
            if(!$item || $item['val']===''){
                return ;
            }
            //like匹配
            if($item['exp']=='like'){
                $val = '%'.preg_replace('/([_%\'"])/','\\\$1', $item['val']).'%';
                //时间戳处理
            }else if(isset($item['type'])&&($item['type']=='dateStart' || $item['type']=='dateEnd')){
                //dd($item['val']);
                $val = $item['type']=='dateStart' ? strtotime($item['val'].' 00:00:00') : strtotime($item['val'].' 23:59:59');
                //其它
            }else{
                $val = $item['val'];
            }

            if($item['exp']=='in'){
                $query->whereIn($item['key'],explode(',',$val));
            }elseif($item['exp']=='like'){
                $fileds = explode('|',$item['key']);
                if(count($fileds)>1){
                    $item['key'] = 'concat(`'.implode('`,`',$fileds).'`)';
                    $query->whereRaw($item['key'].' like "'.$val.'"');
                }else{
                    $query->where($item['key'],$item['exp'],$val);
                }
            }else{
                $query->where($item['key'],$item['exp'],$val);
            }
        });
        //排序
        isset($options['order']) AND collect($options['order'])->each(function($item,$key) use (&$query){
            $item and $query->orderBy($key,$item);
        });
        return $query;
    }





}
