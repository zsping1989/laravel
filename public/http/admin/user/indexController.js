app.controller('admin-user-indexCtrl', ["$scope",'$rootScope', 'Model','View',
    function ($scope,$rootScope,Model,View) {
        $scope.data_key = '/admin/user/list';
        $rootScope = View.with(datas.global,$rootScope,1);
        $scope = View.with(datas.list,$scope);


        /* 条件查询数据 */
        $scope.getData = Model.getData;
        $scope.ids = [];
        $scope.allIds = [];
        /* 删除数据 */
        $scope.delete = Model.delete;
        $scope.selectAllId = Model.selectAllId;
    }]);



