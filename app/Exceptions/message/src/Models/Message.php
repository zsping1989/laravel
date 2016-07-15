<?php
/**
 * 用户消息模型
 */
namespace App\Exceptions\message\src\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages'; //数据表名称


    //批量赋值白名单
    protected $fillable = ['id','user_id','from_id','msgtpl_id','subject','content','read'];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = ['created_at','updated_at'];

    //用户消息-用户
    public function user(){
        return $this->belongsTo('App\User');
    }

    //用户消息-消息模板
    public function msgtpl(){

    }
  
  }
