<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ChartController extends Controller
{
    /**
     * 折线图
     */
    public function getLineChart(){
        return Response::returns([]);
    }

    /**
     * 柱状图
     */
    public function getBarChart(){
        return Response::returns([]);
    }

    public function getChinaChart(){
        return Response::returns([]);
    }

}