define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    //alert(dataPath());
    var datas = datas || data;
    dump(datas);
    app.register.controller('admin-test-editCtrl', ["$scope",'$rootScope', 'Model','View','$alert','$http','$location','$timeout',
    function ($scope,$rootScope,Model,View,$alert,$http,$location,$timeout) {
        //重置
        $scope = View.with({'master':datas.row},$scope);
        $scope.reset = function() {
            $scope.row = angular.copy($scope.master);
        };
        $scope.reset();
        //提交
        $scope.submit = function(){
            $http({
                method: 'POST',
                url: $scope.data_url,
                data: $scope.row
            }).success(function(){
                $timeout(function(){
                    if($scope.row.id){
                        $location.path($scope.back_url);
                    }
                },1000)
            });
        }
        $rootScope.nav = datas.nav;
        $rootScope.route = datas.route;

    }]);
})