<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{

    public function getIndex(){
dd('index');
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
