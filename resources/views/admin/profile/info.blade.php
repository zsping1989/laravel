@extends('layouts.admin')
@section('title', '')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary" ng-controller="admin-profile-infoCtrl">
                <div class="box-header">
                    <h3 class="box-title">修改个人资料</h3>
                    <div class="box-tools">
                        <button class="btn btn-default btn-sm" title="刷新"
                                ng-click="getData($this,{refresh:1})">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" action="/admin/profile/info" method="post"
                          ng-init="data_url='/admin/profile/info';edit_url='/admin/profile/info';">
                        <div class="form-group row" ng-init="errorFieldMap['uname']='用户名'">
                            <div class="col-xs-2">
                                <label class="pull-right">用户名:</label>
                            </div>
                            <div class="col-xs-3">
                                <span>@{{row.uname}}</span>
                            </div>
                        </div>
                        <div class="form-group row" ng-init="errorFieldMap['mobile_phone']='电话'">
                            <div class="col-xs-2">
                                <label class="pull-right">电话:</label>
                            </div>
                            <div class="col-xs-3">
                                <span ng-if="!editdata">@{{row.mobile_phone}}</span>
                                <input ng-if="editdata" type="text" name="mobile_phone"  ng-model="row.mobile_phone"
                                       class="form-control">
                            </div>
                            <div class="col-xs-7" ng-if="!error.mobile_phone && editdata">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.mobile_phone && editdata">
                                            <span class="label-msg"
                                                  ng-repeat="info in error.mobile_phone">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row" ng-init="errorFieldMap['name']='昵称'">
                            <div class="col-xs-2">
                                <label class="pull-right">昵称:</label>
                            </div>
                            <div class="col-xs-3">
                                <span ng-if="!editdata">@{{row.name}}</span>
                                <input type="text" ng-if="editdata"  name="name" ng-model="row.name" class="form-control">
                            </div>
                            <div class="col-xs-7" ng-if="!error.name && editdata">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.name && editdata">
                                <span class="label-msg" ng-repeat="info in error.name">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-2">
                            </div>
                            <div class="col-xs-3">
                                <button ng-click="swicheditdata()" ng-if="!editdata" class="btn btn-info" type="button" >
                                    <i class="glyphicon glyphicon-ok"></i>
                                    <span>修改</span>
                                </button>
                                <button  ng-if="editdata" class="btn btn-info" type="button" ng-click="submit()">
                                    <i class="glyphicon glyphicon-ok"></i>
                                    <span>提交</span>
                                </button>

                                &nbsp; &nbsp; &nbsp;
                                <button class="btn" type="button" ng-click="resetdata()">
                                    <i class="glyphicon glyphicon-repeat"></i>
                                    重置
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
@stop



