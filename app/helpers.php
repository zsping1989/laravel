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
    $request->has('define') || $request->ajax() || $request->wantsJson());
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
        'redirect' => $to,
    ],$status);
}
