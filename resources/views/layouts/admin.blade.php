<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')后台管理系统</title>
    @include('public.css')
</head>
<body>
@include('public.js')

<div ng-app="app">
    <div class="skin-blue sidebar-mini" ng-class="{'sidebar-collapse':left_hidden}">
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
