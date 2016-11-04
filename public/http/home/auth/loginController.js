/**
 * Created by zhangshiping on 16-5-13.
 */

app.controller('home-loginCtrl',["$scope",'$http','$alert',function($scope,$http,$alert){
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
            //verify:$scope.verify,
            /* 极验 */
            geetest_challenge:$("input[name='geetest_challenge']").val(),
            geetest_validate:$("input[name='geetest_validate']").val(),
            geetest_seccode:$("input[name='geetest_seccode']").val(),
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

    /**
     * 极验验证
     */
    require(['geetest'],function(){
            initGeetest(datas.geetest, function(captchaObj){
                $("#geetest-captcha").closest('form').submit(function(e) {
                    var validate = captchaObj.getValidate();
                    if (!validate) {
                        $alert({
                            'title': '提示',
                            'content': datas.geetest.client_fail_alert,
                            'placement': 'bottom-right',
                            'type': 'info',
                            'duration': 3,
                            'show': true
                        });
                        e.preventDefault();
                        return false;
                    }
                    $scope.login();
                    captchaObj.refresh()
                });
                captchaObj.appendTo("#geetest-captcha");
                captchaObj.onReady(function() {
                    $("#wait")[0].className = "hide";
                });
            });
    });
}])


