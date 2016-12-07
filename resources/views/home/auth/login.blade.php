<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta property="wb:webmaster" content="da9a03d241c53278" />
    <meta name="keywords" content="Laravel 后台管理系统,开源Laravel后台管理系统">
    <meta content="Laravel Admin是一款拥有极验验证,三方登录,QQ,新浪微博(weibo),阿里大于(alidayu)短信发送接口,邮件发送,支付宝支付,微信支付...等众多功能的后台管理系统.
    后台可视化代码生成工具方便大家更好的学习使用Laravel框架!" name="description" />
    <title>Laravel 后台管理系统</title>
    @include('public.css')
</head>
<body>
@include('public.js')
<div ng-app="app">
    <div class="login-box">
        <div class="login-logo">
            <a><b>后台管理</b>系统</a>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">请先登录</p>
            <form  class="login-form" id="login_form" ng-controller="home-loginCtrl" method="post">
                <div class="form-group has-feedback">
                    <input type="text" name="username" ng-model="username" ng-init="errorFieldMap['uname']='用户名'" class="form-control" placeholder="请填写用户名">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" ng-model="password"  ng-init="errorFieldMap['password']='密码'"  class="form-control" placeholder="请输入密码">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback" ng-init="errorFieldMap['geetest_challenge']='验证码'">
                    <div id="geetest-captcha"></div>
                    <p id="wait" class="show">正在加载验证码...</p>
                </div>
              {{--  <div class="form-group has-feedback">
                    <input type="text" name="verify" class="form-control"  ng-init="errorFieldMap['verify']='验证码'" ng-model="verify" placeholder="请填写验证码"  autocomplete="off">
                    <span class="glyphicon glyphicon-refresh form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">

                    <img class="verifyimg reloadverify" alt="点击切换"
                         ng-click="switchCaptcha()"  ng-src="@{{captcha || '/home/auth/captcha'}}">
                    <a class="reloadverify" title="换一张" ng-click="switchCaptcha()" href="javascript:void(0)">换一张？</a>
                </div>--}}
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                　　　<input type="checkbox" class="ts-icheck" ng-model="remember" name="remember" value="1"> 记住登录
                            </label>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                    </div><!-- /.col -->
                </div>

                <div class="form-group has-feedback text-center" style="color: red">
                    <span ng-repeat="info in error.verify">@{{info}}</span>
                    <span ng-repeat="info in error.geetest_challenge">@{{info}}</span>
                    <span  ng-repeat="info in error.uname">@{{info}}</span>
                    <span ng-repeat="info in error.email">@{{info}}</span>
                    <span ng-repeat="info in error.mobile_phone">@{{info}}</span>
                    <span  ng-repeat="info in error.password">@{{info}}</span>
                </div>
            </form>
            <div class="social-auth-links text-center">
                <p>- 其它方式登录 -</p>
                <a href="/home/auth/other/weibo" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-weibo"></i>新浪微博</a>
                <a href="/home/auth/other/qq" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-qq"></i>腾讯QQ</a>
                <a href="/home/auth/other/weixin" class="btn btn-block btn-social btn-primary btn-flat"><i class="fa fa-weixin"></i>微信</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>