<?php

namespace App\Http\Controllers\Admin;

use Custom\Commands\Controllers\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Area;

class AreaController extends Controller
{
    use ResourceController; //资源控制器

    /**
    * 模型绑定
    * MenuController constructor.
    * 参数: Menu $bindModel
    */
    public function __construct(Area $bindModel){
        $this->bindModel = $bindModel;
    }

    /**
    * 新增或修改,验证规则获取
    * 返回: array
    */
    protected function getValidateRule(){
        return ['name'=>'required','status'=>'in:1,2','parent_id'=>'sometimes|required|exists:areas,id'];
    }


}