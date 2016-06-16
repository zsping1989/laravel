<?php
/**
 * 通过 PhpStorm 创建.
 * 创建人: 21498
 * 日期: 2016/6/14
 * 时间: 13:58
 */

namespace App\Exceptions;


use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

trait ResourceController{
    protected $bindModel; //绑定的model模型

    //获取菜单数据
    public function getList(){

        if(isset($this->treeOrder)){
            $obj = $this->bindModel->orderBy('left_margin');
        }else{
            $obj = $this->bindModel;
        }
        $data = $obj->options(Request::only('where', 'order'))->paginate();
        $param = [
            'order'=> Request::input('order',[]), //排序
            'where'=>Request::input('where',[]), //条件查询
        ];
        return collect($data)->merge($param);;
    }

    //列表数据展示
    public function getIndex(){
        $data['list'] = $this->getList()->toArray();
        return Response::returns($data);
    }


    //删除数据
    public function postDestroy(){
        $res = $this->bindModel->destroy(Request::input('ids',[]));
        if($res===false){
            return Response::returns(['alert'=>alert(['content'=>'删除失败!'],500)]);
        }
        return Response::returns(['alert'=>alert(['content'=>'删除成功!'])]);
    }

}