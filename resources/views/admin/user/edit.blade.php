@extends('layouts.admin')
@section('title', '')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary" ng-controller="admin-user-editCtrl">
                <div class="box-header">
                    <h3 class="box-title" ng-if="row.id">修改用户</h3>
                    <h3 class="box-title" ng-if="!row.id">新增用户</h3>
                    <div class="box-tools">
                        <button class="btn btn-default btn-sm" title="刷新"
                                ng-click="getData($this,{refresh:1})">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" action="/admin/user/edit" method="post"
                          ng-init="data_url='/admin/user/edit/'+row.id;edit_url='/admin/user/edit';back_url='/admin/user/index'">
                        <div class="form-group row" ng-init="errorFieldMap['uname']='用户名'">
                            <div class="col-xs-2">
                                <label class="pull-right">用户名:</label>
                            </div>
                            <div class="col-xs-3">
                                <input type="text" name="uname" ng-model="row.uname" ng-disabled="row.id" class="form-control">
                            </div>
                            <div class="col-xs-7" ng-if="!error.uname">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.uname">
                                <span class="label-msg" ng-repeat="info in error.uname">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row" ng-init="errorFieldMap['email']='电子邮箱'">
                            <div class="col-xs-2">
                                <label class="pull-right">电子邮箱:</label>
                            </div>
                            <div class="col-xs-3">
                                <input type="text" name="email" ng-disabled="row.id" ng-model="row.email" class="form-control">
                            </div>
                            <div class="col-xs-7" ng-if="!error.email">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.email">
                                <span class="label-msg" ng-repeat="info in error.email">@{{info}}</span>
                            </div>
                        </div>

                        <div class="form-group row" ng-init="errorFieldMap['mobile_phone']='电话'">
                            <div class="col-xs-2">
                                <label class="pull-right">电话:</label>
                            </div>
                            <div class="col-xs-3">
                                <input type="text" name="mobile_phone" ng-disabled="row.id" ng-model="row.mobile_phone"
                                       class="form-control">
                            </div>
                            <div class="col-xs-7" ng-if="!error.mobile_phone">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.mobile_phone">
                                            <span class="label-msg"
                                                  ng-repeat="info in error.mobile_phone">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row" ng-init="errorFieldMap['name']='昵称'">
                            <div class="col-xs-2">
                                <label class="pull-right">昵称:</label>
                            </div>
                            <div class="col-xs-3">
                                <input type="text" name="name" ng-model="row.name" class="form-control">
                            </div>
                            <div class="col-xs-7" ng-if="!error.name">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.name">
                                <span class="label-msg" ng-repeat="info in error.name">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row" ng-init="errorFieldMap['qq']='QQ号码'">
                            <div class="col-xs-2">
                                <label class="pull-right">QQ号码:</label>
                            </div>
                            <div class="col-xs-3">
                                <input type="text" name="qq" ng-model="row.qq" class="form-control">
                            </div>
                            <div class="col-xs-7" ng-if="!error.qq">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.qq">
                                <span class="label-msg" ng-repeat="info in error.qq">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row" ng-init="errorFieldMap['status']='状态'">
                            <div class="col-xs-2">
                                <label class="pull-right">状态:</label>
                            </div>
                            <div class="col-xs-3">
                                <input type="radio" name="status" value="0" ng-model="row.status"> 未激活　　
                                <input type="radio" name="status" value="1" ng-model="row.status"> 已激活　　
                            </div>
                            <div class="col-xs-7" ng-if="!error.status">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.status">
                                <span class="label-msg" ng-repeat="info in error.status">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row" ng-init="errorFieldMap['admin']='管理员'">
                            <div class="col-xs-2">
                                <label class="pull-right">设置管理员:</label>
                            </div>
                            <div class="col-xs-3" ng-init="row.admin.isAdmin = row.admin.isAdmin ? row.admin.isAdmin : 0">
                                <input type="radio" name="admin" value="0" ng-model="row.admin.isAdmin" ng-disabled="row.admin.isAdmin &&  row.disabled"> 否　　
                                <input type="radio" name="admin" value="1" ng-model="row.admin.isAdmin" ng-disabled="row.admin.isAdmin &&  row.disabled"> 是　　
                            </div>
                            <div class="col-xs-7" ng-if="!error.isAdmin">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.isAdmin">
                                <span class="label-msg" ng-repeat="info in error.isAdmin">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row" ng-if="row.admin.isAdmin==1" >
                            <div class="col-xs-2">
                                <label class="pull-right">用户角色:</label>
                            </div>
                            <div class="col-xs-10">
                                            <span  ng-repeat="role in roles">
                                                <br ng-if="$index>0 && role['level']!=roles[$index-1]['level']" />
                                                @{{ ($index>0 && role['level']==roles[$index-1]['level']) ? ' ':('deep' | F : role.level)}}
                                                <input type="checkbox"
                                                       value="@{{role.id}}"
                                                       ng-true-value="@{{role.id}}"
                                                       name="new_roles[]"
                                                       ng-init="new_roles[$index] = role.checked ? role.id : 0"
                                                       ng-model="new_roles[$index]"
                                                       ng-disabled="role.disabled"
                                                       ng-checked="role.checked" >
                                                <span title="@{{role.name}}" class="label label-primary">@{{role.name}}</span>　
                                            </span>
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



