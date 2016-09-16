define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    app.register.controller('admin-profile-messageCtrl', ["$scope",'$rootScope', 'Model','View','$alert', function ($scope,$rootScope,Model,View,$alert) {
        $scope.data_key = '/admin/profile/list';
        updateData('/admin/profile/list',1);
        dump(datas.list);
        $rootScope = View.withCache(datas.global,$rootScope,1);
        $scope = View.withCache(datas.list,$scope);


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
})



