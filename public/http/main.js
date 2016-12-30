var myChart = []; //echarts画图自动放缩
/**
 * echart响应式
 */
window.onresize = function () {
    if (typeof myChart == 'object') {
        for (var i  in myChart) {
            myChart[i].resize();
        }
    }
};

//三方组件包配置
require.config({
    baseUrl: "/bower_components",
    paths: {
        "jquery": 'jquery/dist/jquery.min',
        'css': 'require-css/css.min',
        'lodash': '/compatibility/lodash/3.10.1/lodash.min',
        'backbone': 'backbone/backbone-min',
        'joint': 'jointjs/dist/joint.min',
        'underscore': 'underscore/underscore-min',
        'echart':'echarts/',
        'echarts': 'echarts/dist/echarts.min',
        'layer': 'layer/build/layer',
        'ztree_core':'ztree/js/jquery.ztree.core-3.5.min',
        'ztree':'ztree/js/jquery.ztree.excheck-3.5.min',
        'geetest':'https://static.geetest.com/static/tools/gt'
    },
    map: {},
    shim: {
        'lodash': ['jquery'],
        'backbone': ['jquery', 'lodash'],
        'layer': ['jquery', 'css!/bower_components/layer/build/skin/default/layer.css'],
        "joint": ["jquery", 'lodash', 'backbone', 'css!/bower_components/jointjs/dist/joint.min.css'],
        'ztree_core': ['jquery'],
        'ztree': ['jquery', 'ztree_core', 'css!/bower_components/ztree/css/zTreeStyle/zTreeStyle.css'],
        'geetest':['jquery']
    },
    deps: ['css'], //启动
    urlArgs: "versions=" //+ (new Date()).getTime()  //防止读取缓存，调试用
});

var app = angular.module('app', ['mgcrea.ngStrap','ngAnimate']); //app模块启动
//全局请求配置,响应监听
app.factory('httpInterceptor', ['$q', '$injector', function ($q, $injector) {
    var httpInterceptor = {
        'responseError': function (response) {
            dump(response);
            if (response.data === null) {
                response.data = {};
            }
            //页面跳转
            if (response.data.redirect) {
                window.location.href = response.data.redirect;
            }
            //页面弹窗提示
            if (response.data.alert) {
                $alert(response.data.alert);
            }
            return $q.reject(response);
        },
        'response': function (response) {
            if (response.data === null) {
                response.data = {};
            }
            //页面跳转
            if (response.data.redirect) {
                window.location.href = response.data.redirect;
            }
            //页面弹窗提示
            if (response.data.alert) {
                $alert(response.data.alert);
            }

            return response;
        }, 'request': function (config) {
            return config;
        },
        'requestError': function (config) {
            return $q.reject(config);
        }
    }
    return httpInterceptor;
}]);

/* 数据渲染 */
app.factory('View', ['$http','$alert', function ($http,$alert) {
    window.$alert = $alert;
    var factory = {};
    factory.with = function (data, scope) {
        if (typeof data == 'undefined') {
            return scope;
        }
        if (data.where) {
            for (var i in data.where) {
                if (data.where[i]['val'] && (data.where[i]['type'] == 'dateStart' || data.where[i]['type'] == 'dateEnd')) {
                    data.where[i].val = new Date(data.where[i].val);
                }
            }
        }
        //默认排序对象
        data.order = data.order || [];
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

app.factory('Model', ['$http', 'View', function ($http, View) {
    var factory = {};
    //条件查询数据
    factory.getData = function ($scope, params) {
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
            var objt = typeof (where[i].val);
            if (where[i].type == 'dateStart' && objt == 'object') {
                where[i].val = handleDate(where[i].val, 'yyyy-MM-dd');
            } else if (where[i].type == 'dateEnd' && objt == 'object') {
                where[i].val = handleDate(where[i].val, 'yyyy-MM-dd');
            } else if(objt=='string'){
                where[i].val = where[i].val.replace(/(^\s*)|(\s*$)/g, "");
            }
            var val = where[i].val;
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
            resparams = {page: 1};
            var where = $scope.oldWhere;
            for (var i in where) {
                var objt = typeof (where[i].val);
                if (where[i].type == 'dateStart' && objt == 'object') {
                    where[i].val = handleDate(where[i].val, 'yyyy-MM-dd');
                } else if (where[i].type == 'dateEnd' && objt == 'object') {
                    where[i].val = handleDate(where[i].val, 'yyyy-MM-dd');
                } else if(objt=='string'){
                    where[i].val = where[i].val.replace(/(^\s*)|(\s*$)/g, "");
                }
                var val = where[i].val;
                resparams['where[' + i + ']'] = where[i];
            }
            $scope.reset = -1;
            //开始时间
            $scope.dateOptions0 = {
                maxDate: new Date(),
                showWeeks: true
            };

            //结束时间
            $scope.dateOptions1 = {
                maxDate: new Date(),
                showWeeks: true
            };
        }

        //请求数据
        $http({
            method: 'GET',
            url: $scope.data_url,
            params: resparams
        }).success(function (data) {
            if (params.refresh == 1) {
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
            View.with(data, $scope);
        });
    };

    //置顶
    factory.upTop = function ($scope, id) {
        //请求数据
        $http({
            method: 'POST',
            url: $scope.upTop_url + '/' + id
        }).success(function () {
            factory.getData($scope, {refresh: 2});
        });
    };

    //删除数据
    factory.delete = function ($scope, id) {
        var ids = id || $scope.ids;
        var data = [];
        if (typeof ids == 'object') {
            for (var i in ids) {
                if (ids[i]) {
                    data[data.length] = ids[i];
                }
            }
        } else {
            data = ids;
        }
        if (!data || (typeof ids == 'object' && !ids.length)) {
            return false;
        }
        //请求数据
        $http({
            method: 'POST',
            url: $scope.delete_url,
            data: {ids: data}
        }).success(function () {
            $scope.selectAll = false;
            $scope.ids = [];
            factory.getData($scope, {refresh: 2});
        });
    };

    factory.selectAllId = function ($scope, selectAll) {
        if (selectAll) {
            $scope.ids = $scope.allIds;
        } else {
            $scope.ids = []
        }
    };

    return factory
}]);

/* 全局函数调用 */
app.filter('F', [function () {
    return function () {
        var f = eval(arguments[0]);
        arguments.splice = [].splice;
        var p = arguments.splice(1);
        return f.apply(this, p);
    };
}]);

//http全局配置
app.config(['$httpProvider', function ($httpProvider) {
    $httpProvider.interceptors.push('httpInterceptor');
}]);

//中文包
angular.module("ngLocale", [], ["$provide", function ($provide) {
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
        "pluralCat": function (n, opt_precision) {
            return PLURAL_CATEGORY.OTHER;
        }
    });
}]);

/**
 * 打印调试
 */
function dump() {
    for (var i = 0; i < arguments.length; ++i) {
        console.log(arguments[i]);
    }
}

/**
 * 格式化数字
 * @param num
 * @returns {string}
 */
function toThousands(num) {
    var num = (num || 0).toString(), result = '';
    while (num.length > 3) {
        result = ',' + num.slice(-3) + result;
        num = num.slice(0, num.length - 3);
    }
    if (num) { result = num + result; }
    return result;
}

/**
 * 二进制转数组
 * @param num
 * @returns {Array}
 */
function binaryToArray(num) {
    var res = [];
    var i = 0;
    while (num) {
        if (num & 1) {
            res[res.length] = pow(2, i);
        }
        num >>= 1;
        i++;
    }
    return res;
}

/**
 * 数组转二进制
 * @param arr
 * @returns {number}
 */
function arrayToBinary(arr) {
    if (!arr) {
        return 0;
    }
    var res = 0;
    for (var i in arr) {
        res |= arr[i];
    }
    return res;
}

/**
 * 字符串截取
 * @param value
 * @param limit
 * @param end
 */
function str_limit(value, limit, end) {
    limit = limit || 100;
    end = end || '...';
    var _str = value ? String(value) : '';
    if (_str.length > limit) {
        return _str.substring(0, 4) + '...';
    }
    return _str;
}

/**
 * 获取路径参数
 * @param key
 * @param url
 * @returns {*}
 */
function parseURL(key, url) {
    var a = document.createElement('a');
    a.href = url || window.location.href;
    var res = {
        source: url,
        protocol: a.protocol.replace(':', ''),
        host: a.hostname,
        port: a.port,
        query: a.search,
        params: (function () {
            var ret = {},
                seg = a.search.replace(/^\?/, '').split('&'),
                len = seg.length, i = 0, s;
            for (; i < len; i++) {
                if (!seg[i]) {
                    continue;
                }
                s = seg[i].split('=');
                ret[s[0]] = s[1];
            }
            return ret;
        })(),
        file: (a.pathname.match(/\/([^\/?#]+)$/i) || [, ''])[1],
        hash: a.hash.replace('#', ''),
        path: a.pathname.replace(/^([^\/])/, '/$1'),
        relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [, ''])[1],
        segments: a.pathname.replace(/^\//, '').split('/')
    };
    if (key) {
        return res[key];
    }
    return res;
}

/**
 * 时间差
 * @param s
 * @returns {*}
 */
function arrive_timer_format(s) {
    var t;
    if (s > -1) {
        hour = Math.floor(s / 3600);
        min = Math.floor(s / 60) % 60;
        sec = s % 60;
        day = parseInt(hour / 24);

        if (day > 0) {
            hour = hour - 24 * day;
            if (hour < 10) {
                t = day + "天 0" + hour + ":";
            } else {
                t = day + "天 " + hour + ":";
            }
        } else {
            if (hour < 10) {
                t = '0' + hour + ":";
            } else {
                t = hour + ":";
            }
        }
        if (min < 10) {
            t += "0";
        }
        t += min + ":";
        if (sec < 10) {
            t += "0";
        }
        t += sec;
    }
    return t;
}

/**
 * 保留几位小数
 * @param num
 * @param leng
 * @returns {string}
 */
function toFixed(num, leng) {
    num = Number(num) || 0;
    return num.toFixed(leng)
}

/**
 * 屏蔽空格键
 * @param e
 * @returns {boolean}
 */
function banInputSapce(e) {
    var keynum;
    if (window.event) { //IE
        keynum = e.keyCode
    }
    else if (e.which) {// Netscape/Firefox/Opera
        keynum = e.which
    }
    if (keynum == 32) {
        return false;
    }
    return true;
}
/**
 * 对日期进行格式化，
 * @param date 要格式化的日期
 * @param format 进行格式化的模式字符串
 *     支持的模式字母有：
 *     y:年,
 *     M:年中的月份(1-12),
 *     d:月份中的天(1-31),
 *     h:小时(0-23),
 *     m:分(0-59),
 *     s:秒(0-59),
 *     S:毫秒(0-999),
 *     q:季度(1-4)
 * @return String
 * @author yanis.wang
 */
function dateFormat(date, format) {
    if (!format) {
        format = 'yyyy-MM-dd hh:mm:ss';
    }

    date = new Date(date * 1000);
    return handleDate(date, format);
}

/**
 * js日期对象格式化
 * @param date
 * @param format
 * @returns {*}
 */
function handleDate(date, format) {
    if (!date) {
        return '';
    }
    var map = {
        "M": date.getMonth() + 1, //月份
        "d": date.getDate(), //日
        "h": date.getHours(), //小时
        "m": date.getMinutes(), //分
        "s": date.getSeconds(), //秒
        "q": Math.floor((date.getMonth() + 3) / 3), //季度
        "S": date.getMilliseconds() //毫秒
    };
    format = format.replace(/([yMdhmsqS])+/g, function (all, t) {
        var v = map[t];
        if (v !== undefined) {
            if (all.length > 1) {
                v = '0' + v;
                v = v.substr(v.length - 2);
            }
            return v;
        }
        else if (t === 'y') {
            return (date.getFullYear() + '').substr(4 - all.length);
        }
        return all;
    });
    return format;
}


/**
 * 两个时间戳相距
 * @param time 时间戳
 */
function dateApart(time) {
    time = Math.abs(time);
    if (time < 60) {
        return time + '秒';
    } else if (time < 3600) {
        return Math.round(time / 60) + '分钟';
    } else if (time < 3600 * 24) {
        return Math.round(time / 3600) + '小时';
    } else if (time < 3600 * 24 * 30) {
        return Math.round(time / 3600 / 24) + '天';
    } else if (time < 3600 * 24 * 30 * 12) {
        return Math.round(time / 3600 / 24 / 30) + '月';
    } else {
        return Math.round(time / 3600 / 24 / 365) + '年';
    }
}

/**
 * 数组长度
 * @param arr
 * @returns {number}
 */
function cout(arr) {
    return arr ? arr.length : 0;
}

/**
 * 返回值层级拼接
 * @param num
 * @returns {*}
 */
function deep(num) {
    var str = '|';
    for (var i = 1; i < num; ++i) {
        str += '—';
    }
    if (num > 1) {
        return str + ':';
    }
    return '';
}






