@extends('layouts.admin')
@section('title', '')
@section('content')
    <div class="row"  ng-controller="admin-profile-messageCtrl">
        <div class="col-md-3">
            <a class="btn btn-primary btn-block margin-bottom">工具栏</a>
            <div class="box box-solid" ng-class="{'collapsed-box':hidden_tool==1}">
                <div class="box-header with-border">
                    <h3 class="box-title">消息分组</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse" ng-click="hidden_tool = !hidden_tool">
                            <i class="fa fa-minus" ng-if="!hidden_tool"></i>
                            <i class="fa fa-plus" ng-if="hidden_tool"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li ng-class="{'active':(!where[1].val || where[1].val==message_count['messages']['childs'])}"  ng-click="switch(1,'');">
                            <a>
                                <i class="fa fa-inbox"></i> 所有消息
                                <span class="label label-primary pull-right" ng-if="message_count['messages']['msg_count']">@{{message_count['messages']['msg_count']}}</span>
                            </a>
                        </li>
                        <li ng-class="{'active':where[1].val==message_count['user']['childs']}" ng-click="switch(1,message_count['user']['childs']);">
                            <a>
                                <i class="fa fa-envelope-o"></i> 用户消息
                                <span class="label label-warning pull-right" ng-if="message_count['user']['msg_count']">@{{message_count['user']['msg_count']}}</span>
                            </a>
                        </li>
                        <li ng-class="{'active':where[1].val==message_count['system']['childs']}" ng-click="switch(1,message_count['system']['childs']);">
                            <a><i class="fa fa-bell-o"></i> 系统消息
                                <span class="label label-danger pull-right" ng-if="message_count['system']['msg_count']">@{{message_count['system']['msg_count']}}</span>
                            </a>
                        </li>
                        <li><a><i class="fa fa-file-text-o"></i> 已发消息</a></li>
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /. box -->
            <div class="box box-solid" ng-class="{'collapsed-box':hidden_lable==1}" >
                <div class="box-header with-border">
                    <h3 class="box-title">标记</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse" ng-click="hidden_lable = !hidden_lable">
                            <i class="fa fa-minus" ng-if="!hidden_lable"></i>
                            <i class="fa fa-plus" ng-if="hidden_lable"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li ng-class="{'active':!where[2].val}" ng-click="switch(2,'');">
                            <a><i class="fa fa-circle-o text-red"></i> 所有</a>
                        </li>
                        <li  ng-class="{'active':where[2].val=='1'}" ng-click="switch(2,'1');">
                            <a><i class="fa fa-circle-o text-yellow"></i> 已读</a>
                        </li>
                        <li  ng-class="{'active':where[2].val=='0'}" ng-click="switch(2,'0');">
                            <a><i class="fa fa-circle-o text-light-blue"></i> 未读</a>
                        </li>
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary"
                 ng-init="data_url='/admin/profile/list';delete_url='/admin/profile/destroy'">
                            <div class="box-header with-border">
                                <h3 class="box-title">用户消息列表</h3>
                                <div class="box-tools">
                                    <div class="input-group">
                                        <input type="text" ng-init="where[0].key='id';where[0].exp='like';where[0].val= where[0].val || '';"
                                               ng-model="where[0].val" placeholder="Search"
                                               class="form-control input-sm pull-right">
                                        <input type="hidden" ng-init="where[1].key='msgtpl_id';where[1].exp='in';where[1].val= where[1].val || '';"
                                               class="form-control input-sm pull-right">
                                        <input type="hidden" ng-init="where[2].key='read';where[2].exp='=';where[2].val= where[2].val || '';"
                                               class="form-control input-sm pull-right">
                                        <div class="input-group-btn">
                                            <button ng-init="reset=where[0].val ? 1 : 0" ng-click="getData($this)"
                                                    class="btn btn-sm btn-default"><i class="fa fa-search"></i>
                                            </button>
                                            <button type="button" ng-click="getData($this,{reset:1})"
                                                    class="btn btn-sm btn-default"><i class="fa  fa-repeat"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="dataTables_wrapper form-inline dt-bootstrap">
                                    <div class="row">
                                        <div class="col-sm-6"></div>
                                        <div class="col-sm-6"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-hover dataTable">
                                                <tr role="row">
                                                    <th class="sorting" style="width: 30px;">
                                                        <input type="checkbox" value="1" name="selectAll"
                                                               ng-click="selectAllId($this,selectAll)"
                                                               ng-model="selectAll">
                                                    </th>
                                                    <th class="sorting ">ID
                                                        <span ng-click="getData($this,{'order':'id'})"
                                                              ng-class="{'glyphicon glyphicon-sort-by-attributes-alt':order.id=='desc','glyphicon glyphicon-sort-by-attributes':order.id!='desc'}">
                                                        </span>
                                                    </th>
                                                    <th class="sorting ">是否已读
                                                        <span ng-click="getData($this,{'order':'read'})"
                                                            ng-class="{'glyphicon glyphicon-sort-by-attributes-alt':order.read=='desc','glyphicon glyphicon-sort-by-attributes':order.read!='desc'}">
                                                        </span>
                                                    </th>
                                                    <th class="sorting ">消息主题                                                                    <span
                                                            ng-click="getData($this,{'order':'subject'})"
                                                            ng-class="{'glyphicon glyphicon-sort-by-attributes-alt':order.subject=='desc','glyphicon glyphicon-sort-by-attributes':order.subject!='desc'}"></span>
                                                    </th>
                                                    <th class="sorting ">消息内容
                                                        <span ng-click="getData($this,{'order':'content'})"
                                                            ng-class="{'glyphicon glyphicon-sort-by-attributes-alt':order.content=='desc','glyphicon glyphicon-sort-by-attributes':order.content!='desc'}"></span>
                                                    </th>
                                                    <th class="sorting  visible-lg ">创建时间 <i
                                                            class="glyphicon glyphicon-time"></i>                                                                     <span
                                                            ng-click="getData($this,{'order':'created_at'})"
                                                            ng-class="{'glyphicon glyphicon-sort-by-attributes-alt':order.created_at=='desc','glyphicon glyphicon-sort-by-attributes':order.created_at!='desc'}"></span>
                                                    </th>
                                                </tr>
                                                <tr ng-repeat="row in data" role="row">
                                                    <td>
                                                        <input type="checkbox" value="@{{row.id}}" name="ids[]" ng-model="ids[$index]"
                 ng-init="allIds[$index] = row.id"
                 ng-true-value="@{{row.id}}" ng-checked="selectAll">
                </td>
                <td>@{{row.id}}</td>
                <td>
                    <span class="label label-primary" ng-if="row.read=='0'">未读</span>
                    <span class="label label-success" ng-if="row.read=='1'">已读</span>
                </td>
                <td>@{{row.subject}}</td>
                <td>@{{row.content}}</td>
                <td class="visible-lg">@{{ row.format_time}}</td>
                </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <button class="btn btn-default btn-sm" title="删除选中"  ng-click="delete($this)">
                    <i class="fa fa-trash-o"></i>
                </button>
                <button class="btn btn-default btn-sm" title="刷新" ng-click="getData($this,{refresh:1})">
                    <i class="fa fa-refresh"></i>
                </button>
            </div>
            <div class="col-sm-7 ">
                <div class="pull-right">
                    @include('public.page')
                </div>
            </div>
        </div>
    </div>
@stop

