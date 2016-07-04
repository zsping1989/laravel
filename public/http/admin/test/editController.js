define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
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
            var data = $scope.row;
            if(!data.parent_id){
                delete data.parent_id;
            }
            $http({
                method: 'POST',
                url: $scope.data_url,
                data: data
            }).success(function(){
                $timeout(function(){
                    if($scope.row.id){
                        $location.path($scope.back_url);
                    }
                },1000)
            }).error(function(data){
                if(typeof data == "object"){
                    for(var i in data){
                        for(var j in data[i]){
                            data[i][j] = data[i][j].replace(i.replace('_',' ')+' ',$scope.errorFieldMap[i]);
                        }
                    }
                    $scope.error = data;
                }
            });
        }
        $rootScope = View.with(datas.global,$rootScope);

    }]);
})