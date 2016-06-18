<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Menu;

class MenuController extends Controller
{
    use ResourceController; //资源控制器
    protected $treeOrder = true;

    /**
     * 模型绑定
     * MenuController constructor.
     * 参数: Menu $bindModel
     */
    public function __construct(Menu $bindModel){
        $this->bindModel = $bindModel;
    }

    /**
     * 新增或修改,验证规则获取
     * 返回: array
     */
    protected function getValidateRule(){
        return [];
    }


}