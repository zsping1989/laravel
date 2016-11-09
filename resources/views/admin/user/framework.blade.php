@extends('layouts.admin')
@section('title', '')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info"  ng-controller="admin-user-frameworkCtrl" ng-init="data_url='/admin/user/framework'">
                <div class="box-header with-border">
                    <h3 class="box-title">后台组织架构图</h3>
                    <div class="box-tools">
                        <button class="btn btn-default btn-sm" title="刷新"
                                ng-click="getData($this,{refresh:1})">
                            <i class="fa fa-refresh"></i>
                        </button>
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
                            <div class="paper col-sm-12">
                                <div id="paper" style="overflow: auto;width: 100%;" class="container" ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
@stop