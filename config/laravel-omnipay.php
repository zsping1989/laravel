<?php
/*
 |--------------------------------------------------------------------------
 | 支付宝支付配置 注册地址:https://open.alipay.com/
 |--------------------------------------------------------------------------
 */

return [


	// The default gateway to use
	'default' => 'alipay',

	// Add in each gateway here
	'gateways' => [
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
				'solutionType'   => '',
				'landingPage'    => '',
				'headerImageUrl' => ''
			]
		],
		'alipay' => [
			'driver' => 'Alipay_Express',
			'options' => [
				'partner' => env('ALIPLAY_PID'), //合作伙伴身份（PID）
				'key' => env('ALIPLAY_APPID'), //APPID
				'sellerEmail' =>env('ALIPLAY_USER'), //支付宝账号
				'returnUrl' => 'your returnUrl here', //回调页面
				'notifyUrl' => 'your notifyUrl here' //提示页面
			]
		]
	]

];