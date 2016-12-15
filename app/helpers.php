<?php
/**
 * 通过 PhpStorm 创建.
 * 创建人: zhangshiping
 * 日期: 16-5-5
 * 时间: 上午10:26
 *
 * 自定义辅助函数
 */


/**
 * 判断是否可以跳转页面
 * ajax,jsonp,script等请求不予跳转
 * 返回: bool
 */
function canRedirect(){
    $request = app('request');
    return !($request->has('callback') || $request->has('script')  ||
    $request->has('define') || $request->ajax() || $request->wantsJson() || $request->has('dd'));
}

/**
 * 可能跳转重定向页面
 * ajax,jsonp,script等请求不予跳转
 *
 * 参数 null $to
 * 参数 int $status
 * 返回: \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
 */
function orRedirect($to = null, $status = 302){
    if(canRedirect()){
        return redirect($to,$status);
    }

    return \Illuminate\Support\Facades\Response::returns([
        'title'=>\Illuminate\Support\Facades\Lang::get('status.status302'),
        'content'=>\Illuminate\Support\Facades\Lang::get('status.redirectTo').$to,
        'redirect' => $to
    ]);
}

/**
 * 前端弹窗参数返回
 * @param array $data
 * @param int $status
 * @return array
 */
function alert($data = [],$status=200){
    //默认值
    $defult  = [
        200=>[
            'title'=>'提示',
            'content'=>'操作成功!',
            'placement'=>'bottom-right',
            'type'=>'info',
            'duration'=>3,
            'show'=>true
        ],
        'other'=>[
            'title'=>'提示',
            'content'=>'操作失败!',
            'placement'=>'bottom-right',
            'type'=>'danger',
            'duration'=>3,
            'show'=>true
        ]
    ];
    return collect(isset($defult[$status]) ? $defult[$status] : $defult['other'])->merge($data)->toArray();
}

/**
 * 通过路径转化成前端控制器
 * @param $path
 */
function pathToCtrl($path){
    if(!$path){return false;};
    $name = implode(array_slice(array_filter(explode('/',$path)),0,3),'-');
    if(!$name){return false;}
    return $name.'Ctrl';
}

/**
 * 时间格式,用于影片时长
 * @param $time
 * @return string
 */
function timeFormat($time){
    $second = $time % 60;
    $minutes = floor($time/60) % 60;
    $hours   = floor(floor($time/60)/60) % 24;
    $day = floor($time/3600/24);

    $text = '';
    if($hours >= 0 ) $text .= str_pad($hours, 2, '0', STR_PAD_LEFT).':';
    if($minutes >= 0 ) $text .= str_pad($minutes, 2, '0', STR_PAD_LEFT).':';
    if($second >= 0 ) $text .= str_pad($second, 2, '0', STR_PAD_LEFT).'';
    $text = $day>0 ? $day.'天 '.$text:$text;
    return $text;
}

/**
 * 每月跨度
 * @param $start 开始时间戳
 * @param $end 结束时间戳
 * @return array
 */
function spanTimeLine($start,$end){
    $return_str = 'addMonth';
    $start = \Carbon\Carbon::createFromTimestamp($start);
    $end = \Carbon\Carbon::createFromTimestamp($end);
    $res = ['year'=>[],'month'=>[]];
    for($i=$start;$i->getTimestamp()<=$end->getTimestamp();$i->$return_str()){
        !in_array($i->year,$res['year']) AND  $res['year'][] = "$i->year";
        $res['month'][$i->year][] = $i->month<10 ? "0$i->month":"$i->month";
    }
    return $res;
}

/**
 * 发送短信通知
 * @param $to 用户手机号
 * @param $tpl 配置模板
 * @param array $data 短信参数
 * @return bool
 */
function sendSMS($to,$tpl,array $data=array()){
    $to = strval($to);
    $config = config('alidayu.'.$tpl);
    //短信模板不存在或接收者不存在,发送失败
    if(!$config['sms_template_code'] || !$to){
        return false;
    }
    $config['params']['to'] = 'required|mobile_phone';
    //参数验证
    $validator = \Illuminate\Support\Facades\Validator::make(array_merge($data,['to'=>$to]),$config['params']);
    if($validator->fails()){
        return false;
    }

    $client = new \Flc\Alidayu\Client(new \Flc\Alidayu\App([
        'app_key'    => config('alidayu.app_key'),
        'app_secret' => config('alidayu.app_secret'),
    ]));
    $req = new \Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend();
    //短信接收者
    $req->setRecNum($to)
        //模板参数
        ->setSmsParam($data)
        //阿里大于模板签名
        ->setSmsFreeSignName(config('alidayu.sms_free_sign_name'))
        //阿里大于短信模板
        ->setSmsTemplateCode($config['sms_template_code']);
    //发送短信
    $res = $client->execute($req);
    //返回结果
    if(isset($res->code)){
        return $res->code==0;
    }
    return $res->result->err_code==0;
}

/**
 * 二维码地址获取
 * @param string $content 二维码内容
 * @param int $level 容错级别 (0,1,2,3)
 * @param int $size 二维码大小
 * @param int $margin 二维码外边距
 * @return string
 */
function qrcodeUrl($content='',$level=0,$size = 3, $margin =4){
    return env('APP_URL')."/img/qrcode-png/$level/$size/$margin?content=".urlencode($content);
}
