<?php

namespace App\Http\Controllers;


trait PayBase
{
    /**
     * 获取网关
     * @param null $gateway_map
     * @return \Omnipay\Common\AbstractGateway
     */
    protected function getGateway($gateway_map = null){
        $gateway = \Omnipay::gateway($gateway_map); //选择网关
        config('laravel-omnipay.sandbox') AND $gateway->sandbox(); //是否启用沙箱应用
        return $gateway;
    }
}
