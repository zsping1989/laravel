<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ResourceController;
use App\Http\Controllers\Controller;
use App\User;

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
        return ['uname'=>'sometimes|required|alpha_dash|between:6,18|unique:users,uname','password'=>'sometimes|required|digits_between:6,18','name'=>'required','email'=>'sometimes|required|email|unique:users,email','mobile_phone'=>'sometimes|required|integer|digits:11|unique:users,qq','qq'=>'integer'];
    }


}