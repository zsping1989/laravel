/**
 * 注册容器服务
 * Created by zhangshiping on 16-5-12.
 */
define(['angular'], function (angular) {
    var main  = angular.module('main',[]);
    //全局请求配置
    main.factory('httpInterceptor', [ '$q', '$injector',function($q, $injector) {
        var httpInterceptor = {
            'responseError' : function(response) {
                dump(response);
                //页面跳转
                if(response.data.redirect){
                    window.location.href = response.data.redirect;
                    //弹出警告框
                }else if(response.data.alert){
                    alert(response.data.title)
                }
                return $q.reject(response);
            },
            'response' : function(response) {
                return response;
            }, 'request' : function(config) {
                return config;
            },
            'requestError' : function(config){
                return $q.reject(config);
            }
        }
        return httpInterceptor;
    }]);


    /* 数据渲染 */
    main.factory('View', function () {
        var factory = {};
        factory.with = function (data, scope) {
            if (typeof data == 'undefined') {
                return scope;
            }
            //默认排序对象
            scope.order = data.order || {};
            data.where = data.where || {};
            for (var i in scope.where) {
                if (!data.where[i]) {
                    data.where[i] = scope.where[i];
                    data.where[i].val = '';
                }
            }
            delete data.order;
            delete data.where;
            for (var i in data) {
                scope[i] = data[i];
            }
            scope.$this = scope;
            return scope;
        }
        return factory;
    });

    main.factory('Model',['$http','View',function($http,View){
        var factory = {};
        factory.getData = function ($scope,params) {
            params = params || {};
            var page = parseInt(params.page) || 1; //默认第一页
            page = page > $scope.last_page ? $scope.last_page : page; //超出最后一页,显示最后一页
            //选择页码为当前页码不请求
            if (params.page === 0 || (params.page && page == $scope.current_page)) {
                return true;
            }
            var resparams = {};
            resparams.page = page;

            /* 条件处理 */
            var where = $scope.where;
            var flog = false;
            for (var i in where) {
                if (where[i].val.replace(/(^\s*)|(\s*$)/g, "")) {
                    resparams['where[' + i + ']'] = where[i];
                    flog = true;
                }
            }
            //查询条件为空不请求
            if (!params.order && !flog && page == $scope.current_page && !params.reset) {
                return true;
            }

            /* 排序处理 */

            if (params.order) {
                var str = params.order;
                params.order = {};
                params.order[str] = $scope.order[str] == 'desc' ? 'asc' : 'desc';
            }
            var order = params.order || $scope.order;
            //追加排序
            for (var i in $scope.order) {
                order[i] = order[i] ? order[i] : $scope.order[i];
            }
            resparams.order = order;
            if (params.reset) {
                if(!$scope.reset){return true}
                resparams = {page: 1};
                $scope.reset = -1;
            }

            //请求数据
            $http({
                method: 'GET',
                url: $scope.data_url,
                params: resparams}).success(function (datas) {
                $scope.reset++;
                View.with(datas,$scope);
            });
        };
        return factory
    }]);

    /* 全局函数调用 */
    main.filter('F', [ function () {
        return function (x) {
            var f = eval(arguments[0]);
            arguments.splice = [].splice;
            var p = arguments.splice(1);
            return f.apply(this, p);
        };
    }]);

    //http全局配置
    main.config(['$httpProvider',function($httpProvider){
        $httpProvider.interceptors.push('httpInterceptor');
    }]);
});

