app.controller('admin-chart-bar-chartCtrl', ["$scope",'$rootScope', 'Model','View',
    function ($scope,$rootScope,Model,View) {
        $rootScope = View.with(datas.global,$rootScope);
        $scope = View.with(datas.list,$scope);


}]);





