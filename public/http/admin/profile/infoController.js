define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    app.register.controller('admin-profile-infoCtrl', ["$scope",'$rootScope', 'Model','View','$alert','$http','$location','$timeout',
    function ($scope,$rootScope,Model,View,$alert,$http,$location,$timeout) {
        $rootScope = View.with(datas.global, $rootScope);
        $scope = View.withCache(datas, $scope);

        //重置备份数据
        $scope.master = angular.copy($scope.row);
        $scope.resetdata = function () {
            $scope.row = angular.copy($scope.master);
        };

        /* 条件查询数据 */
        $scope.getData = Model.getData;
        $scope.swicheditdata = function(){
            $scope.editdata =  !$scope.editdata;
        }

        //提交
        $scope.submit = function(){
            var data = $scope.row;
            if(!data.parent_id){
                delete data.parent_id;
            }
            $http({
                method: 'POST',
                url: $scope.edit_url,
                data: data
            }).success(function(){
                $scope.editdata = false;
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