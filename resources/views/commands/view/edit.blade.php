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
                                <form role="form">
                                    @foreach ($table_fields as $field)
                                        <div class="form-group row">
                                            <div class="col-xs-2">
                                                <label class="pull-right">{{$field->info}}:</label>
                                            </div>
                                            <div class="col-xs-3">
                                                <input type="text" name="{{$field->Field}}" ng-model="row.{{$field->Field}}" class="form-control">
                                            </div>
                                        </div>
                                    @endforeach
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


