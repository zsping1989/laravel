app.controller('admin-menu-indexCtrl', ["$scope", '$rootScope', 'Model', 'View',
    function ($scope, $rootScope, Model, View) {
        $rootScope = View.with(datas.global, $rootScope);
        $scope = View.with(datas.list, $scope);

        /* 条件查询数据 */
        $scope.getData = Model.getData;
        $scope.upTop = Model.upTop;
        $scope.ids = [];
        $scope.allIds = [];
        /* 删除数据 */
        $scope.delete = Model.delete;
        $scope.selectAllId = Model.selectAllId;
    }]);




