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
        return ['name'=>'required','icons'=>'alpha_dash','method'=>'in:1,2,3','status'=>'in:1,2','parent_id'=>'sometimes|required|exists:menus,id'];
    }

    /**
     * 编辑数据页面
     * @param null $id
     */
    public function getEdit($id=null){
        $data = [];
        $id AND $data['row'] = $this->bindModel->findOrFail($id)->load('params','responses');
        return Response::returns($data);
    }

    /**
     * 将子节点置顶
     * param $id
     */
    public function postMoveTop($id){
        //被移动节点
        $obj = $this->bindModel->findOrFail($id);
        //现在置顶的节点
        if($obj->parent_id==1){
            $top = $this->bindModel->where('level','=',2)->orderBy('left_margin')->first();
        }else{
            $top = $this->bindModel->find($obj->parent_id)->childs()->first();
        }
        if($top->id==$obj->id){
            return ['alert'=>alert(['content'=>'已经是最顶端了!'])];
        }
        if($obj->moveNear($top->id)===false){
            return ['alert'=>alert(['content'=>'置顶失败!'],500)];
        }
        return ['alert'=>alert(['content'=>'置顶成功!'])];
    }


}