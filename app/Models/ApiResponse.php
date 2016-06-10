<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiResponse extends Model
{
    use SoftDeletes;
    public function menu(){
        return $this->belongsTo('App\Models\Menu');
    }
}
