<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiResponse extends Model
{
    use SoftDeletes;
    protected $fillable = ['id','menu_id','name','description'];
    public function menu(){
        return $this->belongsTo('App\Models\Menu');
    }
}
