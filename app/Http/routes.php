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
Route::get('/', 'Home\IndexController@index');
Route::group(['prefix'=>'home','namespace'=>'Home'],function(){
    Route::controller('auth', 'AuthController');
    Route::controller('index', 'IndexController');
    // 发送密码重置链接路由
    Route::get('password/email', 'PasswordController@getEmail');
    Route::post('password/email', 'PasswordController@postEmail');

// 密码重置路由
    Route::get('password/reset/{token?}', 'PasswordController@getReset');
    Route::post('password/reset', 'PasswordController@postReset');
});

//前台路由设置
Route::group(['prefix'=>'data/home','namespace'=>'Home'],function(){

    Route::controller('auth', 'AuthController');
    Route::controller('index', 'IndexController');
    // 发送密码重置链接路由
    Route::get('password/email', 'PasswordController@getEmail');
    Route::post('password/email', 'PasswordController@postEmail');

// 密码重置路由
    Route::get('password/reset/{token?}', 'PasswordController@getReset');
    Route::post('password/reset', 'PasswordController@postReset');
    /*
     // 验证路由

     // 用户注册路由
     Route::get('register', 'AuthController@showRegistrationForm');
     Route::post('register', 'AuthController@register');

     // 密码重置路由
     Route::get('password/reset/{token?}', 'PasswordController@showResetForm');
     Route::post('password/email', 'PasswordController@sendResetLinkEmail');
     Route::post('password/reset', 'PasswordController@reset');
    */




});
Route::group(['namespace'=>'Admin'],function(){
    //Route::resource('menu', 'MenuController');
});


//中间件验证
Route::group(['prefix'=>'data/admin','namespace'=>'Admin','middleware'=>['auth','admin']], function(){
    Route::controller('make', 'MakeController'); //创建代码控制器
    Route::controller('menu', 'MenuController'); //菜单资源控制器
    Route::controller('area', 'AreaController'); //区域资源控制器
    Route::controller('exploit', 'ExploitController'); //开发工具控制器
    Route::controller('role', 'RoleController'); //角色资源控制器
    Route::controller('user', 'UserController'); //用户资源控制器
    //Route::controller('profile', 'ProfileController'); //个人设置
    Route::controller('test', 'TestController');
    Route::controller('/', 'IndexController');
});






