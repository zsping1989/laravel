define(['app', dataPath(), 'admin/public/headerController', 'admin/public/leftController'], function (app, datas) {
    app.register.controller('admin-role-editCtrl', ["$scope", '$rootScope', 'Model', 'View', '$alert', '$http', '$location', '$timeout',
        function ($scope, $rootScope, Model, View, $alert, $http, $location, $timeout) {
            $rootScope = View.with(datas.global, $rootScope);
            $scope = View.withCache(datas, $scope);

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
                    window.cacheData['/admin/role/list'] = false; //更新页面数据
                    $timeout(function () {
                        if ($scope.row.id) {
                            $location.path($scope.back_url);
                        }
                    }, 1000);
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
                checked = checked - 0;
                var permissions = $scope.permissions;
                for (var permission in permissions) {
                    if ((checked && left > permissions[permission].left_margin && right < permissions[permission].right_margin) ||
                        (left < permissions[permission].left_margin && right > permissions[permission].right_margin)) {
                        $scope.permissions[permission].checked = checked;
                        $scope.new_permissions[permission] = checked ? $scope.permissions[permission].id : 0;
                    }
                }
            }

        }]);
})