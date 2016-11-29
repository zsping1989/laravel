<?php
/**
 * 测试模型
 */
namespace App\Models;
use App\BaseModel;
use MarginTree\TreeModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends BaseModel
{
    protected $table = 'tests'; //数据表名称

    use TreeModel; //树状结构
    use SoftDeletes; //软删除

    //批量赋值白名单
    protected $fillable = ['id','name','description','parent_id','method','status'];
    //输出隐藏字段
    protected $hidden = ['deleted_at'];
    //日期字段
    protected $dates = ['created_at','updated_at','deleted_at'];

}
