<?php

namespace App\Http\Controllers\Admin;

use Custom\Commands\Controllers\ResourceController;
use App\Http\Controllers\Controller;
use App\Models\ApiParam;
use App\Models\ApiResponse;
use App\Models\Menu;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request as ValidateRequest;

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
            $obj = $this->bindModel->find($id);
            $res = $obj->update($request->all());
            if($res===false){
                return ['alert'=>alert(['content'=>'修改失败!'],500)];
            }

            //处理参数数据
            $this->updateParams($obj,$request->input('params'));
            //处理响应说明数据
            $this->updateResponses($obj,$request->input('responses'));
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
     * 更新接口的参数数据
     * @param Menu $menu
     * @param $params
     */
    protected function updateParams(Menu $menu,$params){
        $params = collect($params);
        //删除参数
        $del_ids = collect($menu->params)->pluck('id')->diff($params->pluck('id')->all())->all();
        ApiParam::destroy($del_ids);
        //获取新加参数
        $params_add = $params->filter(function($item){
            if($param_id = isset($item['id']) ? $item['id'] : 0){ //修改参数更新
                ApiParam::find($param_id)->update($item);
            }else{
                return true;
            }
        });
        $menu->params()->saveMany($params_add->map(function($item){
            return factory(ApiParam::class)->make($item);
        }));
    }

    /**
     * 更新接口的响应说明
     * @param Menu $menu
     * @param $responses
     */
    protected function updateResponses(Menu $menu,$responses){
        $responses = collect($responses);
        //删除参数
        $del_ids = collect($menu->responses)->pluck('id')->diff($responses->pluck('id')->all())->all();
        ApiResponse::destroy($del_ids);
        //获取新加参数
        $responses_add = $responses->filter(function($item){
            if($param_id = isset($item['id']) ? $item['id'] : 0){ //修改参数更新
                ApiResponse::find($param_id)->update($item);
            }else{
                return true;
            }
        });
        $menu->params()->saveMany($responses_add->map(function($item){
            return factory(ApiResponse::class)->make($item);
        }));
    }

}