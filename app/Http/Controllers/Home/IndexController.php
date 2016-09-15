<?php

namespace App\Http\Controllers\Home;

use App\Logics\Facade\MenuLogic;
use App\Logics\Facade\UserLogic;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{

    public function getRoutes(){
        $data['menus'] = MenuLogic::getPageMenus();
        return Response::returns($data);
    }

    public function getTest(){
        dd();
    }
}
