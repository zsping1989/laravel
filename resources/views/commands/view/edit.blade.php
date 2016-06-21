<div class="skin-blue sidebar-mini" ng-class="{'sidebar-collapse':left_hidden}">
    <div class="wrapper">
        <div ng-include="'/http/admin/public/header.html'"></div>
        <div ng-include="'/http/admin/public/left.html'"></div>
        <div style="min-height: 715px;" class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div ng-include="'/http/admin/public/nav.html'"></div>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary" ng-controller="{{$tpl_controller}}">
                            <div class="box-header">
                                <h3 class="box-title" ng-if="row.id">修改{{$table_comment}}</h3>
                                <h3 class="box-title" ng-if="!row.id">新增{{$table_comment}}</h3>
                            </div>
                            <div class="box-body">
                                <form role="form"  action="/{{$dirname}}/edit" method="post" ng-init="data_url='/{{$dirname}}/edit';back_url='/{{$dirname}}/index'">
                                    @foreach ($table_fields as $field)
                                        @if(in_array($field->showType,['hidden','delete']) ||in_array($field->Field,['updated_at','id','created_at','deleted_at']) )
                                        @elseif($field->showType=='time')
                                            <div class="form-group row" ng-class="{'has-error': datepickerForm.{{$field->Field}}.$invalid}">
                                                <div class="col-xs-2">
                                                    <label class="pull-right">{{$field->info}}:</label>
                                                </div>
                                                <div class="col-xs-3">
                                                    <input ng-model="row.{{$field->Field}}" name="{{$field->Field}}" class="form-control" data-date-format="yyyy-MM-dd" data-date-type="number" data-min-date="" data-max-date="today" data-autoclose="1"  bs-datepicker type="text">
                                                </div>
                                            </div>
                                        @elseif($field->showType=='radio')
                                            <div class="form-group row">
                                                <div class="col-xs-2">
                                                    <label class="pull-right">{{$field->info}}:</label>
                                                </div>
                                                <div class="col-xs-3">
                                                    @foreach ($field->values as $key=>$value)
                                                    <input type="radio" name="{{$field->Field}}" value="{{$key}}" ng-model="row.{{$field->Field}}"> {{$value}}　　
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif($field->showType=='checkbox')
                                            <div class="form-group row">
                                                <div class="col-xs-2">
                                                    <label class="pull-right">{{$field->info}}:</label>
                                                </div>
                                                <div class="col-xs-3" ng-init="row.{{$field->Field}}=binaryToArray(row.{{$field->Field}})">
                                                    @foreach ($field->values as $key=>$value)
                                                        <input type="checkbox" name="{{$field->Field}}" value="{{$key}}" ng-model="row.{{$field->Field}}"> {{$value}}　　
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif($field->showType=='select')
                                            <div class="form-group row">
                                                <div class="col-xs-2">
                                                    <label class="pull-right">{{$field->info}}:</label>
                                                </div>
                                                <div class="col-xs-3">
                                                    <select ng-model="row.{{$field->Field}}">
                                                        @foreach ($field->values as $key=>$value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @elseif($field->showType=='textarea')
                                            <div class="form-group row">
                                                <div class="col-xs-2">
                                                    <label class="pull-right">{{$field->info}}:</label>
                                                </div>
                                                <div class="col-xs-3">
                                                    <textarea name="{{$field->Field}}" ng-model="row.{{$field->Field}}" class="form-control">{{$tpl_start}}row.{{$field->Field}}{{$tpl_end}}</textarea>
                                                </div>
                                            </div>
                                        @else
                                        <div class="form-group row">
                                            <div class="col-xs-2">
                                                <label class="pull-right">{{$field->info}}:</label>
                                            </div>
                                            <div class="col-xs-3">
                                                <input type="text" name="{{$field->Field}}" ng-model="row.{{$field->Field}}" class="form-control">
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
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
                                                <button class="btn" type="button" ng-click="reset()">
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
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <div ng-include="'/http/admin/public/right.html'"></div>
    </div>
</div>


