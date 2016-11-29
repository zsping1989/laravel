app.controller('admin-role-editCtrl', ["$scope", '$rootScope', 'Model', 'View',
    '$http',
    function ($scope, $rootScope, Model, View, $http) {
        dump(datas);
        datas.row = (!datas.row || (typeof datas.row.length=='number' && !datas.row.length)) ? {} : datas.row;
        $rootScope = View.with(datas.global, $rootScope);
        $scope = View.with(datas, $scope);
        $scope.errorFieldMap = {};
        //重置备份数据
        $scope.master = angular.copy($scope.row);
        $scope.resetdata = function () {
            $scope.row = angular.copy($scope.master);
        };

        /* 条件查询数据 */
        $scope.getData = Model.getData;

        //提交
        $scope.submit = function () {
            if (!$scope.canEdit) {
                $alert({
                    'title': '警告',
                    'content': '你没有权限修改该角色!',
                    'placement': 'bottom-right',
                    'type': 'danger',
                    'duration': 3,
                    'show': true
                });
                return true;
            }
            var data = $scope.row;
            data.new_permissions = $scope.new_permissions;
            if (!(data.parent_id - 0)) {
                delete data.parent_id;
            }
            $http({
                method: 'POST',
                url: $scope.edit_url,
                data: data
            }).success(function () {
                $scope.error = {};
                window.setTimeout(function(){
                    if($scope.row.id){
                        window.location.href = $scope.back_url;
                    }
                },1000);
            }).error(function (data) {
                if (typeof data == "object") {
                    for (var i in data) {
                        for (var j in data[i]) {
                            data[i][j] = data[i][j].replace(i.replace('_', ' ') + ' ', $scope.errorFieldMap[i]);
                        }
                    }
                    $scope.error = data;
                }
            });
        }

        //选中
        $scope.checkedp = function (checked, left, right) {
            //向下选中所有子节点,向上选中父节点
            //转换类型
            checked = checked - 0;
            left = left-0;
            right = right-0;
            var permissions = $scope.permissions;
            for (var permission in permissions) {
                if ((checked && left > (permissions[permission].left_margin-0) && right < (permissions[permission].right_margin-0)) ||
                    (left < (permissions[permission].left_margin-0) && right > (permissions[permission].right_margin-0))) {
                    $scope.permissions[permission].checked = checked;
                    $scope.new_permissions[permission] = checked ? $scope.permissions[permission].id : 0;
                }
            }
        }

    }]);