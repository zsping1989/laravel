@extends('layouts.admin')
@section('title', '')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary" ng-controller="admin-profile-passwordCtrl">
                <div class="box-header">
                    <h3 class="box-title">修改密码</h3>
                    <div class="box-tools">
                        <button class="btn btn-default btn-sm" title="刷新"
                                ng-click="getData($this,{refresh:1})">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" action="'/admin/profile/password" method="post"
                          ng-init="data_url='/admin/profile/password';edit_url='/admin/profile/password';">
                        <div class="form-group row" ng-init="errorFieldMap['old_password']='原密码'">
                            <div class="col-xs-2">
                                <label class="pull-right">原密码:</label>
                            </div>
                            <div class="col-xs-3">
                                <input type="password" name="old_password" ng-model="row.old_password"
                                       class="form-control">
                            </div>
                            <div class="col-xs-7" ng-if="!error.old_password">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.old_password">
                                <span class="label-msg" ng-repeat="info in error.old_password">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row" ng-init="errorFieldMap['password']='新密码'">
                            <div class="col-xs-2">
                                <label class="pull-right">新密码:</label>
                            </div>
                            <div class="col-xs-3">
                                <input type="password" name="password" ng-model="row.password"
                                       class="form-control">
                            </div>
                            <div class="col-xs-7" ng-if="!error.password">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.password">
                                <span class="label-msg" ng-repeat="info in error.password">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row" ng-init="errorFieldMap['password_confirmation']='确认密码'">
                            <div class="col-xs-2">
                                <label class="pull-right">确认密码:</label>
                            </div>
                            <div class="col-xs-3">
                                <input type="password" name="password" ng-model="row.password_confirmation"
                                       class="form-control">
                            </div>
                            <div class="col-xs-7" ng-if="!error.password_confirmation">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.password_confirmation">
                                <span class="label-msg" ng-repeat="info in error.password_confirmation">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-2">
                            </div>
                            <div class="col-xs-3">
                                <input type="hidden" name="token" ng-model="row.token">
                                <button class="btn btn-info" type="button" ng-click="submit()">
                                    <i class="glyphicon glyphicon-ok"></i>
                                    提交
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