app.controller('admin-profile-messageCtrl', ["$scope",'$rootScope', 'Model','View','$alert',
    function ($scope,$rootScope,Model,View,$alert) {
        dump(datas.list);
        $rootScope = View.with(datas.global,$rootScope);
        $scope = View.with(datas.list,$scope);


        /* 条件查询数据 */
        $scope.getData = Model.getData;
        $scope.ids = [];
        $scope.allIds = [];
        /* 删除数据 */
        $scope.delete = Model.delete;
        $scope.selectAllId = Model.selectAllId;
        $scope.switch = function(key,val){
            if($scope.where[key].val==val){
                return true;
            }
            $scope.where[key].val = val;
            $scope.getData($scope,{refresh:2});
        }

}]);



