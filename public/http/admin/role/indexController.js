define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    var datas = datas || data;
    dump(datas);
    app.register.controller('admin-role-indexCtrl', ["$scope",'$rootScope', 'Model','View','$alert','$modal','$http',
        function ($scope,$rootScope,Model,View,$alert,$modal,$http) {
        $scope = View.with(datas.list,$scope);
        $rootScope.nav = datas.nav;
        $rootScope.route = datas.route;
        /* 条件查询数据 */
        $scope.getData = Model.getData;
        $scope.ids = [];
        $scope.allIds = [];
        /* 删除数据 */
        $scope.delete = Model.delete;
        $scope.selectAllId = Model.selectAllId;

        //成员列表查看
        $scope.userList = function(id){
            $http({
                method: 'GET',
                url: '/admin/role/user-list/'+id
               }).success(function(data){
                $scope.userTitle = '用户列表';
                $scope.userData = data;
                $modal({scope: $scope,
                    template: '/http/admin/role/user-list.html',
                    placement:'center',
                    show: true});
            })

        }
    }]);
})



