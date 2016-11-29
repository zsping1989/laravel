app.controller('{{$tpl_controller}}', ["$scope",'$rootScope', 'Model','View','$alert', function ($scope,$rootScope,Model,View,$alert) {
    dump(datas);
    $scope = View.with(datas.list,$scope);
    $rootScope = View.with(datas.global,$rootScope);

    /* 条件查询数据 */
    $scope.getData = Model.getData;
    $scope.ids = [];
    $scope.allIds = [];
    /* 删除数据 */
    $scope.delete = Model.delete;
    $scope.selectAllId = Model.selectAllId;
}]);



