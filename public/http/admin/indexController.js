/**
 * Created by zhangshiping on 16-5-12.
 */
//require.s.contexts._.config.paths.data = '/Admin/index';
//dump(require.s.contexts._.defined.data);
define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    app.register.controller('admin-indexCtrl', ["$scope", '$rootScope','Model','View','$alert', function ($scope,$rootScope,Model,View,$alert) {
        $rootScope = View.withCache(datas.global,$rootScope,1);
        $scope = View.with(datas,$scope);

        /* 获取数据 */
        $scope.getData = Model.getData;
    }]);
})



