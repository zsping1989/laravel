<?php
/*
 |--------------------------------------------------------------------------
 | 支付宝支付配置 注册地址:https://open.alipay.com/
 |--------------------------------------------------------------------------
 */

return [


	// 默认支付使用网关
	'default' => 'alipay_legacy_express',

	//支付宝沙箱应用开关
	'sandbox' => env('ALIPLAY_SANDBOX'),

	// 添加网关配置
	'gateways' => [
		//阿里即时到账
		'alipay_legacy_express' => [
			'driver' => 'Alipay_LegacyExpress',
			'options' => [
				/* sellerId,sellerEmail,sellerAccountName必填一个 */
				'sellerId' => '2088021001625212',//env('ALIPLAY_PID'), //合作伙伴身份（PID）
				//'sellerEmail' =>'magicyugi@gmail.com',//env('ALIPLAY_Email'), //卖方支付宝邮箱
				//'sellerAccountName' => env('ALIPLAY_USER'), //卖方支付宝账号
				'key'=>'nk7ro1rr86z67y05gb1lsk1ngw9im8vb',//env('ALIPAY_MD5_KEY'), //合作伙伴MD5密钥
				//'returnUrl'=>env('APP_URL').'/home/pay-communicate/result',
				//'notifyUrl'=>env('APP_URL').'/home/pay-communicate/notify/alipay_legacy_express'
			]
		],





		//手机网站支付 new
		'alipay_aop_wap'=>[
			'driver' => 'Alipay_AopWap',
			'options' => [
				'partner' => env('ALIPLAY_PID'), //合作伙伴身份（PID）
				'sellerEmail' =>env('ALIPLAY_USER'), //卖方邮箱
				'appId' => env('ALIPLAY_APPID'), //应用ID
				'privateKey' =>env('ALIPAY_PRIVATE_KEY'), //私有秘钥
				'alipayPublicKey'=> env('ALIPAY_PUBLIC_KEY'), //公钥
				'notifyUrl'=>env('APP_URL').'/home/pay-communicate/notify/alipay_aop_wap' //支付后回调
			]
		],

		//手机网站支付
		'alipay_legacy_wap'=>[
			'driver' => 'Alipay_LegacyWap',
			'options' => [
				'partner' => env('ALIPLAY_PID'), //合作伙伴身份（PID）
				'key'=>env('ALIPAY_MD5_KEY'), //合作伙伴MD5密钥
				'sellerId'=>env('ALIPLAY_PID'),
				'privateKey' =>env('ALIPAY_PRIVATE_KEY'), //私有秘钥
				'alipayPublicKey'=> env('ALIPAY_PUBLIC_KEY'), //公钥
				'notifyUrl'=>env('APP_URL').'/home/pay-communicate/notify/alipay_aop_wap', //支付后回调
				'returnUrl'=>env('APP_URL').'/home/pay-communicate/result'

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

		//微信APP支付
		'wechat_pay_app'=>[
			'driver' => 'WechatPay_App',
			'options' => [
				'appId' => env('ALIPLAY_APPID'), //应用ID
				'mchId' =>env('ALIPAY_PRIVATE_KEY'), //私有秘钥
				'apiKey'=> env('ALIPAY_PUBLIC_KEY'), //公钥
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