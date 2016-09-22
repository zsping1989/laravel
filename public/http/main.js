var app = angular.module('app', []);

/* 调试打印 */
function dump(){
    for (var i = 0; i < arguments.length; ++i) {
        console.log(arguments[i]);
    }
}

/* 后台路由转换前端静态路由处理 */
function handleRoute(menus){
    //自动注册路由
    var routes = {};
//menus = [menus[7]];
    for(var i in menus){
        if(!menus[i].url){continue};
        //参数路由处理
        var route = menus[i].url.replace(/\{/ ,":").replace(/[\?]{0,1}\}/ ,"");
        var path = menus[i].url.replace(/\/\{(\w+)[\?]\}/ ,"");
        routes[route]={
            'as': path,
            'path':path
        };
    }
    return routes;
}

/* 二进制转数组 */
function binaryToArray(num){
    var res = [];
    var i = 0;
    while(num){
        if(num&1){
            res[res.length] = pow(2,i);
        }
        num >>= 1;
        i++;
    }
    return res;
}

/* 数组转二进制 */
function arrayToBinary(arr){
    if(!arr){return 0;}
    var res = 0;
    for(var i in arr){
       res |= arr[i];
    }
    return res;
}

/* 获取路径参数 */
function parseURL(key,url) {
    var a =  document.createElement('a');
    a.href = url || window.location.href;
    var res = {
        source: url,
        protocol: a.protocol.replace(':',''),
        host: a.hostname,
        port: a.port,
        query: a.search,
        params: (function(){
            var ret = {},
                seg = a.search.replace(/^\?/,'').split('&'),
                len = seg.length, i = 0, s;
            for (;i<len;i++) {
                if (!seg[i]) { continue; }
                s = seg[i].split('=');
                ret[s[0]] = s[1];
            }
            return ret;
        })(),
        file: (a.pathname.match(/\/([^\/?#]+)$/i) || [,''])[1],
        hash: a.hash.replace('#',''),
        path: a.pathname.replace(/^([^\/])/,'/$1'),
        relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [,''])[1],
        segments: a.pathname.replace(/^\//,'').split('/')
    };
    if(key){
        return res[key];
    }
    return res;
}

function dataPath(nodata){

    if(nodata && window.cacheData['global']){
        return null;
    }else if(parseURL('hash')==routes.default || !window.cacheData['global']){
        return '/data'+parseURL('hash')+'?define=AMD&global=all&time='+(new Date()).getTime();
    }else{
        return '/data'+parseURL('hash')+'?define=AMD&time='+(new Date()).getTime();
    }
}

//数组长度
function cout(arr){
    return arr ? arr.length : 0;
}

/* 返回值层级拼接 */
function deep(num) {
    var str = '|';
    for (var i = 1; i < num; ++i) {
        str += '—';
    }
    if (num > 1) {
        return str+':';
    }
    return '';
}

function  updateData(key,retain){
    if(!key){
        for(var i in window.cacheData){
            window.cacheData[i]['updatedata']=1;
        }
    }
    if(!retain){
        window.cacheData[key] = false; //更新页面数据
    }else {
        if(window.cacheData[key]){
            window.cacheData[key]['updatedata'] = 1; //更新页面数据
        }else {
            window.cacheData[key] = false; //更新页面数据
        }
    }
    return true;
}
//全局请求配置,响应监听
    app.factory('httpInterceptor', [ '$q', '$injector',function($q, $injector) {
        var httpInterceptor = {
            'responseError' : function(response) {
                dump(response);
                //页面跳转
                if(response.data.redirect){
                    window.location.href = response.data.redirect;
                }
                //页面弹窗提示
                if(response.data.alert && $alert){
                    $alert(response.data.alert);
                }
                return $q.reject(response);
            },
            'response' : function(response) {
                //页面跳转
                if(response.data.redirect){
                    window.location.href = response.data.redirect;
                }
                //页面弹窗提示
                if(response.data.alert && $alert){
                    $alert(response.data.alert);
                }

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
    app.factory('View', ['$http',function ($http) {
        var factory = {};
        factory.with = function (data, scope) {
            if (typeof data == 'undefined') {
                return scope;
            }
            if(data.redirect){
                window.location.href = '#'+data.redirect;
            }
            //默认排序对象
            scope.order = data.order || [];
            data.where = data.where || [];
            for (var i in scope.where) {
                if (!data.where[i]) {
                    data.where[i] = scope.where[i];
                    data.where[i].val = '';
                }
            }
            //delete data.order;
            //delete data.where;
            for (var i in data) {
                scope[i] = data[i];
            }
            scope.$this = scope;
            return scope;
        }

        return factory;
    }]);

    app.factory('Model',['$http','View',function($http,View){
        var factory = {};
        //条件查询数据
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
                var val = where[i].val.replace(/(^\s*)|(\s*$)/g, "");
                if (val) {
                    flog = true;
                }
                resparams['where[' + i + ']'] = where[i];
            }
            //查询条件为空不请求
            if (!params.order && !flog && page == $scope.current_page && !params.reset && !params.refresh) {
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
                params: resparams}).success(function (data) {

                if(params.refresh==1){
                    $alert({
                        'title':'提示',
                        'content':'刷新成功!',
                        'placement':'bottom-right',
                        'type':'info',
                        'duration':3,
                        'show':true
                    });
                }
                $scope.reset++;
                View.with(data,$scope);
            });
        };

        //置顶
        factory.upTop = function($scope,id){
            //请求数据
            $http({
                method: 'POST',
                url: $scope.upTop_url+'/'+id
            }).success(function () {
                factory.getData($scope,{refresh:2});
            });
        };

        //删除数据
        factory.delete = function($scope,id){
            var ids =id || $scope.ids;
            var data = [];
            if(typeof ids=='object'){
                for (var i in ids){
                    if(ids[i]){
                        data[data.length] = ids[i];
                    }
                }
            }else {
                data = ids;
            }
            if(!data || (typeof ids =='object' && !ids.length)){
                return false;
            }
            //请求数据
            $http({
                method: 'POST',
                url: $scope.delete_url,
                data: {ids:data}
            }).success(function () {
                $scope.selectAll = false;
                $scope.ids = [];
                factory.getData($scope,{refresh:2});
            });
        };

        factory.selectAllId = function($scope,selectAll){
            if(selectAll){
                $scope.ids = $scope.allIds;
            }else {
                $scope.ids = []
            }
        };

        return factory
    }]);

    /* 全局函数调用 */
    app.filter('F', [ function () {
        return function () {
            var f = eval(arguments[0]);
            arguments.splice = [].splice;
            var p = arguments.splice(1);
            return f.apply(this, p);
        };
    }]);


//http全局配置
    app.config(['$httpProvider',function($httpProvider){
        $httpProvider.interceptors.push('httpInterceptor');
    }]);


//中文包
angular.module("ngLocale", [], ["$provide", function($provide) {
    var PLURAL_CATEGORY = {ZERO: "zero", ONE: "one", TWO: "two", FEW: "few", MANY: "many", OTHER: "other"};
    $provide.value("$locale", {
        "DATETIME_FORMATS": {
            "AMPMS": [
                "\u4e0a\u5348",
                "\u4e0b\u5348"
            ],
            "DAY": [
                "\u661f\u671f\u65e5",
                "\u661f\u671f\u4e00",
                "\u661f\u671f\u4e8c",
                "\u661f\u671f\u4e09",
                "\u661f\u671f\u56db",
                "\u661f\u671f\u4e94",
                "\u661f\u671f\u516d"
            ],
            "ERANAMES": [
                "\u516c\u5143\u524d",
                "\u516c\u5143"
            ],
            "ERAS": [
                "\u516c\u5143\u524d",
                "\u516c\u5143"
            ],
            "FIRSTDAYOFWEEK": 6,
            "MONTH": [
                "\u4e00\u6708",
                "\u4e8c\u6708",
                "\u4e09\u6708",
                "\u56db\u6708",
                "\u4e94\u6708",
                "\u516d\u6708",
                "\u4e03\u6708",
                "\u516b\u6708",
                "\u4e5d\u6708",
                "\u5341\u6708",
                "\u5341\u4e00\u6708",
                "\u5341\u4e8c\u6708"
            ],
            "SHORTDAY": [
                "\u5468\u65e5",
                "\u5468\u4e00",
                "\u5468\u4e8c",
                "\u5468\u4e09",
                "\u5468\u56db",
                "\u5468\u4e94",
                "\u5468\u516d"
            ],
            "SHORTMONTH": [
                "1\u6708",
                "2\u6708",
                "3\u6708",
                "4\u6708",
                "5\u6708",
                "6\u6708",
                "7\u6708",
                "8\u6708",
                "9\u6708",
                "10\u6708",
                "11\u6708",
                "12\u6708"
            ],
            "STANDALONEMONTH": [
                "\u4e00\u6708",
                "\u4e8c\u6708",
                "\u4e09\u6708",
                "\u56db\u6708",
                "\u4e94\u6708",
                "\u516d\u6708",
                "\u4e03\u6708",
                "\u516b\u6708",
                "\u4e5d\u6708",
                "\u5341\u6708",
                "\u5341\u4e00\u6708",
                "\u5341\u4e8c\u6708"
            ],
            "WEEKENDRANGE": [
                5,
                6
            ],
            "fullDate": "y\u5e74M\u6708d\u65e5EEEE",
            "longDate": "y\u5e74M\u6708d\u65e5",
            "medium": "y\u5e74M\u6708d\u65e5 ah:mm:ss",
            "mediumDate": "y\u5e74M\u6708d\u65e5",
            "mediumTime": "ah:mm:ss",
            "short": "y/M/d ah:mm",
            "shortDate": "y/M/d",
            "shortTime": "ah:mm"
        },
        "NUMBER_FORMATS": {
            "CURRENCY_SYM": "\u00a5",
            "DECIMAL_SEP": ".",
            "GROUP_SEP": ",",
            "PATTERNS": [
                {
                    "gSize": 3,
                    "lgSize": 3,
                    "maxFrac": 3,
                    "minFrac": 0,
                    "minInt": 1,
                    "negPre": "-",
                    "negSuf": "",
                    "posPre": "",
                    "posSuf": ""
                },
                {
                    "gSize": 3,
                    "lgSize": 3,
                    "maxFrac": 2,
                    "minFrac": 2,
                    "minInt": 1,
                    "negPre": "-\u00a4",
                    "negSuf": "",
                    "posPre": "\u00a4",
                    "posSuf": ""
                }
            ]
        },
        "id": "zh-cn",
        "localeID": "zh_CN",
        "pluralCat": function(n, opt_precision) {  return PLURAL_CATEGORY.OTHER;}
    });
}]);



