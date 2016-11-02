/**
 * Created by zhangshiping on 16-5-13.
 */

app.controller('home-loginCtrl',["$scope",'$http',function($scope,$http){
    dump(datas);
    $scope.errorFieldMap = {};

    /**
     * 切换验证码
     */
    $scope.switchCaptcha = function(){
        $scope.captcha = '/home/auth/captcha?time='+(new Date()).getTime();
    }

    /**
     * 用户登录
     */
    $scope.login = function(){
        var post_data = {
            username:$scope.username,
            password:$scope.password,
            verify:$scope.verify,
            remember:$scope.remember,
            _token:datas._token
        };
        if($scope.remember){
            post_data.remember = 1;
        }else{
            post_data.remember = undefined;
        }
        $http.post('/home/auth/login',post_data).success(function(res){
        }).error(function(data){
            if(typeof data == "object"){
                for(var i in data){
                    for(var j in data[i]){
                        data[i][j] = data[i][j].replace(i.replace('_',' ')+' ',$scope.errorFieldMap[i]);
                    }
                }
                $scope.error = data;
            }
            $scope.switchCaptcha();
        });
    }


}])


