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
use Illuminate\Http\Request as ValidateRequest;

trait ResourceController{
    protected $bindModel; //绑定的model模型

    /**
     * 获取菜单数据
     * @return static
     */
    public function getList(){
        //树状结构限制排序
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
        return collect($data)->merge($param);
    }

    /**
     * 列表数据展示页面
     * @return mixed
     */
    public function getIndex(){
        $data['list'] = $this->getList();
        return Response::returns($data);
    }


    /**
     * 删除数据
     * @return mixed
     */
    public function postDestroy(){
        $res = $this->bindModel->destroy(Request::input('ids',[]));
        if($res===false){
            return Response::returns(['alert'=>alert(['content'=>'删除失败!'],500)]);
        }
        return Response::returns(['alert'=>alert(['content'=>'删除成功!'])]);
    }

    /**
     * 编辑数据页面
     * @param null $id
     */
    public function getEdit($id=null){
        $data = [];
        $id AND $data['row'] = $this->bindModel->findOrFail($id);
        return Response::returns($data);
    }

    /**
     * 执行修改或添加
     * 参数 Request $request
     */
    public function postEdit(ValidateRequest $request){
        //验证数据
        $this->validate($request,$this->getValidateRule());
        $id = $request->get('id');
        //修改
        if($id){
            $res = $this->bindModel->find($id)->update($request->all());
            if($res===false){
                return Response::returns(['alert'=>alert(['content'=>'修改失败!'],500)]);
            }
            return Response::returns(['alert'=>alert(['content'=>'修改成功!'])]);
        }

        //新增
        $res = $this->bindModel->create($request->except('id'));
        if($res===false){
            return Response::returns(['alert'=>alert(['content'=>'新增失败!'],500)]);
        }
        return Response::returns(['alert'=>alert(['content'=>'新增成功!'])]);
    }

    /**
     * 新增或修改,验证规则获取
     * @return mixed
     */
    abstract protected function getValidateRule();

}