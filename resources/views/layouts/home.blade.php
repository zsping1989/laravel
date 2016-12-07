<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta property="wb:webmaster" content="da9a03d241c53278" />
    <meta name="keywords" content="Laravel 后台管理系统,开源Laravel后台管理系统">
    <meta content="Laravel Admin是一款拥有极验验证,三方登录,QQ,新浪微博(weibo),阿里大于(alidayu)短信发送接口,邮件发送,支付宝支付,微信支付...等众多功能的后台管理系统.
    后台可视化代码生成工具方便大家更好的学习使用Laravel框架!" name="description" />
    <title>@yield('title')网</title>
    @include('public.css')
</head>
<body id="index">
<div ng-app="app" ng-cloak>
    <div id="header">
        <div class="page-container" id="nav">
            <div id="logo" class="logo"><a href="http://www.imooc.com/" target="_self" class="hide-text">慕课网</a></div>

            <button type="button" class="navbar-toggle visible-xs-block js-show-menu">
                <i class="sz-list"></i>
            </button>

            <div class="g-menu-mini l">
                <a href="javascript:;" class="menu-ctrl">
                    <i class="sz-list"></i>
                </a>
                <ul class="nav-item l">
                    <li class="set-btn visible-xs-block"><a href="http://www.imooc.com/user/newlogin" target="_self">登录</a> / <a href="http://www.imooc.com/user/newsignup" target="_self">注册</a></li>

                    <li><a href="http://www.imooc.com" target="_self">首页</a></li>
                    <li><a href="/" class="active" target="_self">实战</a></li>
                    <li><a href="http://www.imooc.com/course/program" target="_self">路径</a></li>
                    <!--<li><a href="http://www.imooc.com/corp/index"   target="_self">分享</a></li>-->
                    <li><a href="http://www.imooc.com/wenda" target="_self">猿问</a></li>
                    <li><a href="http://www.imooc.com/article" target="_self">手记</a></li>
                    <!--<li><a href="http://www.imooc.com/wiki" target="_self">WIKI</a></li>-->

                </ul>
            </div>
            <div id="login-area">
                <ul class="header-unlogin clearfix">
                    <li class="header-app">
                        <a href="http://www.imooc.com/mobile/app">
                            <span class="sz-appdownload"></span>
                        </a>
                        <div class="QR-download">
                            <p id="app-text">慕课网APP下载</p>
                            <p id="app-type">iPhone / Android / iPad</p>
                            <img src="/static/module/common/img/QR-code.jpg">
                        </div>
                    </li>
                    <li class="header-signin">
                        <a href="#" id="js-signin-btn">登录</a>
                    </li>
                    <li class="header-signup">
                        <a href="#" id="js-signup-btn">注册</a>
                    </li>
                </ul>
            </div>
            <div class="search-warp clearfix" style="min-width: 32px; height: 60px;">

                <div class="pa searchTags js-searchtags" style="display: block;"><a href="http://www.imooc.com/act/luckydraw/index.html" target="_blank">11.11</a><a href="http://coding.imooc.com/class/62.html" target="_blank">Python</a></div>

                <div class="search-area" data-search="top-banner">
                    <input class="search-input" data-suggest-trigger="suggest-trigger" placeholder="" autocomplete="off" type="text">
                    <input class="btn_search" data-search-btn="search-btn" type="hidden">
                    <ul class="search-area-result" data-suggest-result="suggest-result" style=""></ul>
                </div>
                <div class="showhide-search" data-show="no"><i class="sz-search"></i></div>
            </div>
        </div>
    </div>
</div>

</body>
</html>