/**
 * Created by zhangshiping on 16-5-13.
 */
//dataPath(),数据源地址
define(['app',dataPath()],function(app,datas){
    app.register.controller('home-loginCtrl',["$scope",'$http',function($scope,$http){
        $scope.data_key = '/home/login';
        updateData('/home/login');
        $scope.login = function(){
            $http.post('/data/home/auth/login',{
                username:$scope.username,
                password:$scope.password,
                _token:datas._token
            }).success(function(res){
                //登录成功跳转
                window.location.href = res.redirect || '/admin/index';
            }).error(function(res){
                //登录失败,显示提示信息
                $scope.msgs = res;
            });
        }
    }])

})
