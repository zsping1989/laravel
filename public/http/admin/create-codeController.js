/**
 * Created by zhangshiping on 16-5-12.
 */
//require.s.contexts._.config.paths.data = '/Admin/index';
//dump(require.s.contexts._.defined.data);

define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    var datas = datas || data;

    dump(datas);
    app.register.controller('admin-create-codeCtrl', ["$scope", '$rootScope','View','$alert','$http', function ($scope,$rootScope,View,$alert,$http) {
        $scope = View.with(datas,$scope);
        $rootScope.nav = datas.nav;
        //创建代码
        $scope.create = function(param){
            $http({
                method: 'POST',
                url: '/admin/make/exe',
                data: param}
            ).success(function (datas) {
                $alert({
                    title: '提示:',
                    content: '操作成功!',
                    placement: 'bottom-right',
                    type: 'info',
                    duration:3,
                    show: true});
            }).error(function(){
                $alert({
                    title: '提示:',
                    content: '操作失败!',
                    placement: 'bottom-right',
                    type: 'danger',
                    duration:3,
                    show: true});
            });
        };
    }]);
})



