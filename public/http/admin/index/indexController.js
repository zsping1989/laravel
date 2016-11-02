app.controller('admin-indexCtrl', ["$scope", '$rootScope','Model','View',
    function ($scope,$rootScope,Model,View) {
        $rootScope = View.with(datas.global,$rootScope,1);
        $scope = View.with(datas,$scope);

        /* 获取数据 */
        $scope.getData = Model.getData;
    }]);



