<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Support\Facades\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class MenuController extends Controller
{
    //获取菜单数据
    public function getMenus(){
        $data = Menu::orderBy('left_margin')->options(Request::only('where', 'order'))->paginate();
        $param = [
            'order'=> Request::input('order',[]), //排序
            'where'=>Request::input('where',[]), //条件查询
        ];
        return collect($data)->merge($param);;
    }

    //列表数据展示
    public function getIndex(){
        $data['list'] = $this->getMenus()->toArray();
        return Response::returns($data);
    }

    //创建
    public function create(){

    }
    //保存
    public function store(){

    }
    //详情
    public function show($menu){
dd($menu);
    }
    //编辑
    public function  edit($menu){

    }
    public function update($menu){

    }

    //删除数据
    public function postDestroy(){
        $res = Menu::destroy(Request::input('ids',[]));
        if($res===false){
            return Response::returns(['alert'=>alert(['content'=>'删除失败!'],500)]);
        }
        return Response::returns(['alert'=>alert(['content'=>'删除成功!'])]);
    }
}
