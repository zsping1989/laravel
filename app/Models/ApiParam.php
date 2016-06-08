<?php
/**
 * api接口参数
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiParam extends Model
{
    public function menu(){
        return $this->belongsTo('App\Models\Menu');
    }
}
