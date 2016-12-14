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

    public function anyResult($gateway=null){
        $options = array_merge($_POST, $_GET);
        $request = $this->getGateway($gateway)->completePurchase($options);
        $response = $request->send();
        dump($_REQUEST);
        try {
            $response = $request->send();
            $response->isPaid() AND exit('success');
        } catch (Exception $e) {
        }
        exit('fail');
    }






}
