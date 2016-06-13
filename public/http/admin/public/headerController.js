/**
 * Created by zhangshiping on 16-5-12.
 *
 * 头部公共部分模板
 */
define(['app'],function(app){
    app.register.controller('admin-headerCtrl',["$scope",'$rootScope', 'View','$alert',function($scope,$rootScope,View,$alert){
        window.$alert = $alert; //存放全局弹窗变量
        $scope = View.with(data.user,$scope);
        $scope.hiddenLeft = function(){
            $rootScope.left_hidden = !$rootScope.left_hidden;
        }
    }])
})

