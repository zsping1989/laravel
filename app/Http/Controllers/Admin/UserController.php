<?php

namespace App\Http\Controllers\Admin;

use Custom\Commands\Controllers\ResourceController;
use App\Http\Controllers\Controller;
use App\Logics\Facade\UserLogic;
use App\Models\Admin;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request as ValidateRequest;

class UserController extends Controller
{
    use ResourceController; //资源控制器

    /**
     * 模型绑定
     * MenuController constructor.
     * 参数: Menu $bindModel
     */
    public function __construct(User $bindModel){
        $this->bindModel = $bindModel;
    }

    /**
     * 新增或修改,验证规则获取
     * 返回: array
     */
    protected function getValidateRule(){
        return [
            'uname' => 'sometimes|required|alpha_dash|between:6,18|unique:users,uname',
            'password' => 'sometimes|required|between:6,18',
            'name' => 'required',
            'email' => 'sometimes|required|email|unique:users,email',
            'mobile_phone' => 'sometimes|required|mobile_phone|digits:11|unique:users,mobile_phone',
            'qq' => 'integer'
        ];
    }

    /**
     * 获取菜单数据
     * @return static
     */
    public function getList(){
        $this->handleRequest();
        $obj = $this->checkOrder(); //排序检查
        $page = $obj->options(Request::only('where', 'order'))->paginate();
        $list = $page->count() ? $page->load(['admin']) : [];  //判断用户是否可被删除
        $data= $page->toArray();
        $data['data'] = $list;
        return $this->withParam($data); //附带请求参数返回
    }

    /**
     * 编辑数据页面
     * @param null $id
     */
    public function getEdit($id=null){
        $data = [];
        if($id){
            $data['row'] = $this->bindModel->findOrFail($id);
            $admin = $data['row']->admin;
            if($admin){
                $admin->isAdmin = intval(!!$admin->id);
                $admin->roles;
            }
            //该条用户数据是否可编辑
            $data['row']->disabled = !UserLogic::checkEditUser($data['row']);
        }
        $has_roles = isset($admin->roles) ? $admin->roles: collect([]);
        //获取当前用户所有下属角色
        $self_roles = $this->rolesChildsId(UserLogic::getUserInfo('isSuperAdmin'));
        //列出所有角色,当前用户不可操作的角色禁用
        $data['roles'] = Role::orderBy('left_margin')->get()->each(function($item)use($self_roles,$has_roles){
            $item->checked = in_array($item->id,$has_roles->pluck('id')->toArray()); //当前用户拥有角色
            $item->disabled = !in_array($item->id,$self_roles); //添加用户角色是否可用
            $item->chkDisabled =  $item->disabled;
        });
        return Response::returns($data);
    }

    /**
     * 获取当前用户角色的子角色
     * @return array
     */
    protected function rolesChildsId($all=false,$id=true){
        $res = UserLogic::getAdminRolesAndChilds($all);
        return $id ? $res->pluck('id')->toArray() : $res->toArray() ;
    }

    /**
     * 执行修改或添加
     * 参数 Request $request
     */
    public function postEdit(ValidateRequest $request){
        $id = $request->get('id');
        //新建用户必须验证用户名密码
        if(!$id){
            $request->offsetSet('uname',$request->input('uname'));
            $request->offsetSet('password',$request->input('password'));
        }

        //验证数据
        $this->validate($request,$this->getValidateRule());

        $has_roles = $this->rolesChildsId();
        //修改
        if($id){
            $user = $this->bindModel->findOrFail($id);
            $res =$user->update($request->all());
            if($res===false){
                return Response::returns(['alert'=>alert(['content'=>'修改失败!'],500)]);
            }
            if($request->input('admin.isAdmin')){ //设置成后台管理员
                $old_admin = Admin::withTrashed()->where('user_id','=',$id)->first();
                if(collect($old_admin)->toArray()){
                    $old_admin->restore(); //恢复数据
                    $admin = $old_admin;
                }else{
                    $admin = $user->admin()->save(new Admin([]));
                }
                //修改用户角色
                $new_roles = collect($request->input('new_roles'))->filter(function($item) use($has_roles){
                    return $item >0 && in_array($item,$has_roles);
                })->toArray();
                $admin->roles()->detach($has_roles); //删除旧关联
                $admin->roles()->attach($new_roles); //添加新关联
            }elseif($user->admin){ //删除后台管理员
                $user->admin->delete();
            }
            return Response::returns(['alert'=>alert(['content'=>'修改成功!'])]);
        }
        //密码加密
        $request->offsetSet('password',bcrypt($request->input('password')));
        //新增
        $user = $this->bindModel->create($request->except('id'));
        if($request->input('admin.isAdmin')){ //设置成后台管理员
            $admin = $user->admin()->save(new Admin([]));
            //添加用户角色
            $new_roles = collect($request->input('new_roles'))->filter(function($item) use($has_roles){
                return $item >0 && in_array($item,$has_roles);
            })->toArray();
            $admin->roles()->attach($new_roles);
        }
        if($user===false){
            return Response::returns(['alert'=>alert(['content'=>'新增失败!'],500)]);
        }
        return Response::returns(['alert'=>alert(['content'=>'新增成功!'])]);
    }

    /**
     * 删除数据
     * @return mixed
     */
    public function postDestroy(){
        //管理员不可直接被删除,过滤掉管理员用户
        $ids = $this->bindModel->whereIn('id',collect(Request::input('ids',[]))->all())
            ->get()->load('admin')->filter(function($item){
                return !$item->admin;
            })->pluck('id');
        $res = $this->bindModel->destroy($ids);
        if($res===false){
            return Response::returns(['alert'=>alert(['content'=>'删除失败!'],500)]);
        }
        return Response::returns(['alert'=>alert(['content'=>'删除成功!'])]);
    }

    /**
     * 后台角色用户组织架构图
     * 返回: mixed
     */
    public function getFramework(){
        $roleModel = Role::orderBy('left_margin')->whereRaw('false');
        collect(UserLogic::getUserInfo('admin.roles'))->each(function($item) use(&$roleModel){
            $roleModel->orWhere(function($query) use($item){
                $query->where('left_margin','<=',$item['left_margin'])
                    ->where('right_margin','>=',$item['right_margin']);
            })->orWhere(function($query) use($item){
                $query->where('left_margin','>=',$item['left_margin'])
                    ->where('right_margin','<=',$item['right_margin']);
            });
        });
        //查询跟自己有关系的角色
        $data['roles'] = $roleModel->get()->load('admins.user');
        $level = [];
        foreach($data['roles'] as &$role){
            $role->users = collect($role->admins->toArray())->pluck('user')->implode('name', ',');
            $role->x = ($role->left_margin+$role->right_margin)/2*100;
            $role->y = 115*$role->level;
            if(!isset($level[$role->level])){
                $level[$role->level] = $role->x;
            }
            //每个层级的最远坐标位置
            if($level[$role->level]<$role->x){
                $level[$role->level] = $role->x;
            }
        }
        $min_level = [];
        $data['roles']->map(function($item)use($level,&$min_level){
            if(isset($level[$item['level']+1]) && $level[$item['level']]>$level[$item['level']+1]){
                !$min_level and $min_level = [$item['level'],$level[$item['level']]-$level[$item['level']+1]];
                $item->x =  $item->x-($level[$item['level']]-$level[$item['level']+1]);
            }
            return $item;
        })->map(function($item)use($min_level){
            if($min_level && $item['level']<$min_level[0]){
                $item->x = $item->x - $min_level[1];
            }
            return $item;
        });
        $data['offset'] = $data['roles']->min('x');
        $data['width'] = $data['roles']->max('x')+200-$data['offset'];
        $data['height'] = ($data['roles']->max('level')-$data['roles']->min('level'))*115;

        //dd($min_level);
        //dd($level);

        //return $data;
        return Response::returns($data);
    }

    /**
     * 保存每个节点的坐标位置
     */
    public function postFramework(){
        foreach(Request::input('positions') as $value){
            $res = Role::find($value['id'])->update($value);
            if($res===false){
                return Response::returns(['alert'=>alert(['content'=>'保存失败!'],500)]);
            }
        }
        return Response::returns(['alert'=>alert(['content'=>'保存成功!'])]);
    }
}