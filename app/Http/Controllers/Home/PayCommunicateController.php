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

    /**
     * 支付宝,异步通知
     * @param null $gateway
     */
    public function anyNotify($gateway=null){
        $options = array_merge($_POST, $_GET);
        $request = $this->getGateway($gateway)->completePurchase($options);
        $response = $request->send();
        try {
            $response = $request->send();
            !$response->isPaid() AND exit('fail');
        } catch (Exception $e) {
            exit('fail');
        }
        $this->isPaid() AND exit('success');
        exit('fail');
    }

    /**
     * 支付宝同步返回
     * @param null $gateway
     */
    public function anyResult($gateway=null){
        $options = array_merge($_POST, $_GET);
        $request = $this->getGateway($gateway)->completePurchase($options);
        $response = $request->send();
        try {
            $response = $request->send();
            !$response->isPaid() AND exit('fail');
        } catch (Exception $e) {
            exit('fail');
        }
        $this->isPaid() AND exit('success');
        exit('fail');
    }

    /**
     * 支付成功,执行后续操作
     * @return bool
     */
    protected function isPaid(){
        return true;
    }






}
