app.controller('admin-role-indexCtrl', ["$scope",'$rootScope', 'Model','View','$http',
    function ($scope,$rootScope,Model,View,$http) {
        dump(datas);
        $scope.data_key = '/admin/role/list';
        $rootScope = View.with(datas.global,$rootScope,1);
        $scope = View.with(datas.list,$scope);


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
                url: '@{{admin/role/user-list/'+id
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



