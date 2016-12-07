<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta property="wb:webmaster" content="da9a03d241c53278" />
    <meta name="keywords" content="Laravel 后台管理系统,开源Laravel后台管理系统">
    <meta content="Laravel Admin是一款拥有极验验证,三方登录,QQ,新浪微博(weibo),阿里大于(alidayu)短信发送接口,邮件发送,支付宝支付,微信支付...等众多功能的后台管理系统.
    后台可视化代码生成工具方便大家更好的学习使用Laravel框架!" name="description" />
    <title>@yield('title')Laravel后台管理系统</title>
    @include('public.css')
</head>
<body>
@include('public.js')

<div ng-app="app" ng-cloak>
    <div class="skin-blue sidebar-mini" ng-class="{'sidebar-collapse sidebar-open':left_hidden}">
        <div class="wrapper">
            @include('public.admin.header')
            @include('public.admin.left')
            <div  class="content-wrapper">
                @include('public.admin.nav')
                <section class="content">
                    @yield('content')
                </section>
            </div>
        </div>
    </div>
</div>
</body>
</html>
