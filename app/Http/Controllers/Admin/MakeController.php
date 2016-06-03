<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class MakeController extends Controller
{
    public function postExe(){
        $exitCode = Artisan::call('make:controller', ['name'=>'Admin/TestController']);
        dd($exitCode);

    }
}
