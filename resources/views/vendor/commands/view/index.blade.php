@@extends('layouts.admin')
@@section('title', '')
@@section('content')
<div class="row" ng-controller="{{$tpl_controller}}" ng-init="data_url='/{{$dirname}}/list';delete_url='/{{$dirname}}/destroy'">
@if ($table)
    <div class="col-xs-12">
                <div class="box box-info" >
                    <div class="box-header with-border">
                        <h3 class="box-title">{{$table_comment}}列表</h3>
                        <div class="box-tools">
                            <div class="input-group">
                                <input type="text" ng-init="where[0].key='id';where[0].exp='like';where[0].val= where[0].val || '';"
                                       ng-model="where[0].val" placeholder="Search"
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
                                    <table class="table table-bordered table-hover dataTable">
                                        <tr role="row">
                                            <th class="sorting" style="width: 30px;">
                                                <input type="checkbox" value="1" name="selectAll"
                                                       ng-click="selectAllId($this,selectAll)"
                                                       ng-model="selectAll">
                                            </th>
                                            @foreach ($table_fields as $field)
                                                @if(in_array($field->showType,['hidden','textarea','editor','delete','password']))
                                                @else
                                                    <th class="sorting @if($field->showType=='time') visible-lg @endif">{{$field->info}}@if($field->showType=='time')
                                                            <i class="glyphicon glyphicon-time"></i> @endif
                                                        <span ng-click="getData($this,{'order':'{{$field->Field}}'})"
                                                              ng-class="{'glyphicon glyphicon-sort-by-attributes-alt':order.{{$field->Field}}=='desc','glyphicon glyphicon-sort-by-attributes':order.{{$field->Field}}!='desc'}"></span>
                                                    </th>
                                                @endif
                                            @endforeach
                                            <th class="sorting">操作</th>
                                        </tr>
                                        <tr ng-repeat="row in data" role="row">
                                            <td>
                                                <input type="checkbox" value="@@{{row['id']}}" name="ids[]" ng-model="ids[$index]"
                                                       ng-init="allIds[$index] = row['id']"
                                                       ng-true-value="@@{{row['id']}}" ng-checked="selectAll">
                                            </td>
                                            @foreach ($table_fields as $field)
                                                <?php $i = 0; ?>
                                                @if(in_array($field->showType,['hidden','textarea','editor','delete','password']) )
                                                @elseif($field->showType=='time')
                                                    <td class="visible-lg">{{$tpl_start}} row['{{$field->Field}}']{{$tpl_end}}</td>
                                                @elseif(in_array($field->showType,['select','radio']))
                                                    <td>
                                                        @foreach ($field->values as $key=>$value)
                                                            <span class="label label-{{$label_style[$i]}}" ng-if="row['{{$field->Field}}']=='{{$key}}'">{{$value}}</span>
                                                            <?php ++$i; ?>
                                                        @endforeach
                                                    </td>
                                                @elseif($field->showType=='checkbox')
                                                    <td>
                                                        @foreach ($field->values as $key=>$value)
                                                            <span class="label label-{{$label_style[$i]}}" ng-if="row['{{$field->Field}}']&{{$key}}">{{$value}}</span>
                                                            <?php ++$i; ?>
                                                        @endforeach
                                                    </td>
                                                @else
                                                    <td>{{$tpl_start}}row['{{$field->Field}}']{{$tpl_end}}</td>
                                                @endif
                                            @endforeach
                                            <td>
                                                <a class="btn btn-xs btn-info" title="编辑" role="button" href="/{{$dirname}}/edit/@@{{row['id']}}">
                                                    <i class="glyphicon glyphicon-edit"></i>
                                                </a>
                                                <button class="btn btn-xs btn-danger" title="删除" ng-click="delete($this,row['id'])" type="button">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            </td>
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
                                    <a class="btn btn-default btn-sm" title="添加" href="/{{$dirname}}/edit/0">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                                <div class="col-sm-7 ">
                                    <div class="pull-right">
                                        @@include('public.page')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endif
</div>
@@stop

