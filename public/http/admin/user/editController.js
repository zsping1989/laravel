app.controller('admin-user-editCtrl', ["$scope",'$rootScope', 'Model','View','$http','$alert',
    function ($scope,$rootScope,Model,View,$http,$alert) {
        dump(datas);
        datas.row = (!datas.row || (typeof datas.row.length=='number' && !datas.row.length)) ? {} : datas.row;
        $rootScope = View.with(datas.global, $rootScope);
        $scope = View.with(datas, $scope);
        $scope.errorFieldMap = {};
        //重置备份数据
        $scope.master = angular.copy($scope.row);
        $scope.master_roles = angular.copy($scope.roles);
        $scope.resetdata = function () {
            $scope.row = angular.copy($scope.master);
            $scope.roles = angular.copy($scope.master_roles);
        };

        /* 条件查询数据 */
        $scope.getData = Model.getData;
        $scope.new_roles = [];
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
