/**
 * Created by zhang on 16-5-13.
 */
define(["angular", "angularAMD", "angular-ui-router",'angular-animate','angular-strap-tpl','angular-animate','mainService'], function (angular, angularAMD) {
    //创建app模块
    var app = angular.module("app", ['ngAnimate',"ui.router",'mgcrea.ngStrap','main']);

    app.run(['$rootScope', '$state', '$stateParams',
        function($rootScope, $state, $stateParams) {
            $rootScope.$state = $state;
            $rootScope.$stateParams = $stateParams;
        }
    ]);

    //app初始化
    var init = function($stateProvider, $urlRouterProvider) {
        //路由注册
        for(var i in routes){
            if(i=='default'){
                $urlRouterProvider.otherwise(routes[i]);
            }else{
                $stateProvider.state(routes[i].as, angularAMD.route({
                    url: i,
                    templateUrl: "/http/"+routes[i].path+".html",
                    controllerUrl: "/http/"+routes[i].path+"Controller.js"
                }));
            }
        }
    };

    app.config(["$stateProvider", "$urlRouterProvider", init]);
    angularAMD.bootstrap(app);
    return app;
});