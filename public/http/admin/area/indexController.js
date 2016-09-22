dump(datas.global);
app.controller('admin-area-indexCtrl', ["$scope",'$rootScope', 'Model','View', function ($scope,$rootScope,Model,View) {
        $scope.data_key = '/admin/area/list';
        $rootScope = View.with(datas.global,$rootScope,1);
        $scope = View.with(datas.list,$scope);

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



