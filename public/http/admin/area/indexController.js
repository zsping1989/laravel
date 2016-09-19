define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    app.register.controller('admin-area-indexCtrl', ["$scope",'$rootScope', 'Model','View','$alert', function ($scope,$rootScope,Model,View,$alert) {
        $scope.data_key = '/admin/area/list';
        $rootScope = View.withCache(datas.global,$rootScope,1);
        $scope = View.withCache(datas.list,$scope);

        $scope.selectedDate = "2016-09-30T12:46:06.578Z"; // <- [object Date]
        $scope.selectedDateAsNumber = 509414400000; // <- [object Number]
        $scope.fromDate = "2016-09-21T16:00:00.000Z"; // <- [object Date]
        $scope.untilDate = {}; // <- [object Undefined]
        $scope.aa = function(){
            alert($scope.selectedDateAsNumber);
        }


        /* 条件查询数据 */
        $scope.getData = Model.getData;
        $scope.ids = [];
        $scope.allIds = [];
        /* 删除数据 */
        $scope.delete = Model.delete;
        $scope.selectAllId = Model.selectAllId;
    }]);
})



