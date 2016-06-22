<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Support\Facades\Response;

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

    /**
     * 将子节点置顶
     * @param $id
     */
    public function postMoveTop($id){
        //被移动节点
        $obj = $this->bindModel->find($id);
        //现在置顶的节点
        $top = $this->bindModel->find($obj->parent_id)->childs()->first();
        if($top->id==$obj->id){
            return Response::returns(['alert'=>alert(['content'=>'已经是最顶端了!'])]);
        }
        if($obj->moveNear($top->id)===false){
            return Response::returns(['alert'=>alert(['content'=>'置顶失败!'],500)]);
        }
        return Response::returns(['alert'=>alert(['content'=>'置顶成功!'])]);
    }


}