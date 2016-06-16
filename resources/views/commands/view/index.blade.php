<div class="skin-blue sidebar-mini" ng-class="{'sidebar-collapse':left_hidden}">
    <div class="wrapper">
        <div ng-include="'/http/admin/public/header.html'"></div>
        <div ng-include="'/http/admin/public/left.html'"></div>
        <div style="min-height: 916px;" class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div ng-include="'/http/admin/public/nav.html'"></div>

            <!-- Main content -->
            <section class="content">
@if ($table)
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-info" ng-controller="{{$tpl_controller}}"  ng-init="data_url='/{{$dirname}}/list';delete_url='/{{$dirname}}/destroy'">
                            <div class="box-header with-border">
                                <h3 class="box-title">Latest Orders</h3>
                                <div class="box-tools">
                                    <div class="input-group">
                                        <input type="text" ng-init="where.id.exp='like';where.id.val='';" ng-model="where.id.val" placeholder="Search" class="form-control input-sm pull-right">
                                        <div class="input-group-btn">
                                            <button ng-init="reset=0" ng-click="getData($this)" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                                            <button type="button" ng-click="getData($this,{reset:1})" class="btn btn-sm btn-default"><i class="fa  fa-repeat"></i></button>
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
                                            <table  class="table table-bordered table-hover dataTable">
                                                <tr role="row">
                                                    <th class="sorting" style="width: 30px;">
                                                        <input type="checkbox" value="1" name="selectAll"  ng-click="selectAllId($this,selectAll)" ng-model="selectAll">
                                                    </th>
@foreach ($table_fields as $field)
@if($field->showType!='hidden')
                                                    <th class="sorting @if($field->showType=='time') visible-lg @endif">{{$field->info}}@if($field->showType=='time')<i class="glyphicon glyphicon-time"></i> @endif
                                                            <span ng-click="getData($this,{'order':'{{$field->Field}}'})"  ng-class="{'glyphicon glyphicon-sort-by-attributes-alt':order.{{$field->Field}}=='desc','glyphicon glyphicon-sort-by-attributes':order.{{$field->Field}}!='desc'}"></span>
                                                        </th>
@endif
@endforeach
                                                    <th class="sorting">操作</th>
                                                </tr>
                                                <tr ng-repeat="row in data" role="row">
                                                    <td><input type="checkbox" value="@{{row.id}}" name="ids[]" ng-model="ids[$index]" ng-init="allIds[$index] = row.id" ng-true-value="@{{row.id}}" ng-checked="selectAll"></td>
@foreach ($table_fields as $field)
@if($field->showType=='hidden')
@elseif($field->showType=='time')
                                                            <td class="visible-lg">{{$tpl_start}}row.{{$field->Field}}{{$tpl_end}}</td>
@elseif($field->values)
                                                            <td>
@foreach ($field->values as $key=>$value)
                                                                    <span class="label label-primary" ng-if="row.{{$field->Field}}=={{$key}}">{{$value}}</span>
@endforeach
                                                            </td>
@else
                                                            <td>{{$tpl_start}}row.{{$field->Field}}{{$tpl_end}}</td>
@endif
@endforeach
                                                    <td>
                                                        <a class="btn btn-xs btn-info" title="编辑" role="button" href=""><i class="glyphicon glyphicon-edit"></i></a>
                                                        <button class="btn btn-xs btn-danger" title="删除" ng-click="delete($this,row.id)" type="button"><i class="glyphicon glyphicon-trash"></i></button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <button class="btn btn-default btn-sm" title="删除选中" ng-click="delete($this)"><i class="fa fa-trash-o"></i></button>
                                            <button class="btn btn-default btn-sm" title="刷新" ng-click="getData($this,{refresh:1})"><i class="fa fa-refresh"></i></button>
                                        </div>
                                        <div class="col-sm-7 ">
                                            <div ng-include="'/http/admin/public/page.html'" class="pull-right"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
@endif
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <div ng-include="'/http/admin/public/right.html'"></div>
    </div>
</div>
