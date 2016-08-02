<?php
/**
 * 个人中心
 */
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Logics\Facade\UserLogic;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request as ValidateRequest;
use Message\Models\Message;

class ProfileController extends Controller{
    /**
     * 处理请求参数
     */
    protected function handleRequest(){
        Request::offsetSet('order',json_decode(Request::input('order','[]')));//排序处理
        $where = Request::input('where',[]);
        //dd($where);
        $where = is_array($where) ? collect($where)->map(function($item){
            if($item){
                return json_decode($item,true);
            }
        })->toArray() : json_decode($where,true);
        //dd($where);
        Request::offsetSet('where',$where); //条件筛选处理
    }

    /**
     * 修改密码
     */
    public function getPassword(){
        return Response::returns(['row'=>['token'=>csrf_token()]]);
    }

    /**
     * 执行密码修改
     * 返回: mixed
     */
    public function postPassword(ValidateRequest $request){
        //验证
        $this->validate($request,$this->getValidateRestPasswordRule());
        $user = UserLogic::getUser();
        $user->update(['password'=> bcrypt($request->input('password'))]);
        return ['alert'=>alert(['content'=>'修改密码成功!'])];
    }

    /**
     * 修改密码重置验证
     * 返回: array
     */
    protected function getValidateRestPasswordRule(){
        return ['old_password'=>'required|ckeck_password','password'=>'required|digits_between:6,18|confirmed'];
    }

    /**
     * 个人资料修改
     */
    public function getInfo(){
        return Response::returns(['row'=>UserLogic::getUser()]);
    }

    /**
     * 执行修改资料
     */
    public function postInfo(ValidateRequest $request){
        //验证字段
        $this->validate($request,$this->getValidateUserInfo());
        //只允许修改字段
        $only = $request->has('mobile_phone') ? ['mobile_phone','name'] : ['name'];
        //修改个人资料
        UserLogic::getUser()->update($request->only($only));
        //弹窗消息
        return ['alert'=>alert(['content'=>'修改资料!'])];
    }

    /**
     * 个人资料修改验证规则
     * 返回: array
     */
    protected function getValidateUserInfo(){
        return [
            'mobile_phone'=>'sometimes|required|mobile_phone|digits:11|unique:users,mobile_phone',
            'name'=>'required'
        ];
    }

    /**
     * 附带参数返回
     * param $data
     * 返回: static
     */
    protected function withParam($data){
        $param = [
            'order'=> Request::input('order',[]), //排序
            'where'=>Request::input('where',[]), //条件查询
        ];
        return collect($data)->merge($param);
    }

    /**
     * 获取菜单数据
     * @return static
     */
    public function getList(){
        $this->handleRequest();
        //默认排序时间降序
        if(!Request::input('order')){
            Request::offsetSet('order',["created_at"=>'desc']);
        }
        //获取数据
        $data = Message::options(Request::only('where', 'order'))->paginate();
        foreach($data as &$item){
            $item->format_time = Carbon::createFromFormat('Y-m-d H:i:s',$item->created_at)->diffForHumans();
        }
        $ids = $data->pluck('id');
        //未读数据统计
        $data = collect($data)->put('message_count',UserLogic::getCountNotReadByMsgtpl(['messages','user','system'])->keyBy('name'));
        //修改成已读
        \Message\Facades\Message::updateReadByIds($ids);
        return $this->withParam($data);
    }

    /**
     * 列表数据展示页面
     * @return mixed
     */
    public function getMessage(){
        $data['list'] = $this->getList();
        return Response::returns($data);
    }








}