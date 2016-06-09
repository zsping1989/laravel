<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use App\Models\Menu;
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
        //获取所有接口
        $data['api'] = Menu::with('params')->orderBy('left_margin')->get()->keyBy(function ($item) {
            return 'id_'.$item['id']; //保证json排序
        });
        $data['max_level'] = $data['api']->max('level');
        return Response::returns($data);
    }
    //代码创建
    public function getCreateCode(){
        return Response::returns([]);
    }
}
