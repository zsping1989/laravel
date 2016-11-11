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


    /**
     * 首页
     */
    public function getIndex(){
        return Response::returns([]);
    }
}
