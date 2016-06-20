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

//前台路由设置
Route::group(['prefix'=>'home','namespace'=>'Home'],function(){
    Route::controller('auth', 'AuthController');
    //首页
    //Route::get('/', 'IndexController@index');
   /* Route::get('/home', ['uses'=>'HomeController@index','as'=>'ho']);
    // 验证路由
    Route::get('/login', 'AuthController@showLoginForm');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');

    // 用户注册路由
    Route::get('register', 'AuthController@showRegistrationForm');
    Route::post('register', 'AuthController@register');

    // 密码重置路由
    Route::get('password/reset/{token?}', 'PasswordController@showResetForm');
    Route::post('password/email', 'PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'PasswordController@reset');
    //用户页
    Route::group(['middleware'=>['admin']],function(){
        Route::get('/{user?}', ['as'=>'home',function ($user=null) {
            return $user;
            $user AND dd($user);
            return view('welcome');
        }]);
    });
    Route::controller('index', 'IndexController');*/




});
Route::resource('photo', 'PhotoController');
Route::group(['namespace'=>'Admin'],function(){
    //Route::resource('menu', 'MenuController');
});


//后台路由设置
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['auth','admin']],function(){
    Route::controller('make', 'MakeController');
    Route::controller('menu', 'MenuController');
    Route::controller('test', 'TestController');
    Route::controller('/', 'IndexController');
});





