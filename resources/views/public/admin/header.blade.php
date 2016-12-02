<div class="main-header">
    <a style="text-decoration:none;" href="/" class="logo">
        <span class="logo-mini"><b>后</b>台</span>
        <span class="logo-lg"><b>后台管理</b>系统</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a  class="sidebar-toggle" ng-click="left_hidden = !left_hidden" role="button">
        </a>
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li ng-repeat="(key,menu) in menus" ng-init="menus[key].toggle = nav[menu.id]"
                    ng-class="{'active':menus[key].toggle}" ng-if="menu.level==2 && menu.status==1">
                    <a href="@{{menu.url}}">
                        <i class="fa" ng-class="menu.icons"></i> <span>@{{menu.name}}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a  class="dropdown-toggle" data-animation="am-flip-x"
                        data-placement="bottom-right"
                        bs-dropdown
                        aria-haspopup="true"
                        aria-expanded="false">
                        <img src="/img/user2-160x160.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs">@{{user.uname}}</span>
                    </a>

                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                            <p>
                                个性签名
                                <small>2016-12-01</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/admin/profile/info" class="btn btn-default btn-flat">个人中心</a>
                            </div>
                            <div class="pull-right">
                                <a href="/home/auth/logout" class="btn btn-default btn-flat ts-admin-logout">退出登录</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a  data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>

    </nav>
</div>