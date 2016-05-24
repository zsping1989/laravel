<?php

namespace App\Http\Controllers\Home;

use App\Models\Menu;
use App\Models\Role;
use App\User;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

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
}
