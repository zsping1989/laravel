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
    public function getMenus(){
        $data = Role::options(Request::only('where', 'order'))->paginate();
        $param = [
            'order'=> Request::input('order',[]), //排序
            'where'=>Request::input('where',[]), //条件查询
        ];
        return collect($data)->merge($param);;
    }
    public function getAreas(){
        $data = Area::options(Request::only('where', 'order'))->paginate();
        $param = [
            'order'=> Request::input('order',[]), //排序
            'where'=>Request::input('where',[]), //条件查询
        ];
        return collect($data)->merge($param);;
    }
    //列表数据展示
    public function getIndex(){
        $data['roles'] = $this->getMenus();

        $data['areas'] = $this->getAreas();
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
    public function destroy($menu){

    }
}
