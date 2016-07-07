<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

//前台用户创建
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'uname'=>$faker->userName,
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        //'password' => bcrypt($faker->password(6,20)),
        'password' => bcrypt(123456),
        'mobile_phone'=>$faker->phoneNumber,
        'qq'=>$faker->numberBetween(10000,999999999),
        'remember_token' => str_random(10),
        'status'=>1
    ];
});

//后台用户
$factory->define(App\Models\Admin::class, function (Faker\Generator $faker) {
    return [];
});

//后台角色
$factory->define(App\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'name'=>$faker->word,
        'description'=>$faker->word
    ];
});

//后台权限
$factory->define(App\Models\Menu::class, function (Faker\Generator $faker) {
    return [
        'name'=>$faker->word,
        'description'=>$faker->word,
        'method'=>1,
        'prefix'=>'',
        'url'=>'/',
        'status'=>2 //不显示
    ];
});

//接口参数
$factory->define(App\Models\ApiParam::class, function (Faker\Generator $faker) {
    return [
        'menu_id'=>0,
        'name'=>$faker->word,
        'title'=>$faker->word,
        'description'=>$faker->word,
        'example'=>''
    ];
});

//接口响应说明
$factory->define(App\Models\ApiResponse::class, function (Faker\Generator $faker) {
    return [
        'menu_id'=>0,
        'name'=>$faker->word,
        'description'=>$faker->word
    ];
});

//测试
$factory->define(App\Models\Test::class, function (Faker\Generator $faker) {
    return [
        'name'=>$faker->word
    ];
});

