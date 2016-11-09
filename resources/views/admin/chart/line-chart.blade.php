@extends('layouts.admin')
@section('title', '')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                    <div class="box-tools">
                    </div>
                </div>
                <div class="box-body" ng-controller="admin-chart-line-chartCtrl">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <div id="main1" style="width: 100%;height: 500px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop