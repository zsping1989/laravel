<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //后台首页
    public function getIndex()
    {
        $data = Area::options(Request::only('where', 'order'))->paginate();
        return Response::returns($data);
    }
    //api文档说明列表
    public function getApi(){
        return Response::returns([]);
    }
    //代码创建
    public function getCreateCode(){
        return Response::returns([]);
    }
}
