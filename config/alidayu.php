<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 阿里大于配置 注册地址:https://www.alidayu.com/
    |--------------------------------------------------------------------------
    */

    //应用AppKey
    'app_key' => env('ALIDAYU_KEY', ''),

    //应用AppSecret
    'app_secret' => env('ALIDAYU_SECRET', ''),

    //短信签名
    'sms_free_sign_name'=>env('SMS_FREE_SIGN_NAME', ''),

    //用户注册短信配置
    'register'=>[
        'sms_template_code'=>env('REGISTER_SMS_TEMPLATE_CODE', ''), //短信模板
        //参数验证
        'params'=>[
            'code'=>'required|digits:4' //验证码
        ]
    ],

    //短信登录配置
    'login'=>[
        'sms_template_code'=>env('LOGIN_SMS_TEMPLATE_CODE', ''), //短信模板
        'params'=>[]
    ]

];
