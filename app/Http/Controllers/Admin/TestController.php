<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Custom\Commands\Controllers\ResourceController;
use App\Models\Test;

class TestController extends Controller
{
    use ResourceController; //资源控制器

    /**
    * 模型绑定
    * MenuController constructor.
    * 参数: Menu $bindModel
    */
    public function __construct(Test $bindModel){
        $this->bindModel = $bindModel;
    }

    /**
    * 新增或修改,验证规则获取
    * 返回: array
    */
    protected function getValidateRule(){
        return ['name'=>'required','parent_id'=>'sometimes|required|exists:tests,id','method'=>'in:1,2,3','status'=>'in:1,2'];
    }


}