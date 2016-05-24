<?php
/**
 * 后台角色表
 */
namespace App\Models;

use App\BaseModel;
use App\Exceptions\MarginTree\TreeModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends BaseModel
{
    /* 软删除 */
    use SoftDeletes,TreeModel;
    protected $fillable = [
        'name', 'description' ,'parent_id'
    ];

    /* 角色-权限菜单 */
    public function menus(){
        return $this->belongsToMany('App\Models\Menu');
    }

    /* 角色-用户 */
    public function adminUsers(){
        return $this->belongsToMany('App\Models\AdminUser');
    }
}
