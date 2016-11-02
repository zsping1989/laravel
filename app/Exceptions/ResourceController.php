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

    /**
     * 处理请求参数
     */
    protected function handleRequest(){
        Request::offsetSet('order',json_decode(Request::input('order','[]'))?:(isset($this->defaultOrder)?$this->defaultOrder:[]));//排序处理
        $where = Request::input('where',[]);
        $where = is_array($where) ? collect($where)->map(function($item){
            if(!is_array($item)){
                return json_decode($item,true);
            }else{
                return $item;
            }
        })->toArray() : json_decode($where,true);
        if(Request::input('dateStart')){
            $where[0] = [
                'key'=>$this->dateFiled,
                'type'=>'dateStart',
                'val'=>Request::input('dateStart'),
                'exp'=>'>='
            ];
        }
        if(Request::input('dateEnd')){
            $where[1] = [
                'key'=>$this->dateFiled,
                'type'=>'dateEnd',
                'val'=>Request::input('dateEnd'),
                'exp'=>'<='
            ];
        }

        Request::offsetSet('where',$where); //条件筛选处理
    }

    /**
     * 检查树状结构限制排序
     * 返回: mixed
     */
    protected function checkOrder(){
           return isset($this->treeOrder) ? $this->bindModel->orderBy('left_margin') : $this->bindModel;
    }

    /**
     * 附带参数返回
     * param $data
     * 返回: static
     */
    protected function withParam($data){
        $param = [
            'order'=> Request::input('order',[]), //排序
            'where'=>Request::input('where',[]), //条件查询
        ];
        return collect($data)->merge($param);
    }

    /**
     * 获取菜单数据
     * @return static
     */
    public function getList(){
        $this->handleRequest();
        $obj = $this->checkOrder(); //排序检查
        $data = $obj->options(Request::only('where', 'order'))->paginate();
        return $this->withParam($data);
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
        return ['alert'=>alert(['content'=>'删除成功!'])];
    }

    /**
     * 编辑数据页面
     * @param null $id
     */
    public function getEdit($id=null){
        $data = [];
        if($id){
            $data['row'] = $this->bindModel->findOrFail($id);
        }else{
            $data['row'] = [];
        }
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
                return ['alert'=>alert(['content'=>'修改失败!'],500)];
            }
            return ['alert'=>alert(['content'=>'修改成功!'])];
        }

        //新增
        $res = $this->bindModel->create($request->except('id'));
        if($res===false){
            return ['alert'=>alert(['content'=>'新增失败!'],500)];
        }
        return ['alert'=>alert(['content'=>'新增成功!'])];
    }

    /**
     * 新增或修改,验证规则获取
     * @return mixed
     */
    abstract protected function getValidateRule();

}