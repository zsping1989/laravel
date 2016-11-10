@extends('layouts.admin')
@section('title', '')
@section('content')
    <div class="row">
        <div class="col-xs-12">
        <div class="box box-primary" ng-controller="admin-menu-editCtrl">
            <div class="box-header">
                <h3 class="box-title" ng-if="row.id">修改菜单</h3>
                <h3 class="box-title" ng-if="!row.id">新增菜单</h3>
                <div class="box-tools">
                    <button class="btn btn-default btn-sm" title="刷新"
                            ng-click="getData($this,{refresh:1})">
                        <i class="fa fa-refresh"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <form role="form" action="/admin/menu/edit" method="post"
                      ng-init="data_url='/admin/menu/edit/'+row.id;edit_url='/admin/menu/edit';;back_url='/admin/menu/index'">
                    <div bs-tabs>
                        <div data-title="基本信息" name="基本信息" bs-pane>
                            <div class="box-body">
                                <div class="form-group row" ng-init="errorFieldMap['name']='菜单名称'">
                                    <div class="col-xs-2">
                                        <label class="pull-right">菜单名称:</label>
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
                                <div class="form-group row" ng-init="errorFieldMap['icons']='图标'">
                                    <div class="col-xs-2">
                                        <label class="pull-right">图标:</label>
                                    </div>
                                    <div class="col-xs-3">
                                        <input type="text" name="icons" ng-model="row.icons" class="form-control">
                                    </div>
                                    <div class="col-xs-7" ng-if="!error.icons">
                                        <span class="label-msg">填写提示信息!</span>
                                    </div>
                                    <div class="col-xs-7 error-msg" ng-if="error.icons">
                                        <span class="label-msg" ng-repeat="info in error.icons">@{{info}}</span>
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
                                <div class="form-group row" ng-init="errorFieldMap['prefix']='URL前缀'">
                                    <div class="col-xs-2">
                                        <label class="pull-right">URL前缀:</label>
                                    </div>
                                    <div class="col-xs-3">
                                        <input type="radio" name="prefix" value="" ng-model="row.prefix"> 跳转刷新　　
                                        <input type="radio" name="prefix" value="#" ng-model="row.prefix"> 前端刷新　　
                                    </div>
                                    <div class="col-xs-7" ng-if="!error.prefix">
                                        <span class="label-msg">填写提示信息!</span>
                                    </div>
                                    <div class="col-xs-7 error-msg" ng-if="error.prefix">
                                        <span class="label-msg" ng-repeat="info in error.prefix">@{{info}}</span>
                                    </div>
                                </div>
                                <div class="form-group row" ng-init="errorFieldMap['url']='URL路径'">
                                    <div class="col-xs-2">
                                        <label class="pull-right">URL路径:</label>
                                    </div>
                                    <div class="col-xs-3">
                                        <input type="text" name="url" ng-model="row.url" class="form-control">
                                    </div>
                                    <div class="col-xs-7" ng-if="!error.url">
                                        <span class="label-msg">填写提示信息!</span>
                                    </div>
                                    <div class="col-xs-7 error-msg" ng-if="error.url">
                                        <span class="label-msg" ng-repeat="info in error.url">@{{info}}</span>
                                    </div>
                                </div>
                                <div class="form-group row" ng-init="errorFieldMap['method']='请求方式'">
                                    <div class="col-xs-2">
                                        <label class="pull-right">请求方式:</label>
                                    </div>
                                    <div class="col-xs-3">
                                        <input type="radio" name="method" value="1" ng-model="row.method"> get　　
                                        <input type="radio" name="method" value="2" ng-model="row.method"> post　　
                                        <input type="radio" name="method" value="3" ng-model="row.method"> put　　
                                    </div>
                                    <div class="col-xs-7" ng-if="!error.method">
                                        <span class="label-msg">填写提示信息!</span>
                                    </div>
                                    <div class="col-xs-7 error-msg" ng-if="error.method">
                                        <span class="label-msg" ng-repeat="info in error.method">@{{info}}</span>
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
                                <div class="form-group row" ng-init="errorFieldMap['is_page']='是否为页面'">
                                    <div class="col-xs-2">
                                        <label class="pull-right">是否为页面:</label>
                                    </div>
                                    <div class="col-xs-3">
                                        <input type="radio" name="is_page" value="1" ng-model="row.is_page"> 是　　
                                        <input type="radio" name="is_page" value="0" ng-model="row.is_page"> 否　　
                                    </div>
                                    <div class="col-xs-7" ng-if="!error.is_page">
                                        <span class="label-msg">填写提示信息!</span>
                                    </div>
                                    <div class="col-xs-7 error-msg" ng-if="error.is_page">
                                        <span class="label-msg" ng-repeat="info in error.is_page">@{{info}}</span>
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
                            </div>
                        </div>
                        <div data-title="请求参数" name="请求参数" bs-pane>
                            <div class="box-body">
                                <table class="table table-hover table-bordered">
                                    <tr>
                                        <th>序号</th>
                                        <th>变量名</th>
                                        <th>事例</th>
                                        <th>变量名标题</th>

                                        <th>是否必填</th>
                                        <th>描述</th>
                                        <th>操作</th>
                                    </tr>
                                    <tr ng-repeat="x in row.params">
                                        <td>@{{$index+1}}</td>
                                        <td>@{{x.name}}</td>
                                        <td>@{{x.example}}</td>
                                        <td>@{{x.title}}</td>
                                        <td ng-if="x.required==1">必填</td>
                                        <td ng-if="x.required!=1">选填</td>
                                        <td>
                                            @{{x.description}}
                                        </td>
                                        <td>
                                            <a class="btn btn-xs btn-info" title="编辑" role="button" ng-click="editParam($index)">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </a>
                                            <button class="btn btn-xs btn-danger" title="删除" type="button" ng-click="deleteParam($index)">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                                <br />
                                <div class="row">
                                    <div class="col-sm-5">
                                        <a class="btn btn-default btn-sm" title="添加" ng-click="editParam()">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-title="响应说明" name="响应说明" bs-pane>
                            <div class="box-body">
                                <table class="table table-hover table-bordered">
                                    <tr>
                                        <th>序号</th>
                                        <th>结果字段</th>
                                        <th>描述</th>
                                        <th>操作</th>
                                    </tr>
                                    <tr ng-repeat="x in row.responses">
                                        <td>@{{$index+1}}</td>
                                        <td>@{{x.name}}</td>
                                        <td>@{{x.description}}</td>
                                        <td>
                                            <a class="btn btn-xs btn-info" title="编辑" role="button" ng-click="editResponse($index)">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </a>
                                            <button class="btn btn-xs btn-danger" title="删除" type="button" ng-click="deleteResponse($index)">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                                <br />
                                <div class="row">
                                    <div class="col-sm-5">
                                        <a class="btn btn-default btn-sm" title="添加" ng-click="editResponse()">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
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
    </div>
@stop



