/**
 * Created by zhang on 16-5-18.
 */
define(['app'], function (app) {
    app.register.controller('home-indexCtrl', ["$scope", '$rootScope','Model','View','$alert', function ($scope,$rootScope,Model,View,$alert) {
        dump(datas);
        $scope = View.with([],$scope);
        $rootScope = View.withCache([],$rootScope,1);
        /* 获取数据 */
        $scope.getData = Model.getData;
    }]);
})