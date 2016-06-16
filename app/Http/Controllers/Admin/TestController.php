<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ResourceController;
use App\Http\Controllers\Controller;
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


}