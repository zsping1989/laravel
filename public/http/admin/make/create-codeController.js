app.controller('admin-create-codeCtrl', ["$scope", '$rootScope','View','$http',
        function ($scope,$rootScope,View,$http) {
        $rootScope = View.with(datas.global,$rootScope);
        $scope = View.with(datas,$scope);

        //创建代码
        $scope.create = function(param){
            //命令拼接
            $scope.artisan = param.artisan;
            var option = '';
            for (var i in param){
                if(i=='artisan'){
                    continue;
                }
                if(i.indexOf('--')!=-1 && param[i]){
                    if(param[i]===true){
                        option += ' '+i;
                    }else {
                        option += ' '+i+'='+param[i];
                    }

                    continue;
                }
                if(param[i]){
                    $scope.artisan += ' '+param[i];
                }
            }
            $scope.artisan += option;
            $http({
                    method: 'POST',
                    url: '/admin/make/exe',
                    data: param}
            ).error(function(){
                $alert({
                    'title':'提示',
                    'content':'操作失败!',
                    'placement':'bottom-right',
                    'type':'danger',
                    'duration':3,
                    'show':true
                });
            });
        };
}]);



