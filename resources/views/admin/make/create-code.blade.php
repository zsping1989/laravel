@extends('layouts.admin')
@section('title', '')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border" style="text-align: center">
                    <h1>欢迎使用代码生成工具</h1>
                </div>
                <div class="box-body">
                    <div class="row"  ng-controller="admin-create-codeCtrl">
                        <div class="col-md-12" bs-tabs>
                            <div data-title="原始代码创建" name="原始代码创建" bs-pane>
                                <div class="box-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th >创建命令</th>
                                            <th>中文名称</th>
                                            <th>参数</th>
                                            <th>操作</th>
                                            <th>描述</th>
                                        </tr>
                                        <tr>
                                            <td>make:migration</td>
                                            <td>创建迁移文件</td>
                                            <td ng-init="mi_type='--create';obj={'artisan':'make:migration'}">
                                                <input name="mi_name" ng-init="obj.name='create_tests_table'" ng-model="obj.name"  placeholder="请填写迁移文件名称">->文件名<br />
                                                <input name="mi_table"  ng-init="obj[mi_type]='tests'" ng-model="obj[mi_type]"  placeholder="数据表名">->数据表<br />
                                                <input type="radio" name="mi_type" ng-click="obj['--table']='';" value="--create" ng-model="mi_type">:新增
                                                <input type="radio" name="mi_type" ng-click="obj['--create']='';" value="--table" ng-model="mi_type">:修改  ->类型选择
                                            </td>
                                            <td><button ng-click="create(obj)">创建</button></td>
                                            <td>创建一个创建迁移文件</td>
                                        </tr>
                                        <tr>
                                            <td>convert:migration</td>
                                            <td>数据库表导出迁徙文件</td>
                                            <td>
                                                <input name="cm_name" ng-init="cm_name='tests'" ng-model="cm_name"  placeholder="请填写数据库表名称">->表名称<br />
                                            </td>
                                            <td><button ng-click="create({'artisan':'convert:migration','name':cm_name})">创建</button></td>
                                            <td>创建数据库已有数据表的迁徙文件</td>
                                        </tr>
                                        <tr>
                                            <td>make:seeder</td>
                                            <td>创建数据填充文件</td>
                                            <td>
                                                <input name="s_name" ng-init="s_name='TestTableSeeder'" ng-model="s_name"  placeholder="请填写填充文件名称">->文件名<br />
                                            </td>
                                            <td><button ng-click="create({'artisan':'make:seeder','name':s_name})">创建</button></td>
                                            <td>创建一个数据填充文件</td>
                                        </tr>
                                        <tr>
                                            <td>make:model</td>
                                            <td>创建模型</td>
                                            <td>
                                                <input name="m_name" ng-init="m_name='Models/Test'" ng-model="m_name"  placeholder="请填写模型名称">->模型
                                            </td>
                                            <td><button ng-click="create({'artisan':'make:model','name':m_name})">创建</button></td>
                                            <td>创建一个新的模型</td>
                                        </tr>
                                        <tr>
                                            <td>make:controller</td>
                                            <td>创建控制器</td>
                                            <td>
                                                <input name="c_name" ng-init="c_name='Admin/TestController'" ng-model="c_name"  placeholder="请填写控制器名称">->控制器
                                            </td>
                                            <td><button ng-click="create({'artisan':'make:controller','name':c_name})">创建</button></td>
                                            <td>创建一个新的控制器</td>
                                        </tr>
                                        <tr>
                                            <td>make:console</td>
                                            <td>创建artisan命令</td>
                                            <td>
                                                <input name="at_name" ng-init="at_name='Test'" ng-model="at_name"  placeholder="请填写命令名称">->文件名<br />
                                                <input name="command" ng-init="command='emails:send'" ng-model="command"  placeholder="请填写命令名称">->命令

                                            </td>
                                            <td><button ng-click="create({'artisan':'make:console','name':at_name,'--command':command})">创建</button></td>
                                            <td>创建一个artisan命令,创建完成后需要到app/Console/Kernel.php加入该类</td>
                                        </tr>
                                        <tr>
                                            <td>make:auth</td>
                                            <td>创建用户认证</td>
                                            <td>无</td>
                                            <td><button disabled>创建</button></td>
                                            <td>创建最基础的用户认证,包括认证相关路由,视图,数据表等</td>
                                        </tr>
                                    </table>
                                </div><!-- /.box-body -->
                            </div>
                            <div data-title="数据迁移与填充" name="数据迁移与填充" bs-pane>
                                <div>
                                    <div class="box-body">
                                        <table class="table table-hover table-bordered">
                                            <tr>
                                                <th>命令</th>
                                                <th>命令名称</th>
                                                <th>命令选项</th>
                                                <th>执行按钮</th>
                                                <th>命令说明</th>
                                            </tr>
                                            <tr>
                                                <td>migrate</td>
                                                <td>执行新增迁移文件</td>
                                                <td>
                                                    <input type="checkbox" name="force" value="1" ng-model="force" >:强制执行
                                                </td>
                                                <td><button ng-click="create({'artisan':'migrate','--force':force})">执行</button></td>
                                                <td>执行新增迁移文件</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    migrate:rollback<br />
                                                    migrate:reset<br />
                                                    migrate:refresh
                                                </td>
                                                <td>回滚迁移</td>
                                                <td ng-init="rol='rollback'">
                                                    <input type="radio" name="rol" value="rollback" ng-model="rol">->回滚到上一次迁移<br />
                                                    <input type="radio" name="rol" value="reset" ng-model="rol">->回滚所有迁移<br />
                                                    <input type="radio" name="rol" value="refresh" ng-model="rol">->回滚所有迁移并且再执行一次
                                                </td>
                                                <td><button ng-click="create({'artisan':'migrate:'+rol})">执行</button></td>
                                                <td>回滚迁移</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    db:seed
                                                </td>
                                                <td>数据填充</td>
                                                <td>
                                                    <input name="se_name" ng-init="se_name='TestTableSeeder'" ng-model="se_name"  placeholder="请填写填充seeder类名">->seeder类名
                                                </td>
                                                <td><button ng-click="create({'artisan':'db:seed','--class':se_name})">执行</button></td>
                                                <td>数据填充</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div data-title="自定义代码创建" name="自定义代码创建" bs-pane>
                                <div class="box-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th >创建命令</th>
                                            <th>中文名称</th>
                                            <th>参数</th>
                                            <th>操作</th>
                                            <th>描述</th>
                                        </tr>
                                        <tr>
                                            <td>create:controller</td>
                                            <td>创建控制器</td>
                                            <td>
                                                <input name="my_c_name" ng-init="my_c_name='Admin/TestController'" ng-model="my_c_name"  placeholder="请填写控制器名称">->控制器<br>
                                                            <span ng-show="my_c_type || my_c_verify">
                                                                <input name="my_c_model" ng-init="my_c_model=''" ng-model="my_c_model"  placeholder="请填写绑定模型">->模型<br>
                                                            </span>
                                                <input type="checkbox" value="--resource" ng-model="my_c_type">:是否为资源控制器<br>
                                                <input type="checkbox" value="--verify" ng-model="my_c_verify">:是否自动生成验证
                                            </td>
                                            <td><button ng-click="create({'artisan':'create:controller','name':my_c_name,'model':my_c_model,'--verify':my_c_verify,'--resource':my_c_type})">创建</button></td>
                                            <td>创建一个新的自定义控制器;下一步需要自己绑定路由</td>
                                        </tr>
                                        <tr>
                                            <td>create:model</td>
                                            <td>创建模型</td>
                                            <td>
                                                <input name="my_m_name" ng-init="my_m_name='Models/Test'" ng-model="my_m_name"  placeholder="请填写模型名称">->数据模型<br>
                                                <input name="my_m_table" ng-init="my_m_table='tests'" ng-model="my_m_table"  placeholder="请填写绑定模型的数据表">->表名<br>
                                                <input type="checkbox" value="--fields" ng-model="my_m_fields">:是否自动生成相关字段<br>
                                                <input type="checkbox" value="--softDeletes" ng-model="my_m_softDeletes">:是否启用软删除模式<br>
                                                <input type="checkbox" value="--tree" ng-model="my_m_tree">:是否启用树状结构模式
                                            </td>
                                            <td><button ng-click="create({
                                                        'artisan':'create:model',
                                                        'name':my_m_name,
                                                        'table':my_m_table,
                                                        '--fields':my_m_fields,
                                                        '--softDeletes':my_m_softDeletes,
                                                        '--tree':my_m_tree
                                                        })">创建</button></td>
                                            <td>创建一个新的自定义模型</td>
                                        </tr>
                                        <tr>
                                            <td>create:view</td>
                                            <td>创建视图</td>
                                            <td>
                                                <input name="my_v_name" ng-init="my_v_name='admin/test/index'" ng-model="my_v_name"  placeholder="请填写视图名称">->视图名称<br>
                                                <input type="text" ng-init="my_v_table='tests'"  ng-model="my_v_table">:填写绑定的数据表<br>
                                                <select ng-init="my_v_type='index'"  ng-model="my_v_type">
                                                    <option value="index">数据显示页面</option>
                                                    <option value="edit">数据编辑页面</option>
                                                </select>->模板类型选择
                                            </td>
                                            <td><button ng-click="create({
                                                        'artisan':'create:view',
                                                        'name':my_v_name,
                                                        'type':my_v_type,
                                                        'table':my_v_table
                                                        })">创建</button></td>
                                            <td>创建一个新的自定义模型</td>
                                        </tr>
                                        <tr>
                                            <td>create:js</td>
                                            <td>创建视图</td>
                                            <td>
                                                <input name="my_j_name" ng-init="my_j_name='admin/test/index'" ng-model="my_j_name"  placeholder="请填写视图名称">->js文件名称<br>
                                                <input type="text" ng-init="my_j_table='tests'"  ng-model="my_j_table">:填写绑定的数据表<br>
                                                <select ng-init="my_j_type='index'"  ng-model="my_j_type">
                                                    <option value="index">数据显示页面</option>
                                                    <option value="edit">数据编辑页面</option>
                                                </select>->模板类型选择
                                            </td>
                                            <td><button ng-click="create({
                                                        'artisan':'create:js',
                                                        'name':my_j_name,
                                                        'type':my_j_type,
                                                        'table':my_j_table
                                                        })">创建</button></td>
                                            <td>创建一个新的自定义模型</td>
                                        </tr>
                                    </table>
                                </div><!-- /.box-body -->
                            </div>
                            <div data-title="自定义说明文档" name="自定义说明文档" bs-pane>
                                <div>
                                    <div class="box-body">
                                        <table class="table table-hover table-bordered">
                                            <tr>
                                                <th>命令名称</th>
                                                <th>命令选项</th>
                                                <th>执行按钮</th>
                                                <th>命令说明</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            　当前执行命令:<code ng-if="artisan">php artisan @{{artisan}}</code>
                        </div>

                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
@stop



