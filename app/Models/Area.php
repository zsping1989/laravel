<?php
/**
 * 地区模型
 */
namespace App\Models;
use App\BaseModel;
use MarginTree\TreeModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends BaseModel
{

    use TreeModel; //树状结构
    use SoftDeletes; //软删除

    //批量赋值白名单
    protected $fillable = ['id','name','status','parent_id'];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];
  
  }
