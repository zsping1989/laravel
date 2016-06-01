/**
 * Created by zhangshiping on 16-5-23.
 */
define(['app'],function(app){
    //用户信息
    app.register.controller('admin-left-userCtrl',["$scope", '$rootScope','View',function($scope,$rootScope,View){
        $scope = View.with(data.user,$scope);
    }])

    //菜单目录
    app.register.controller('admin-left-menuCtrl',["$scope", '$rootScope','View',function($scope,$rootScope,View){
        var datas = {
            menus : data.menus
        }
        $scope = View.with(datas,$scope);
    }])
})
