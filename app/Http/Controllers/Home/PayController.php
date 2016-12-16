<?php
/**
 * 支付接口
 */
namespace App\Http\Controllers\Home;

use App\Http\Controllers\PayBase;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PayController extends Controller{
    use PayBase; //支付基础方法

    /**
     * 网关:Alipay_LegacyExpress(Alipay Legacy Express Gateway)
     * 支付宝即时到账
     * @return mixed
     */
    public function getAlipayLegacyExpress(){
        $request = $this->getGateway('alipay_legacy_express')->purchase([
            'out_trade_no' => date('YmdHis').mt_rand(1000,9999),
            'subject'      => 'test',
            'total_fee'    => '0.01',
        ]);
        $response = $request->send();
        //$redirectUrl = $response->getRedirectUrl();
        $response->redirect();
    }


    /**
     * 网关:Alipay_AopApp(Alipay APP Gateway)
     * 支付宝面对面支付
     * @return mixed
     */
    public function getAlipayAopF2f(){
        $request = $this->getGateway('alipay_aop_f2f')->purchase();
        $request->setBizContent([
            'subject'      => 'test',
            'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
            'total_amount' => '0.01',
            'timeout_express'=>'90m'
        ]);

        $response = $request->send();
        // 获取收款二维码内容
        $qrCodeContent = $response->getQrCode();
        return ['qr_code'=>qrcodeUrl($qrCodeContent)];
    }



    /**
     * 网关:Alipay_AopWap(Alipay WAP Gateway)
     * 支付宝手机网站支付 new
     * @return mixed
     */
    public function getAlipayAopWap(){
        $request = $this->getGateway('alipay_aop_wap')->purchase();
        $request->setBizContent([
            'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
            'total_amount' => 0.01,
            'subject'      => 'test',
            'product_code' => 'QUICK_MSECURITY_PAY',
        ]);
        $response = $request->send();
        //$redirectUrl = $response->getRedirectUrl(); //跳转页面
        $response->redirect(); //跳转支付页面
    }


    /**
     * 网关:Alipay_AopApp(Alipay APP Gateway)
     * 支付宝APP支付
     * @return mixed
     */
    public function getAlipayAopApp(){
        $request = $this->getGateway('alipay_aop_app')->purchase();
        $request->setBizContent([
            'subject'      => 'test',
            'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
            'total_amount' => '0.01',
            'product_code' => 'QUICK_MSECURITY_PAY',
        ]);
        $response = $request->send();
        $orderString = $response->getOrderString();
        //iOS 客户端
        /* [[AlipaySDK defaultService] payOrder:orderString fromScheme:appScheme callback:^(NSDictionary *resultDic) {
            NSLog(@"reslut = %@",resultDic);
        }];*/

        //Android 客户端
        /* PayTask alipay = new PayTask(PayDemoActivity.this);
        Map<String, String> result = alipay.payV2(orderString, true);*/
        return ['order_string'=>$orderString];
    }



    /**
     * 网关:Alipay_AopApp(Alipay APP Gateway)
     * 支付宝面对面支付
     * @return mixed
     */
    public function getWechatPayApp(){
        $request = $this->getGateway('wechat_pay_app')->purchase([
            'body'              => 'The test order',
            'out_trade_no'      => date('YmdHis').mt_rand(1000, 9999),
            'total_fee'         => 1, //=0.01
            'spbill_create_ip'  => 'ip_address',
            'fee_type'          => 'CNY'
        ]);


        $response = $request->send();

        //available methods
        $response->isSuccessful();
        $response->getData(); //For debug
        $response->getAppOrderData(); //For WechatPay_App
        $response->getJsOrderData(); //For WechatPay_Js
        $response->getCodeUrl(); //For Native Trade Type
    }





}
