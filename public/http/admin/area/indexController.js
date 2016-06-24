define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    var datas = datas || data;
    dump(datas);
    app.register.controller('admin-area-indexCtrl', ["$scope",'$rootScope', 'Model','View','$alert', function ($scope,$rootScope,Model,View,$alert) {
        //数据缓存,用于方便更新数据
        var maindata = window.cacheData['admin-area-index'] || datas.list;
        window.cacheData['admin-area-index'] = maindata;
        $scope.data_key = 'admin-area-index';

        $scope = View.with(maindata,$scope);
        $rootScope.nav = datas.nav;
        $rootScope.route = datas.route;
        /* 条件查询数据 */
        $scope.getData = Model.getData;
        $scope.ids = [];
        $scope.allIds = [];
        /* 删除数据 */
        $scope.delete = Model.delete;
        $scope.selectAllId = Model.selectAllId;
    }]);
})



