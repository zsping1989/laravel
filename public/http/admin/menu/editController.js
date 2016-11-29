app.controller('admin-menu-editCtrl', ["$scope",'$rootScope', 'Model','View'
        ,'$http','$modal',
    function ($scope,$rootScope,Model,View,$http,$modal) {
        dump(datas);
        datas.row = (!datas.row || (typeof datas.row.length=='number' && !datas.row.length)) ? {} : datas.row;
        $rootScope = View.with(datas.global, $rootScope);
        $scope = View.with(datas, $scope);
        $scope.errorFieldMap = {};
        /* 条件查询数据 */
        $scope.getData = Model.getData;

        //重置备份数据
        $scope.master = angular.copy($scope.row);
        $scope.resetdata = function () {
            $scope.row = angular.copy($scope.master);
        };

        //删除参数
        $scope.deleteParam = function(index){
            var data = [];
            for (var i in $scope.row.params){
                if(i==index){
                    continue;
                }
                data[data.length] = $scope.row.params[i];
            }
            $scope.row.params = data;
        }

        //弹窗参数编辑
        $scope.editParam = function(index){
            $scope.param_index = typeof index == 'undefined' ? $scope.row.params.length : index;
            $modal({scope: $scope,
                template: '/http/admin/menu/edit-param.html',
                placement:'center',
                show: true});
        }

        //删除响应说明
        $scope.deleteResponse = function(index){
            var data = [];
            for (var i in $scope.row.responses){
                if(i==index){
                    continue;
                }
                data[data.length] = $scope.row.responses[i];
            }
            $scope.row.responses = data;
        }

        //弹窗响应说明编辑
        $scope.editResponse = function(index){
            $scope.response_index = typeof index == 'undefined' ? $scope.row.responses.length : index;
            $modal({scope: $scope,
                template: '/http/admin/menu/edit-response.html',
                placement:'center',
                show: true});
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
