/**
 * Created by zhangshiping on 16-5-12.
 */
//require.s.contexts._.config.paths.data = '/Admin/index';
//dump(require.s.contexts._.defined.data);

define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    var datas = datas || data;
    dump(datas);
    app.register.controller('admin-menu-editCtrl', ["$scope",'$rootScope', 'Model','View','$alert', function ($scope,$rootScope,Model,View,$alert) {
        $scope = View.with({'row':datas.row},$scope);
        $rootScope.nav = datas.nav;
        $rootScope.route = datas.route;

    }]);
})



