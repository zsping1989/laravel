<div class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>@{{user.name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>
        <!-- search form -->
        <div class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="搜索">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li ng-repeat="(key,menu) in menus" class="treeview" ng-init="menus[key].toggle = nav[menu.id]"
                ng-class="{'active':menus[key].toggle}" ng-if="menu.level==3 && menu.status==1 && menu.parent_id==nav[navkeys[0]]['id']">
                <a ng-href="@{{menu.url}}" ng-click="menus[key].toggle =!menus[key].toggle">
                    <i class="fa" ng-class="menu.icons"></i> <span>@{{menu.name}}</span> <i class="fa @{{ menu.right_margin-1!=menu.left_margin ? 'fa-angle-left':'' }} pull-right"></i>
                </a>
                <ul class="treeview-menu" ng-class="{'menu-open':menus[key].toggle}">
                    <li  ng-repeat="row in menus" ng-class="{'active':nav[row.id]}"  ng-if="row.level==4 && row.parent_id==menu.id && row.status==1" >
                        <a ng-href="@{{row.url}}"><i class="fa" ng-class="row.icons"></i>@{{row.name}}</a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
</div>