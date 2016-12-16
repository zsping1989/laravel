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

		//阿里即时到账 https://doc.open.alipay.com/docs/doc.htm?treeId=108&articleId=103950&docType=1
		'alipay_legacy_express' => [
			'driver' => 'Alipay_LegacyExpress',
			'options' => [
                'partner' => env('ALIPLAY_PID'), //合作伙伴身份（PID）-必填
				'sellerId' => env('ALIPLAY_PID'), //合作伙伴身份（PID）-sellerId,sellerEmail,sellerAccountName必填一个
				//'sellerEmail' => env('ALIPLAY_Email'), //卖方支付宝邮箱 -sellerId,sellerEmail,sellerAccountName必填一个
				//'sellerAccountName' => env('ALIPLAY_USER'), //卖方支付宝账号 -sellerId,sellerEmail,sellerAccountName必填一个
				//'signType'=>'RSA', //签名加密方式 -默认MD5
				'key'=>env('ALIPAY_MD5_KEY'), //合作伙伴MD5密钥 -签名类型为MD5时必填
                //'privateKey' =>env('ALIPAY_PRIVATE_KEY'), //私有秘钥 -signType='RSA'时,必填
                //'alipayPublicKey'=> env('ALIPAY_PUBLIC_KEY'), //公钥 -signType='RSA'时,必填
				'returnUrl'=>env('APP_URL').'/home/pay-communicate/result/alipay_legacy_express', //同步返回
				'notifyUrl'=>env('APP_URL').'/home/pay-communicate/notify/alipay_legacy_express' //异步通知,只能返回success
			]
		],

		//阿里当面付 https://doc.open.alipay.com/docs/doc.htm?treeId=194&articleId=105072&docType=1
		'alipay_aop_f2f'=>[
			'driver' => 'Alipay_AopF2F',
			'options' => [
				'charset'=>'GBK', // 应用编码,默认UTF-8
				'appId' => env('ALIPLAY_APPID'), //应用ID
				'privateKey' => env('ALIPAY_APP_PRIVATE_KEY'), //应用私有秘钥
				'alipayPublicKey'=>env('ALIPAY_PUBLIC_KEY'), //支付宝公钥
				'notifyUrl'=>env('APP_URL').'/home/pay-communicate/notify/alipay_aop_f2f' //异步通知
			]
		],

		//手机网站支付 new https://doc.open.alipay.com/docs/doc.htm?treeId=203&articleId=105288&docType=1
		'alipay_aop_wap'=>[
			'driver' => 'Alipay_AopWap',
			'options' => [
				'appId' => env('ALIPLAY_APPID'), //应用ID
				'privateKey' => env('ALIPAY_APP_PRIVATE_KEY'), //应用私有秘钥
				'alipayPublicKey'=>env('ALIPAY_PUBLIC_KEY'), //支付宝公钥
				'returnUrl'=>env('APP_URL').'/home/pay-communicate/result/alipay_legacy_express', //同步返回
				'notifyUrl'=>env('APP_URL').'/home/pay-communicate/notify/alipay_aop_wap' //异步通知
			]
		],

		//阿里APP支付 https://doc.open.alipay.com/docs/doc.htm?treeId=204&articleId=105051&docType=1
		'alipay_aop_app'=>[
			'driver' => 'Alipay_AopApp',
			'options' => [
				'appId' => env('ALIPLAY_APPID'), //应用ID
				'privateKey' =>env('ALIPAY_PRIVATE_KEY'), //私有秘钥
				'alipayPublicKey'=> env('ALIPAY_PUBLIC_KEY'), //公钥
				'returnUrl'=>env('APP_URL').'/home/pay-communicate/result/alipay_aop_app', //同步返回
				'notifyUrl'=>env('APP_URL').'/home/pay-communicate/notify/alipay_aop_app' //支付后回调
			]
		],



		//微信APP支付
		'wechat_pay_app'=>[
			'driver' => 'WechatPay_App',
			'options' => [
				'appId' => env('WECHAT_APPID'), //应用ID
				'mchId' =>env('WECHAT_MCHID'), //
				'apiKey'=> env('WECHAT_API_KEY'), //
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