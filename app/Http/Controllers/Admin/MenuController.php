<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use Illuminate\Support\Facades\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class MenuController extends Controller
{

    public function getIndex(){
        $data = Menu::options(Request::only('where', 'order'))->paginate();
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
