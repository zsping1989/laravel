<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //初始化数据表
        DB::table('menus')->truncate(); //菜单权限表

        //创建权限数据
        //顶级菜单 ID:1
        factory(\App\Models\Menu::class)->create([
            'name'=>'菜单列表',
            'url'=>'',
            'status'=>2,
            'description' => '根节点,所有菜单的父节点'
        ]);

        //ID:2
        factory(\App\Models\Menu::class)->create([
            'name'=>'控制面板',
            'prefix'=>'#',
            'icons'=>'fa-dashboard',
            'url'=>'/admin/index/index',
            'description' => '',
            'parent_id'=>1,
            'status'=>1
        ]);

        //ID:3
        factory(\App\Models\Menu::class)->create([
            'name'=>'开发工具',
            'icons'=>'fa-circle-o',
            'prefix'=>'#',
            'url'=>'/admin/make/create-code',
            'description' => '开发模块',
            'parent_id'=>1,
            'status'=>1
        ]);

        //ID:4
        factory(\App\Models\Menu::class)->create([
            'name'=>'前端模块',
            'icons'=>'fa-wrench',
            'prefix'=>'#',
            'url'=>'/home/index',
            'description' => '前端所有路由',
            'parent_id'=>1,
            'status'=>2
        ]);
        //ID:5
        factory(\App\Models\Menu::class)->create([
            'name'=>'用户管理',
            'icons'=>'fa-users',
            'prefix'=>'#',
            'url'=>'/admin/role/index',
            'description' => '用户模块',
            'parent_id'=>1,
            'status'=>1
        ]);
        //ID:6
        factory(\App\Models\Menu::class)->create([
            'name'=>'个人中心',
            'icons'=>'fa-heart',
            'prefix'=>'#',
            'url'=>'/admin/profile/info',
            'description' => '个人资料',
            'parent_id'=>1,
            'status'=>1
        ]);
        //ID:7
        factory(\App\Models\Menu::class)->create([
            'name'=>'其它板块',
            'prefix'=>'#',
            'icons'=>'fa-wrench',
            'url'=>'/admin/area/index',
            'description' => '',
            'parent_id'=>1,
            'status'=>1
        ]);
        //ID:8
        factory(\App\Models\Menu::class)->create([
            'name'=>'创建代码',
            'icons'=>'fa-mouse-pointer',
            'prefix'=>'',
            'url'=>'',
            'description' => '创建代码',
            'parent_id'=>3,
            'status'=>1
        ]);
        //ID:9
        factory(\App\Models\Menu::class)->create([
            'name'=>'接口文档',
            'icons'=>'fa-asterisk',
            'prefix'=>'',
            'url'=>'',
            'description' => '接口说明',
            'parent_id'=>3,
            'status'=>1
        ]);
        //ID:10
        factory(\App\Models\Menu::class)->create([
            'name'=>'登录页面',
            'icons'=>'',
            'url'=>'/home/auth/login',
            'description' => '',
            'method'=>2,
            'parent_id'=>4,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:11
        factory(\App\Models\Menu::class)->create([
            'name'=>'退出登录',
            'icons'=>'',
            'prefix'=>'',
            'url'=>'/home/auth/logout',
            'description' => '',
            'parent_id'=>4,
            'status'=>1
        ]);
        //ID:12
        factory(\App\Models\Menu::class)->create([
            'name'=>'后台主页',
            'icons'=>'fa-home',
            'prefix'=>'#',
            'url'=>'/admin/index/index',
            'description' => '后台首页',
            'parent_id'=>2,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:13
        factory(\App\Models\Menu::class)->create([
            'name'=>'菜单管理',
            'icons'=>'fa-th',
            'prefix'=>'',
            'url'=>'',
            'description' => '菜单管理',
            'parent_id'=>3,
            'status'=>1
        ]);

        //ID:14
        factory(\App\Models\Menu::class)->create([
            'name'=>'菜单列表',
            'icons'=>'fa-list',
            'prefix'=>'#',
            'url'=>'/admin/menu/index',
            'description' => '列表详细',
            'is_page'=>1,
            'parent_id'=>13,
            'status'=>1
        ]);

        //ID:15
        factory(\App\Models\Menu::class)->create([
            'name'=>'编辑菜单',
            'icons'=>'fa-edit',
            'prefix'=>'#',
            'url'=>'/admin/menu/edit',
            'method'=>1,
            'description' => '修改或添加数据',
            'parent_id'=>14,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:16
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除菜单',
            'icons'=>'',
            'prefix'=>'',
            'url'=>'/admin/menu/destroy',
            'method'=>2,
            'description' => '删除菜单',
            'parent_id'=>13,
            'status'=>2
        ]);

        //ID:17
        factory(\App\Models\Menu::class)->create([
            'name'=>'菜单置顶',
            'icons'=>'',
            'prefix'=>'',
            'url'=>'/admin/menu/move-top',
            'description' => '移动菜单节点位置',
            'method'=>2,
            'parent_id'=>13,
            'status'=>2
        ]);

        //ID:18
        factory(\App\Models\Menu::class)->create([
            'name'=>'区域管理',
            'icons'=>'fa-area-chart',
            'prefix'=>'',
            'url'=>'',
            'description' => '城市地区管理',
            'parent_id'=>7,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:19
        factory(\App\Models\Menu::class)->create([
            'name'=>'区域列表',
            'icons'=>'fa-list',
            'prefix'=>'#',
            'url'=>'/admin/area/index',
            'description' => '列表详细',
            'is_page'=>1,
            'parent_id'=>18,
            'status'=>1
        ]);

        //ID:20
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除区域',
            'icons'=>'',
            'prefix'=>'',
            'url'=>'/admin/area/destroy',
            'method'=>2,
            'description' => '删除区域',
            'parent_id'=>18,
            'status'=>2
        ]);

        //ID:21
        factory(\App\Models\Menu::class)->create([
            'name'=>'编辑区域',
            'icons'=>'fa-edit',
            'prefix'=>'#',
            'url'=>'/admin/area/edit',
            'method'=>2,
            'description' => '添加或编辑区域',
            'parent_id'=>19,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:22
        factory(\App\Models\Menu::class)->create([
            'name'=>'权限管理',
            'icons'=>'fa-group',
            'prefix'=>'',
            'url'=>'',
            'method'=>1,
            'description' => '角色的权限管理',
            'parent_id'=>5,
            'status'=>1
        ]);

        //ID:23
        factory(\App\Models\Menu::class)->create([
            'name'=>'角色列表',
            'icons'=>'fa-list',
            'prefix'=>'#',
            'url'=>'/admin/role/index',
            'method'=>1,
            'description' => '列表详情',
            'is_page'=>1,
            'parent_id'=>22,
            'status'=>1
        ]);

        //ID:24
        factory(\App\Models\Menu::class)->create([
            'name'=>'角色编辑',
            'icons'=>'fa-edit',
            'prefix'=>'#',
            'url'=>'/admin/role/edit',
            'method'=>2,
            'description' => '添加或编辑角色',
            'parent_id'=>23,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:25
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除角色',
            'icons'=>'',
            'prefix'=>'',
            'url'=>'/admin/role/destroy',
            'method'=>2,
            'description' => '删除角色',
            'parent_id'=>22,
            'status'=>2
        ]);

        //ID:26
        factory(\App\Models\Menu::class)->create([
            'name'=>'用户管理',
            'icons'=>'fa-user',
            'prefix'=>'',
            'url'=>'',
            'method'=>1,
            'description' => '用户管理',
            'parent_id'=>5,
            'status'=>1
        ]);

        //ID:27
        factory(\App\Models\Menu::class)->create([
            'name'=>'用户列表',
            'icons'=>'fa-list',
            'prefix'=>'#',
            'url'=>'/admin/user/index',
            'method'=>1,
            'description' => '用户管理',
            'is_page'=>1,
            'parent_id'=>26,
            'status'=>1
        ]);

        //ID:28
        factory(\App\Models\Menu::class)->create([
            'name'=>'编辑用户',
            'icons'=>'fa-edit',
            'prefix'=>'#',
            'url'=>'/admin/user/edit',
            'method'=>2,
            'description' => '添加或编辑用户',
            'parent_id'=>27,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:29
        factory(\App\Models\Menu::class)->create([
            'name'=>'删除用户',
            'icons'=>'',
            'prefix'=>'',
            'url'=>'/admin/user/destroy',
            'method'=>2,
            'description' => '删除用户',
            'parent_id'=>26,
            'status'=>2
        ]);

        //ID:30
        factory(\App\Models\Menu::class)->create([
            'name'=>'个人资料',
            'icons'=>'fa-database',
            'prefix'=>'',
            'url'=>'',
            'method'=>1,
            'description' => '个人资料修改',
            'parent_id'=>6,
            'status'=>1
        ]);

        //ID:31
        factory(\App\Models\Menu::class)->create([
            'name'=>'修改资料',
            'icons'=>'fa-database',
            'prefix'=>'#',
            'url'=>'/admin/profile/info',
            'method'=>1,
            'description' => '个人资料修改',
            'parent_id'=>30,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:32
        factory(\App\Models\Menu::class)->create([
            'name'=>'消息中心',
            'icons'=>'fa-bell-o',
            'prefix'=>'#',
            'url'=>'/admin/profile/message',
            'method'=>1,
            'description' => '个人资料修改',
            'parent_id'=>6,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:33
        factory(\App\Models\Menu::class)->create([
            'name'=>'执行创建',
            'icons'=>'',
            'prefix'=>'#',
            'url'=>'/admin/make/exe',
            'method'=>2,
            'description' => '执行console命令',
            'parent_id'=>8,
            'status'=>2
        ]);

        //ID:34
        factory(\App\Models\Menu::class)->create([
            'name'=>'接口列表',
            'icons'=>'',
            'prefix'=>'#',
            'url'=>'/admin/api',
            'method'=>1,
            'description' => '',
            'parent_id'=>9,
            'is_page'=>1,
            'status'=>2
        ]);

        //ID:35
        factory(\App\Models\Menu::class)->create([
            'name'=>'菜单列表',
            'icons'=>'',
            'prefix'=>'#',
            'url'=>'/admin/menu/list',
            'method'=>1,
            'description' => '',
            'parent_id'=>13,
            'status'=>2
        ]);

        //ID:36
        factory(\App\Models\Menu::class)->create([
            'name'=>'区域列表',
            'icons'=>'fa-edit',
            'prefix'=>'#',
            'url'=>'/admin/area/list',
            'method'=>2,
            'description' => '',
            'parent_id'=>18,
            'status'=>2
        ]);

        //ID:37
        factory(\App\Models\Menu::class)->create([
            'name'=>'角色列表',
            'icons'=>'fa-edit',
            'prefix'=>'#',
            'url'=>'/admin/role/list',
            'method'=>2,
            'description' => '',
            'parent_id'=>22,
            'status'=>2
        ]);

        //ID:38
        factory(\App\Models\Menu::class)->create([
            'name'=>'用户列表',
            'icons'=>'fa-edit',
            'prefix'=>'#',
            'url'=>'/admin/user/list',
            'method'=>2,
            'description' => '',
            'parent_id'=>26,
            'status'=>2
        ]);

        //ID:39
        factory(\App\Models\Menu::class)->create([
            'name'=>'角色用户',
            'icons'=>'fa-edit',
            'prefix'=>'#',
            'url'=>'/admin/role/user-list',
            'method'=>1,
            'description' => '',
            'parent_id'=>22,
            'status'=>2
        ]);

        //ID:40
        factory(\App\Models\Menu::class)->create([
            'name'=>'组织架构',
            'icons'=>'fa-cubes',
            'prefix'=>'#',
            'url'=>'/admin/user/framework',
            'method'=>1,
            'description' => '',
            'is_page'=>1,
            'parent_id'=>22,
            'status'=>1
        ]);

        //ID:41
        factory(\App\Models\Menu::class)->create([
            'name'=>'404页面',
            'icons'=>'fa-exclamation-triangle',
            'prefix'=>'#',
            'url'=>'/admin/index/page404',
            'is_page' => '1',
            'method'=>1,
            'description' => '',
            'parent_id'=>7,
            'status'=>2
        ]);

        //ID:42
        factory(\App\Models\Menu::class)->create([
            'name'=>'500页面',
            'icons'=>'fa-exclamation-triangle',
            'prefix'=>'#',
            'url'=>'/admin/index/page500',
            'method'=>1,
            'description' => '',
            'is_page' => '1',
            'parent_id'=>7,
            'status'=>2
        ]);

        //ID:43
        factory(\App\Models\Menu::class)->create([
            'name'=>'404页面',
            'icons'=>'',
            'prefix'=>'#',
            'is_page' => '1',
            'url'=>'/home/page404',
            'description' => '前端404页面',
            'parent_id'=>4,
            'status'=>2
        ]);

        //ID:44
        factory(\App\Models\Menu::class)->create([
            'name'=>'500页面',
            'icons'=>'',
            'prefix'=>'#',
            'is_page' => '1',
            'url'=>'/home/page500',
            'description' => '前端500页面',
            'parent_id'=>4,
            'status'=>2
        ]);

        //ID:45
        factory(\App\Models\Menu::class)->create([
            'name'=>'前端主页',
            'icons'=>'',
            'prefix'=>'#',
            'is_page' => '1',
            'url'=>'/home/index',
            'description' => '前端主页',
            'parent_id'=>4,
            'status'=>1
        ]);

        //ID:46
        factory(\App\Models\Menu::class)->create([
            'name'=>'捐赠页面',
            'icons'=>'',
            'prefix'=>'#',
            'is_page' => '1',
            'url'=>'/home/doc/donate',
            'description' => '前端捐赠页面',
            'parent_id'=>4,
            'status'=>1
        ]);

        //ID:47
        factory(\App\Models\Menu::class)->create([
            'name'=>'安装说明',
            'icons'=>'',
            'prefix'=>'#',
            'is_page' => '1',
            'url'=>'/home/doc/install',
            'description' => '前端安装说明页面',
            'parent_id'=>4,
            'status'=>1
        ]);

        //ID:48
        factory(\App\Models\Menu::class)->create([
            'name'=>'创建页面',
            'icons'=>'fa-chrome',
            'prefix'=>'#',
            'url'=>'/admin/make/create-code',
            'is_page'=>1,
            'description' => '创建页面',
            'parent_id'=>8,
            'status'=>1
        ]);

        //ID:49
        factory(\App\Models\Menu::class)->create([
            'name'=>'接口页面',
            'icons'=>'fa-clone',
            'prefix'=>'#',
            'url'=>'/admin/exploit/api',
            'description' => '接口说明',
            'parent_id'=>9,
            'is_page'=>1,
            'status'=>1
        ]);
        //ID:50
        factory(\App\Models\Menu::class)->create([
            'name'=>'密码修改',
            'icons'=>'fa-lock',
            'prefix'=>'#',
            'url'=>'/admin/profile/password',
            'method'=>1,
            'description' => '个人资料修改',
            'parent_id'=>30,
            'is_page'=>1,
            'status'=>1
        ]);

        //ID:51
        factory(\App\Models\Menu::class)->create([
            'name'=>'图表事列',
            'icons'=>'fa-bar-chart',
            'prefix'=>'',
            'url'=>'',
            'description' => '图表事列',
            'parent_id'=>2,
            'status'=>1
        ]);

        //ID:52
        factory(\App\Models\Menu::class)->create([
            'name'=>'折线图表',
            'icons'=>'fa-line-chart',
            'prefix'=>'#',
            'url'=>'/admin/chart/line-chart',
            'description' => '折线图',
            'is_page'=>1,
            'parent_id'=>51,
            'status'=>1
        ]);

        //ID:53
        factory(\App\Models\Menu::class)->create([
            'name'=>'柱状图表',
            'icons'=>'fa-bar-chart',
            'prefix'=>'#',
            'url'=>'/admin/chart/bar-chart',
            'description' => '柱状图',
            'is_page'=>1,
            'parent_id'=>51,
            'status'=>1
        ]);

        //ID:54
        factory(\App\Models\Menu::class)->create([
            'name'=>'中国地图',
            'icons'=>'fa-area-chart',
            'prefix'=>'#',
            'url'=>'/admin/chart/china-chart',
            'description' => '柱状图',
            'is_page'=>1,
            'parent_id'=>51,
            'status'=>1
        ]);


        //新建假数据3条
        //factory(\App\Models\Menu::class,3)->create();
    }
}
