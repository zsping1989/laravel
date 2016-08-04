<?php
/**
 * api接口参数
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiParam extends Model
{
    use SoftDeletes;
    //批量赋值白名单
    protected $fillable = ['id','menu_id','name','title','description','example','required'];
    //参数-接口
    public function menu(){
        return $this->belongsTo('App\Models\Menu');
    }
}
