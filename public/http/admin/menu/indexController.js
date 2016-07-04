define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    app.register.controller('admin-menu-indexCtrl', ["$scope",'$rootScope', 'Model','View','$alert',
        function ($scope,$rootScope,Model,View,$alert) {
            //数据缓存,用于方便更新数据
            var maindata = window.cacheData['admin-menu-index'] || datas.list;
            window.cacheData['admin-menu-index'] = maindata;
            $scope.data_key = 'admin-menu-index';

            $scope = View.with(maindata,$scope);
            $rootScope = View.with(datas.global,$rootScope);
        /* 条件查询数据 */
        $scope.getData = Model.getData;
        $scope.upTop = Model.upTop;
        $scope.ids = [];
        $scope.allIds = [];
        /* 删除数据 */
        $scope.delete = Model.delete;
        $scope.selectAllId = Model.selectAllId;
    }]);
})



