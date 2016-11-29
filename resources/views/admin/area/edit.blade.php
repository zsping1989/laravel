@extends('layouts.admin')
@section('title', '')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary" ng-controller="admin-area-editCtrl">
                <div class="box-header">
                    <h3 class="box-title" ng-if="row.id">修改地区</h3>
                    <h3 class="box-title" ng-if="!row.id">新增地区</h3>
                    <div class="box-tools">
                        <button class="btn btn-default btn-sm" title="刷新"
                                ng-click="getData($this,{refresh:1})">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" action="/admin/area/edit" method="post"
                          ng-init="data_url='/admin/area/edit/'+row.id;edit_url='/admin/area/edit';back_url='/admin/area/index'">
                        <div class="form-group row" ng-init="errorFieldMap['name']='名称'">
                            <div class="col-xs-2">
                                <label class="pull-right">名称:</label>
                            </div>
                            <div class="col-xs-3">
                                <input type="text" name="name" ng-model="row['name']" class="form-control">
                            </div>
                            <div class="col-xs-7" ng-if="!error.name">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.name">
                                <span class="label-msg" ng-repeat="info in error.name">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row" ng-init="errorFieldMap['status']='状态'">
                            <div class="col-xs-2">
                                <label class="pull-right">状态:</label>
                            </div>
                            <div class="col-xs-3">
                                <input type="radio" name="status" value="1" ng-model="row.status"> 显示　　
                                <input type="radio" name="status" value="2" ng-model="row.status"> 不显示　　
                            </div>
                            <div class="col-xs-7" ng-if="!error.status">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.status">
                                <span class="label-msg" ng-repeat="info in error.status">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row" ng-init="errorFieldMap['parent_id']='父ID'">
                            <div class="col-xs-2">
                                <label class="pull-right">父ID:</label>
                            </div>
                            <div class="col-xs-3">
                                <input type="text" name="parent_id" ng-model="row.parent_id"
                                       class="form-control">
                            </div>
                            <div class="col-xs-7" ng-if="!error.parent_id">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.parent_id">
                                <span class="label-msg" ng-repeat="info in error.parent_id">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-2">
                            </div>
                            <div class="col-xs-3">
                                <input name="id" value="@{{row.id}}" type="hidden">
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


