<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function getIndex()
    {
        $data = Area::options(Request::only('where', 'order'))->paginate();
        return Response::returns($data);
    }
}
