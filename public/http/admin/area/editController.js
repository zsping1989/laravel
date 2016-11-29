app.controller('admin-area-editCtrl', ["$scope",'$rootScope', 'Model','View','$http',
    function ($scope,$rootScope,Model,View,$http) {
        dump(datas);
        datas.row = (!datas.row || (typeof datas.row.length=='number' && !datas.row.length)) ? {} : datas.row;
        $rootScope = View.with(datas.global, $rootScope);
        $scope = View.with(datas, $scope);
        /* 条件查询数据 */
        $scope.getData = Model.getData;
        $scope.errorFieldMap = {};
        //重置备份数据
        $scope.master = angular.copy($scope.row);
        $scope.resetdata = function () {
            $scope.row = angular.copy($scope.master);
        };
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
                $scope.error = {};
                window.setTimeout(function(){
                    if($scope.row.id){
                        window.location.href = $scope.back_url;
                    }
                },1000);
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
