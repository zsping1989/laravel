app.controller('admin-indexCtrl', ["$scope", '$rootScope','Model','View',
    function ($scope,$rootScope,Model,View) {
        $rootScope = View.with(datas.global,$rootScope); //公共数据
        $scope = View.with(datas,$scope);
        dump(datas);

        /* 获取数据 */
        $scope.getData = Model.getData;
}]);



