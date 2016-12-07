<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PayCommunicateController extends Controller{

    public function anyNotify($gateway=null){
        $request = \Omnipay::gateway($gateway)->completePurchase();
        $request->setParams(array_merge($_POST, $_GET)); //Don't use $_REQUEST for may contain $_COOKIE
        try {
            $response = $request->send();
            if($response->isPaid()){
                die('success'); //The notify response should be 'success' only
            }else{
                die('fail'); //The notify response
            }
        } catch (Exception $e) {
            die('fail'); //The notify response
        }
    }

    public function postResult($gateway=null){
        $gateway = \Omnipay::gateway($gateway);
        $options = [
            'request_params'=> $_REQUEST,
        ];

        $response = $gateway->completePurchase($options)->send();

        if ($response->isSuccessful() && $response->isTradeStatusOk()) {
            //支付成功后操作
            exit('支付成功');
        } else {
            //支付失败通知.
            exit('支付失败');
        }
    }




}
