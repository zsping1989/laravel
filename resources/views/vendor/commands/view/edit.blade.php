@@extends('layouts.admin')
@@section('title', '')
@@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary" ng-controller="{{$tpl_controller}}">
                <div class="box-header">
                    <h3 class="box-title" ng-if="row.id">修改{{$table_comment}}</h3>
                    <h3 class="box-title" ng-if="!row.id">新增{{$table_comment}}</h3>
                    <div class="box-tools">
                        <button class="btn btn-default btn-sm" title="刷新"
                                ng-click="getData($this,{refresh:1})">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form"  action="/{{$dirname}}/edit" method="post" ng-init="data_url='/{{$dirname}}/edit/'+row['id'];edit_url='/{{$dirname}}/edit';back_url='/{{$dirname}}/index'">
                        @foreach ($table_fields as $field)
                            @if(in_array($field->showType,['hidden','delete','password']) ||in_array($field->Field,['updated_at','id','created_at','deleted_at']) )
                            @elseif($field->showType=='time')
                                <div class="form-group row" ng-init="errorFieldMap['{{$field->Field}}']='{{$field->info}}'" ng-class="{'has-error': datepickerForm.{{$field->Field}}.$invalid}">
                                    <div class="col-xs-2">
                                        <label class="pull-right">{{$field->info}}:</label>
                                    </div>
                                    <div class="col-xs-3">
                                        <input ng-model="row['{{$field->Field}}']" name="{{$field->Field}}" class="form-control" data-date-format="yyyy-MM-dd" data-date-type="number" data-min-date="" data-max-date="today" data-autoclose="1"  bs-datepicker type="text">
                                    </div>
                                    <div class="col-xs-7" ng-if="!error.{{$field->Field}}">
                                        <span  class="label-msg">填写提示信息!</span>
                                    </div>
                                    <div class="col-xs-7 error-msg" ng-if="error.{{$field->Field}}">
                                        <span class="label-msg" ng-repeat="info in error.{{$field->Field}}">@@{{info}}</span>
                                    </div>
                                </div>
                            @elseif($field->showType=='radio')
                                <div class="form-group row"  ng-init="errorFieldMap['{{$field->Field}}']='{{$field->info}}'">
                                    <div class="col-xs-2">
                                        <label class="pull-right">{{$field->info}}:</label>
                                    </div>
                                    <div class="col-xs-3">
                                        @foreach ($field->values as $key=>$value)
                                            <input type="radio" name="{{$field->Field}}" value="{{$key}}" ng-model="row['{{$field->Field}}']"> {{$value}}　　
                                        @endforeach
                                    </div>
                                    <div class="col-xs-7" ng-if="!error.{{$field->Field}}">
                                        <span  class="label-msg">填写提示信息!</span>
                                    </div>
                                    <div class="col-xs-7 error-msg" ng-if="error.{{$field->Field}}">
                                        <span class="label-msg" ng-repeat="info in error.{{$field->Field}}">@@{{info}}</span>
                                    </div>
                                </div>
                            @elseif($field->showType=='checkbox')
                                <div class="form-group row"  ng-init="errorFieldMap['{{$field->Field}}']='{{$field->info}}'">
                                    <div class="col-xs-2">
                                        <label class="pull-right">{{$field->info}}:</label>
                                    </div>
                                    <div class="col-xs-3" ng-init="row['{{$field->Field}}']=binaryToArray(row['{{$field->Field}}'])">
                                        @foreach ($field->values as $key=>$value)
                                            <input type="checkbox" name="{{$field->Field}}" value="{{$key}}" ng-model="row['{{$field->Field}}']"> {{$value}}　　
                                        @endforeach
                                    </div>
                                    <div class="col-xs-7" ng-if="!error.{{$field->Field}}">
                                        <span  class="label-msg">填写提示信息!</span>
                                    </div>
                                    <div class="col-xs-7 error-msg" ng-if="error.{{$field->Field}}">
                                        <span class="label-msg" ng-repeat="info in error.{{$field->Field}}">@@{{info}}</span>
                                    </div>
                                </div>
                            @elseif($field->showType=='select')
                                <div class="form-group row"  ng-init="errorFieldMap['{{$field->Field}}']='{{$field->info}}'">
                                    <div class="col-xs-2">
                                        <label class="pull-right">{{$field->info}}:</label>
                                    </div>
                                    <div class="col-xs-3">
                                        <select ng-model="row['{{$field->Field}}']">
                                            @foreach ($field->values as $key=>$value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xs-7" ng-if="!error.{{$field->Field}}">
                                        <span  class="label-msg">填写提示信息!</span>
                                    </div>
                                    <div class="col-xs-7 error-msg" ng-if="error.{{$field->Field}}">
                                        <span class="label-msg" ng-repeat="info in error.{{$field->Field}}">@@{{info}}</span>
                                    </div>
                                </div>
                            @elseif($field->showType=='textarea')
                                <div class="form-group row"  ng-init="errorFieldMap['{{$field->Field}}']='{{$field->info}}'">
                                    <div class="col-xs-2">
                                        <label class="pull-right">{{$field->info}}:</label>
                                    </div>
                                    <div class="col-xs-3">
                                        <textarea name="{{$field->Field}}" ng-model="row['{{$field->Field}}']" class="form-control">{{$tpl_start}}row['{{$field->Field}}']{{$tpl_end}}</textarea>
                                    </div>
                                    <div class="col-xs-7" ng-if="!error.{{$field->Field}}">
                                        <span  class="label-msg">填写提示信息!</span>
                                    </div>
                                    <div class="col-xs-7 error-msg" ng-if="error.{{$field->Field}}">
                                        <span class="label-msg" ng-repeat="info in error.{{$field->Field}}">@@{{info}}</span>
                                    </div>
                                </div>
                            @else
                                <div class="form-group row"  ng-init="errorFieldMap['{{$field->Field}}']='{{$field->info}}'">
                                    <div class="col-xs-2">
                                        <label class="pull-right">{{$field->info}}:</label>
                                    </div>
                                    <div class="col-xs-3">
                                        <input type="text" name="{{$field->Field}}" ng-model="row['{{$field->Field}}']" class="form-control">
                                    </div>
                                    <div class="col-xs-7" ng-if="!error.{{$field->Field}}">
                                        <span  class="label-msg">填写提示信息!</span>
                                    </div>
                                    <div class="col-xs-7 error-msg" ng-if="error.{{$field->Field}}">
                                        <span class="label-msg" ng-repeat="info in error.{{$field->Field}}">@@{{info}}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="form-group row">
                            <div class="col-xs-2">
                            </div>
                            <div class="col-xs-3">
                                <input name="id" value="@@{{row['id']}}" type="hidden">
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
@@stop



