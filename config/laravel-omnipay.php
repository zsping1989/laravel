<?php
/*
 |--------------------------------------------------------------------------
 | 支付宝支付配置 注册地址:https://open.alipay.com/
 |--------------------------------------------------------------------------
 */

return [


	// 默认支付使用网关
	'default' => 'alipay_aop_wap',

	//支付宝沙箱应用开关
	'sandbox' => env('ALIPLAY_SANDBOX'),

	// 添加网关配置
	'gateways' => [

		//手机网站支付
		'alipay_aop_wap'=>[
			'driver' => 'Alipay_AopWap',
			'options' => [
				'appId' => env('ALIPLAY_APPID'), //应用ID
				'privateKey' =>env('ALIPAY_PRIVATE_KEY'), //私有秘钥
				'alipayPublicKey'=> env('ALIPAY_PUBLIC_KEY'), //公钥
				'notifyUrl'=>env('APP_URL').'/home/pay-communicate/notify/alipay_aop_wap' //支付后回调
			]
		],

		//阿里即时到账
		'alipay_legacy_express' => [
			'driver' => 'Alipay_LegacyExpress',
			'options' => [
				'partner' => env('ALIPLAY_PID'), //合作伙伴身份（PID）
				'sellerEmail' =>env('ALIPLAY_USER'), //卖方邮箱
				'key'=>env('ALIPAY_MD5_KEY'), //合作伙伴MD5密钥
				'privateKey' =>env('ALIPAY_PRIVATE_KEY'), //私有秘钥
				'alipayPublicKey'=> env('ALIPAY_PUBLIC_KEY'), //公钥
				'returnUrl'=>env('APP_URL').'/home/pay-communicate/result',
				'notifyUrl'=>env('APP_URL').'/home/pay-communicate/notify/alipay_legacy_express'
			]
		],

		//阿里APP支付
		'alipay_aop_app'=>[
			'driver' => 'Alipay_AopApp',
			'options' => [
				'appId' => env('ALIPLAY_APPID'), //应用ID
				'privateKey' =>env('ALIPAY_PRIVATE_KEY'), //私有秘钥
				'alipayPublicKey'=> env('ALIPAY_PUBLIC_KEY'), //公钥
				'notifyUrl'=>env('APP_URL').'/home/pay-communicate/notify/alipay_aop_app' //支付后回调
			]
		],

		//阿里APP支付
		'alipay_aop_f2f'=>[
			'driver' => 'Alipay_AopF2F',
			'options' => [
				'appId' => env('ALIPLAY_APPID'), //应用ID
				'privateKey' =>env('ALIPAY_PRIVATE_KEY'), //私有秘钥
				'alipayPublicKey'=> env('ALIPAY_PUBLIC_KEY'), //公钥
				'notifyUrl'=>env('APP_URL').'/home/pay-communicate/notify/alipay_aop_f2f' //支付后回调
			]
		],

		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
				'solutionType'   => '',
				'landingPage'    => '',
				'headerImageUrl' => ''
			]
		],
	]

];