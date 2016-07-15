<?php
/**
 * 消息模板模型
 */
namespace App\Exceptions\message\src\Models;

use Illuminate\Database\Eloquent\Model;
use MarginTree\TreeModel;

class Msgtpl extends Model
{
    protected $table = 'msgtpls'; //数据表名称

    use TreeModel; //树状结构

    //批量赋值白名单
    protected $fillable = ['id','name','title','description','parent_id'];
    //输出隐藏字段
    protected $hidden = [];
    //日期字段
    protected $dates = ['created_at','updated_at'];

    //消息模板-用户消息
    public function messges(){

    }
  
  }
