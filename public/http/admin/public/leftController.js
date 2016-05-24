/**
 * Created by zhangshiping on 16-5-23.
 */
define(['app'],function(app){
    app.register.controller('admin-headerCtrl',["$scope", '$rootScope','View',function($scope,$rootScope,View){
        var datas = {
            menus : data.menus,
            user : data.user
        }
        $scope = View.with(datas,$scope);

    }])
})
