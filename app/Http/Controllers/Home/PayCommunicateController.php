<?php
/**
 * 支付通知
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\PayBase;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PayCommunicateController extends Controller{
    use PayBase;

    public function anyNotify($gateway=null){
        $request = $this->getGateway($gateway)->completePurchase();
        $request->setParams(array_merge($_POST, $_GET)); //Don't use $_REQUEST for may contain $_COOKIE
        try {
            $response = $request->send();
            $response->isPaid() and exit('success'); //The notify response should be 'success' only
        } catch (Exception $e) {
        }
        exit('fail');
    }

    public function postResult($gateway=null){
        $gateway = $this->getGateway($gateway);
        $options = [
            'request_params'=> $_REQUEST,
        ];

        $response = $gateway->completePurchase($options)->send();
        $response->isSuccessful() AND $response->isTradeStatusOk() AND exit('支付成功');
        exit('支付失败');
    }




}
