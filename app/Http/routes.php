<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//首页
Route::get('/', function(){
    return redirect('/home/auth/login');
});

Route::controller('img', 'Home\ImgController'); //图片处理

//前台无需登录路由
Route::group(['prefix'=>'home','namespace'=>'Home'],function($data){
    Route::get('swagger', 'SwaggerController@doc'); //swagger接口文档说明路由
    Route::controller('auth', 'AuthController');
    Route::controller('index', 'IndexController');
    Route::controller('pay-communicate', 'PayCommunicateController'); //支付通讯控制器
});

//前端必须登录的路由
Route::group(['prefix'=>'home','namespace'=>'Home','middleware'=>['auth']],function($data){
    Route::controller('pay', 'PayController'); //支付接口
});


//中间件验证
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['auth','admin']], function(){
    Route::controller('make', 'MakeController'); //创建代码控制器
    Route::controller('menu', 'MenuController'); //菜单资源控制器
    Route::controller('area', 'AreaController'); //区域资源控制器
    Route::controller('exploit', 'ExploitController'); //开发工具控制器
    Route::controller('role', 'RoleController'); //角色资源控制器
    Route::controller('user', 'UserController'); //用户资源控制器
    Route::controller('profile', 'ProfileController'); //个人设置
    Route::controller('chart', 'ChartController'); //图表事列
    Route::controller('test', 'TestController');
    Route::controller('index', 'IndexController');
});





