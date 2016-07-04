define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    app.register.controller('admin-role-editCtrl', ["$scope",'$rootScope', 'Model','View','$alert','$http','$location','$timeout',
    function ($scope,$rootScope,Model,View,$alert,$http,$location,$timeout) {
        dump(datas);
        $rootScope = View.with(datas.global,$rootScope);
        //数据缓存,用于方便更新数据
        var route = parseURL('hash');
        //动态路由需要重新获取数据
        if(route!=datas.route && !window.cacheData[route]){
            $http({
                method: 'GET',
                url: route,
                async: false
            }).success(function(data){
                window.cacheData[route] = {'master':data.row,
                    'permissions':data.permissions,
                    canEdit:data.canEdit,
                    users:data.users
                };
                init();
            })
        }else {
            init();
        }
        function init(){
            var maindata = window.cacheData[route] || {'master':datas.row, users:datas.users,'permissions':datas.permissions,canEdit:datas.canEdit};
            window.cacheData[route] = maindata;
            $scope.data_key = route;

            //重置
            $scope = View.with(maindata,$scope);
            $scope.reset = function() {
                $scope.row = angular.copy($scope.master);
            };
            $scope.reset();

            //提交
            $scope.submit = function(){
                if(!$scope.canEdit){
                    $alert({
                        'title':'警告',
                        'content':'你没有权限修改该角色!',
                        'placement':'bottom-right',
                        'type':'danger',
                        'duration':3,
                        'show':true
                    });
                    return true;
                }
                var data = $scope.row;
                data.new_permissions = $scope.new_permissions;
                if(!(data.parent_id-0)){
                    delete data.parent_id;
                }
                $http({
                    method: 'POST',
                    url: $scope.data_url,
                    data: data
                }).success(function(){
                    window.cacheData[route] = null;
                    $timeout(function(){
                        if($scope.row.id){
                            //$location.path($scope.back_url);
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

            //选中
            $scope.checkedp = function(checked,left,right){
                //向下选中所有子节点,向上选中父节点
                checked = checked-0;
                var permissions = $scope.permissions;
                for (var permission in permissions){
                    if((checked && left>permissions[permission].left_margin && right<permissions[permission].right_margin)||
                        (left<permissions[permission].left_margin && right>permissions[permission].right_margin)){
                        $scope.permissions[permission].checked = checked;
                        $scope.new_permissions[permission] = checked ? $scope.permissions[permission].id : 0;
                    }
                }
            }
        }

    }]);
})