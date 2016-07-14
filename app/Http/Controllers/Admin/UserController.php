<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ResourceController;
use App\Http\Controllers\Controller;
use App\Logics\Facade\UserLogic;
use App\Models\Admin;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\DB;
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
        return ['uname'=>'sometimes|required|alpha_dash|between:6,18|unique:users,uname','password'=>'sometimes|required|digits_between:6,18','name'=>'required','email'=>'sometimes|required|email|unique:users,email','mobile_phone'=>'sometimes|required|mobile_phone|digits:11|unique:users,mobile_phone','qq'=>'integer'];
    }

    /**
     * 获取菜单数据
     * @return static
     */
    public function getList(){
        $this->handleRequest();
        $obj = $this->checkOrder(); //排序检查
        $data = $obj->options(Request::only('where', 'order'))->paginate();
        //判断用户是否可被删除
        $data->load('admin'); //是后台用户不可直接被删除
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
        //验证数据
        $this->validate($request,$this->getValidateRule());
        $id = $request->get('id');
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
                if($old_admin->toArray()){
                    $old_admin->restore(); //恢复数据
                    $admin = $old_admin;
                }else{
                    $admin = $user->admin()->save(new Admin([]));
                }
                //修改用户角色
                $new_roles = collect($request->input('new_roles'))->filter(function($item) use($has_roles){
                    return $item >0 && in_array($item,$has_roles);
                })->toArray();
                $new_roles AND $admin->roles()->detach($new_roles);
                $admin->roles()->attach($new_roles);
            }elseif($user->admin){ //删除后台管理员
                $user->admin->delete();
            }
            return Response::returns(['alert'=>alert(['content'=>'修改成功!'])]);
        }

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
        $ids = $this->bindModel->whereIn('id',Request::input('ids',[]))
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
        //查询所有角色
        $data['roles'] = Role::orderBy('left_margin')->get()->load('admins.user');
        $level = [];
        foreach($data['roles'] as &$role){
            $role->users = collect($role->admins->toArray())->pluck('user')->implode('name', ',');
            if(!isset($level[$role->level])){
                $level[$role->level] = 0;
            }
            $role->level_num = $level[$role->level];
            ++$level[$role->level];
        }
        //查询层级最多的节点数
        $level_max_num = Role::select(DB::raw('count(*) as role_count'))->groupBy('level')->orderBy('role_count','desc')->first()->role_count;
        $data['width'] = ($level_max_num+1)*200;
        $data['height'] = Role::max('level')*115+150;
        $data['level_count'] = $level;
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