<?php

namespace App\Http\Controllers\Home;

use App\Logics\Facade\UserLogic;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    public function index(Request $request){
      return $this->getIndex($request);
    }
    public function getIndex(Request $request){
        //Menu::create(["name"=>'zdjidj',"parent_id"=>3]);
        //$menu = Menu::find(3);
        //dd($menu);
        return view('welcome');
    }

    public function getIndexAa(){
        return view('welcome');
    }


    public function getRoutes(){
        $data['menus'] = UserLogic::getUser() ? UserLogic::getUserInfo('menus') : null;
        return Response::returns($data);
    }
}
