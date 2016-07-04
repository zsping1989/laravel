define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    app.register.controller('admin-user-editCtrl', ["$scope",'$rootScope', 'Model','View','$alert','$http','$location','$timeout',
    function ($scope,$rootScope,Model,View,$alert,$http,$location,$timeout) {
        //重置
        $scope = View.with({'master':datas.row,'master_roles':datas.roles},$scope);
        $rootScope = View.with(datas.global,$rootScope);
        $scope.new_roles = [];
        $scope.reset = function() {
            $scope.row = angular.copy($scope.master);
            $scope.roles = angular.copy($scope.master_roles);
        };
        $scope.reset();

        //提交
        $scope.submit = function(){
            if($scope.row.id){
                var data = {};
                for (var i in $scope.row){
                    if(i=='uname'|| i=='email' || i=='mobile_phone'){
                        continue;
                    }
                    data[i] = $scope.row[i];
                }
            }else{
                var data = $scope.row;
            }
            if(!data.parent_id){
                delete data.parent_id;
            }
            data.new_roles = $scope.new_roles;
            $http({
                method: 'POST',
                url: $scope.data_url,
                data: data
            }).success(function(){
                $timeout(function(){
                    if($scope.row.id){
                        //$location.path($scope.back_url);
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


    }]);
})