@extends('layouts.admin')
@section('title', '')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary" ng-controller="admin-role-editCtrl">
                <div class="box-header">
                    <h3 class="box-title" ng-if="row.id">修改角色</h3>
                    <h3 class="box-title" ng-if="!row.id">新增角色</h3>
                    <div class="box-tools">
                        <button class="btn btn-default btn-sm" title="刷新"
                                ng-click="getData($this,{refresh:1})">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" action="/admin/role/edit" method="post"
                          ng-init="data_url='/admin/role/edit/'+row.id;edit_url='/admin/role/edit';back_url='/admin/role/index'">
                        <div class="form-group row" ng-init="errorFieldMap['name']='角色名称'">
                            <div class="col-xs-2">
                                <label class="pull-right">角色名称:</label>
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
                        <div class="form-group row" ng-init="errorFieldMap['description']='描述'">
                            <div class="col-xs-2">
                                <label class="pull-right">描述:</label>
                            </div>
                            <div class="col-xs-3">
                                            <textarea name="description" ng-model="row.description"
                                                      class="form-control">@{{row.description}}</textarea>
                            </div>
                            <div class="col-xs-7" ng-if="!error.description">
                                <span class="label-msg">填写提示信息!</span>
                            </div>
                            <div class="col-xs-7 error-msg" ng-if="error.description">
                                            <span class="label-msg"
                                                  ng-repeat="info in error.description">@{{info}}</span>
                            </div>
                        </div>
                        <div class="form-group row" ng-init="errorFieldMap['parent_id']='父级ID'">
                            <div class="col-xs-2">
                                <label class="pull-right">父级ID:</label>
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
                        <div class="form-group row" ng-init="errorFieldMap['parent_id']='父级ID'">
                            <div class="col-xs-2">
                                <label class="pull-right">拥有角色的用户:</label>
                            </div>
                            <div class="col-xs-10">
                                <span ng-repeat="user in users" title="@{{user.name}}" class="label label-primary">@{{user.uname}}</span>
                            </div>
                        </div>
                        <div class="form-group row" ng-init="errorFieldMap['permissions']='权限'">
                            <div class="col-xs-2">
                                <label class="pull-right">角色权限:</label>
                            </div>
                            <div class="col-xs-10" ng-init="new_permissions = []">
                                            <span ng-repeat="permission in permissions">
                                                <br ng-if="$index>0 && permission['level']!=permissions[$index-1]['level']" />
                                                @{{ ($index>0 && permission['level']==permissions[$index-1]['level']) ? '　　':('deep' | F : permission.level-1)}}
                                                <input type="checkbox"
                                                       ng-true-value="@{{permission.id}}"
                                                       name="new_permissions[]"
                                                       value="permission.id"
                                                       ng-click="checkedp(new_permissions[$index],permission.left_margin,permission.right_margin)"
                                                       ng-disabled="(row.id==1 || !canEdit)"
                                                       ng-checked="(row.id==1 || permission.checked)"
                                                       ng-init="new_permissions[$index] = permission.checked ? permission.id : 0"
                                                       ng-model="new_permissions[$index]"> @{{permission.name}}
                                            </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-2">
                            </div>
                            <div class="col-xs-3">
                                <input name="id" value="@{{row.id}}" type="hidden">
                                <button class="btn " ng-class="canEdit ? 'btn-info':'btn-default' " type="button" ng-click="submit()">
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



