    app.controller('admin-profile-passwordCtrl',
        ["$scope",'$rootScope', 'Model','View','$http',
    function ($scope,$rootScope,Model,View,$http) {
        dump(datas);
        $rootScope = View.with(datas.global, $rootScope);
        $scope = View.with(datas, $scope);
        $scope.errorFieldMap = {};

        //重置备份数据
        $scope.master = angular.copy($scope.row);
        $scope.resetdata = function () {
            $scope.row = angular.copy($scope.master);
        };

        /* 条件查询数据 */
        $scope.getData = Model.getData;

        //提交
        $scope.submit = function(){
            var data = $scope.row;
            $http({
                method: 'POST',
                url: $scope.edit_url,
                data: data
            }).success(function(){

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
