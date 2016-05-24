<?php

namespace App\Http\Controllers\Home;

use App\User;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */


    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * 验证登录字段
     *
     * @var string
     */
    protected $username = 'email|mobile_phone|uname';
    protected $authField = '';

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/index';
    protected $redirectAfterLogout = '/home/auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * return void
     */
    public function __construct()
    {
        //访客中间键验证
        $this->middleware($this->guestMiddleware(), ['except' => ['logout','getLogout']]);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return Response::returns(['_token'=>csrf_token()]);
    }

    /**
     * 获取验证码
     * @param int $w
     * @param int $h
     * 返回: mixed
     */
    public function getCaptcha($w=150,$h=32){
        return $this->captcha($w,$h);
    }

    public function captcha($w=150,$h=32){
        $builder = new CaptchaBuilder();
        $builder->build($w,$h);
        \Session::set('phrase',$builder->getPhrase()); //存储验证码
        return response($builder->output())->header('Content-type','image/jpeg');
    }

    /**
     * 登录失败返回
     * @param Request $request
     * 返回: $this
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        //直接form表单提交
        if(canRedirect()){
           return redirect()->back()
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors([
                    $this->loginUsername() => $this->getFailedLoginMessage(),
                ]);
        }
        //ajax提交
        return Response::returns([
           $this->loginUsername() => [$this->getFailedLoginMessage()]
        ],302);
    }

    /**
     * 返回: \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::guard($this->getGuard())->logout();
        return orRedirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    /**
     * 重新验证方法
     *
     * @return string
     */
    public function loginUsername()
    {
        //返回真实验证字段
        if($this->authField){
           return $this->authField;
        }

        //没有设置验证登录字段,默认是email
        if(!property_exists($this, 'username')){
            $this->authField = 'email';
            return 'email';
        }

        //获取请求参数
        $request = app('request');

        //判断是否使用通用登录方式
        if($request->has('username')){
           return $this->matchAuthField();
        }

        //判断参数是否包含验证字段
        $usernames = explode('|', $this->username);

        //查询是否含有存在的登录字段
        foreach($usernames as $username){
            if($request->has($username)){
                $this->authField = $username; //存放验证字段
                return $this->authField;
            };
        }

        //没有找到查询字段返回最后一个定义字段
        return $username;
    }

    /**
     * 匹配username属于的用户类型
     * 返回: string
     */
    protected function matchAuthField(){
        //获取验证对象
        $validator = app('validator');
        //获取请求对象
        $request = app('request');
        //匹配是否为邮箱登录
        if(str_contains($this->username,'email') && $validator->make(
            ['username'=>$request->input('username')],
            ['username'=>'email'])->passes()){
            $this->authField = 'email';
        //匹配是否为手机号码登录
        }elseif(str_contains($this->username,'mobile_phone') && $validator->make(
            ['username'=>$request->input('username')],
            ['username'=>'mobilePhone'])->passes()){
            $this->authField = 'mobile_phone';
        //其它为用户名登录
        }else{
            $this->authField = 'uname';
        };
        //设置验证登录值
        $request->offsetSet( $this->authField,$request->input('username'));
        return $this->authField;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'uname' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'mobile_phone' => 'sometimes|mobilePhone|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'uname' => $data['uname'],
            'mobile_phone' => $data['mobile_phone'],
            'password' => bcrypt($data['password']),
        ]);
    }





}
