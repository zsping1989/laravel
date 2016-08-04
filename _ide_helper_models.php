<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\BaseModel
 *
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModel options($options = array())
 */
	class BaseModel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property integer $id 后台用户ID
 * @property integer $user_id 用户ID@required|exists:users,id|unique:admins,user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModel options($options = array())
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ApiParam
 *
 * @property integer $id 参数ID
 * @property integer $menu_id 接口ID@required|exists:menus,id
 * @property string $name 参数名称@required
 * @property string $title 提示@required
 * @property string $description 描述$textarea
 * @property string $example 事例值
 * @property boolean $required 状态:0-选填,1-必填$radio@in:1,2
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Models\Menu $menu
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiParam whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiParam whereMenuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiParam whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiParam whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiParam whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiParam whereExample($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiParam whereRequired($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiParam whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiParam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiParam whereDeletedAt($value)
 */
	class ApiParam extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ApiResponse
 *
 * @property integer $id 响应说明ID
 * @property integer $menu_id 接口ID@required|exists:menus,id
 * @property string $name 结果字段@required|alpha_dash
 * @property string $description 描述$textarea
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Models\Menu $menu
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiResponse whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiResponse whereMenuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiResponse whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiResponse whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApiResponse whereDeletedAt($value)
 */
	class ApiResponse extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Area
 *
 * @property integer $id 区域ID
 * @property string $name 名称@required
 * @property boolean $status 状态:1-显示,2-不显示$radio@in:1,2
 * @property integer $parent_id 父ID@sometimes|required|exists:areas,id
 * @property integer $level 层级
 * @property integer $left_margin 左边界
 * @property integer $right_margin 右边界
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Area whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Area whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Area whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Area whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Area whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Area whereLeftMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Area whereRightMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Area whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Area whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Area whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModel options($options = array())
 */
	class Area extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Menu
 *
 * @property integer $id 权限ID
 * @property string $name 菜单名称@required
 * @property string $icons 图标@alpha_dash
 * @property string $description 描述$textarea
 * @property string $prefix URL前缀:-跳转刷新,#-前端刷新$radio
 * @property string $url URL路径
 * @property integer $parent_id 父级ID@sometimes|required|exists:menus,id
 * @property integer $method 请求方式:1-get,2-post,3-put$radio@in:1,2,3
 * @property integer $is_page 是否为页面:0-否,1-是$radio@in:0,1
 * @property boolean $status 状态:1-显示,2-不显示$radio@in:1,2
 * @property integer $level 层级
 * @property integer $left_margin 左边界
 * @property integer $right_margin 右边界
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ApiParam[] $params
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ApiResponse[] $responses
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereIcons($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu wherePrefix($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereIsPage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereLeftMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereRightMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Menu whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModel options($options = array())
 */
	class Menu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property integer $id 角色ID
 * @property string $name 角色名称@required
 * @property string $description 描述$textarea
 * @property integer $x 架构图X坐标$hidden@sometimes|integer
 * @property integer $y 架构图Y坐标$hidden@sometimes|integer
 * @property integer $parent_id 父级ID@sometimes|required|exists:roles,id
 * @property integer $level 层级
 * @property integer $left_margin 左边界
 * @property integer $right_margin 右边界
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Menu[] $menus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin[] $admins
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereX($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereY($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereLeftMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereRightMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModel options($options = array())
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Test
 *
 * @property integer $id 测试ID
 * @property string $name 测试名称@required
 * @property string $description 描述$textarea
 * @property integer $parent_id 父级ID@sometimes|required|exists:tests,id
 * @property integer $method 请求方式:1-get,2-post,3-put$radio@in:1,2,3
 * @property boolean $status 状态:1-显示,2-不显示$radio@in:1,2
 * @property integer $level 层级
 * @property integer $left_margin 左边界
 * @property integer $right_margin 右边界
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Test whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Test whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Test whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Test whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Test whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Test whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Test whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Test whereLeftMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Test whereRightMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Test whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Test whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Test whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BaseModel options($options = array())
 */
	class Test extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property integer $id 用户ID
 * @property string $uname 用户名@sometimes|required|alpha_dash|between:6,18|unique:users,uname
 * @property string $password 密码$password@sometimes|required|digits_between:6,18
 * @property string $name 昵称@required
 * @property string $email 电子邮箱@sometimes|required|email|unique:users,email
 * @property string $mobile_phone 电话@sometimes|required|mobile_phone|digits:11|unique:users,mobile_phone
 * @property integer $qq QQ号码@integer
 * @property string $remember_token
 * @property boolean $status 状态:0-未激活,1-已激活$radio
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Models\Admin $admin
 * @property-read \Illuminate\Database\Eloquent\Collection|\Message\Models\Message[] $messages
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereMobilePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereQq($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User options($options = array())
 */
	class User extends \Eloquent {}
}

