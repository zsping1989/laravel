define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    var datas = datas || data;
    dump(datas);
    app.register.controller('admin-role-editCtrl', ["$scope",'$rootScope', 'Model','View','$alert','$http','$location','$timeout',
    function ($scope,$rootScope,Model,View,$alert,$http,$location,$timeout) {
        //数据缓存,用于方便更新数据
        var route = parseURL('hash');
        //动态路由需要重新获取数据
        if(route!=datas.route && !window.cacheData[route]){
            $http({
                method: 'GET',
                url: route,
                async: false
            }).success(function(data){
                window.cacheData[route] = {'master':data.row,'permissions':data.permissions};
                init();
            })
        }else {
            init();
        }
        function init(){
            var maindata = window.cacheData[route] || {'master':datas.row,'permissions':datas.permissions};
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
                var data = $scope.row;
                if(!data.parent_id){
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
                            $location.path($scope.back_url);
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
        }

        $rootScope.nav = datas.nav;
        $rootScope.route = datas.route;

    }]);
})