<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;

class MakeController extends Controller
{
    public function postExe(){
        $exitCode = Artisan::call(Request::input('artisan'), Request::except('artisan','where','order'));
        dd($exitCode);
    }
}
