define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    var datas = datas || data;
    dump(datas);
    app.register.controller('{{$tpl_controller}}', ["$scope",'$rootScope', 'Model','View','$alert', function ($scope,$rootScope,Model,View,$alert) {
        $scope = View.with({'row':datas.row},$scope);
        $rootScope.nav = datas.nav;
        $rootScope.route = datas.route;

    }]);
})