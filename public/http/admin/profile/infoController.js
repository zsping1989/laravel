app.controller('admin-profile-infoCtrl', ["$scope",'$rootScope', 'Model','View','$http',
    function ($scope,$rootScope,Model,View,$http) {
        $rootScope = View.with(datas.global, $rootScope);
        $scope = View.with(datas, $scope);
        $scope.errorFieldMap = {};
        //重置备份数据
        $scope.master = angular.copy($scope.row);
        $scope.resetdata = function () {
            if(!$scope.editdata){
                return false;
            }
            $scope.row = angular.copy($scope.master);
        };

        /* 条件查询数据 */
        $scope.getData = Model.getData;
        $scope.swicheditdata = function(){
            $scope.editdata =  !$scope.editdata;
        }

        //提交
        $scope.submit = function(){
            var data = {};
            for (var i in $scope.row){
                if(i=='mobile_phone' && $scope.row.mobile_phone==$scope.master.mobile_phone){
                    continue;
                }
                data[i] = $scope.row[i];
            }
            $http({
                method: 'POST',
                url: $scope.edit_url,
                data: data
            }).success(function(){
                $scope.error = {};
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