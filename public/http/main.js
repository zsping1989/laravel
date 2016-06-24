dump(data);
window.cacheData = {};
//自动注册路由
var routes = handleRoute(data.menus);
data.route = data.route.replace(/\{(\w+)[\?]\}/ ,":$1");
//当前路由不存在,自动组成路由
if(!routes[data.route]){
    routes[data.route] = {'as':data.route,'path':data.route};
}


//路由配置,单页面应用跳转
/*var routes = {
    //路由:控制器或视图
    '/home/home':{'as':'home','path':'home/home'},
    '/home/about':{'as':'about','path':'home/about'},
    '/home/auth/login':{'as':'login','path':'home/login'},
    '/admin/menu/index':{'as':'admin-menu-index','path':'admin/menu/index'},
    '/admin/index':{'as':'admin-index','path':'admin/index'}
}*/
routes.default = data.route; //当前路由
require.config({
    baseUrl: "/http/",
    paths: {
        "jquery":'/lib/jquery/2.2.3/jquery.min',
        "angular": "/lib/angular/1.5.5/angular.min",
        "angular-ui-router": "/lib/angular-ui-router/0.2.8/angular-ui-router.min",
        "angular-strap":'/lib/angular-strap/2.3.8/dist/angular-strap.min',
        "angular-strap-tpl":'/lib/angular-strap/2.3.8/dist/angular-strap.tpl.min',
        'satellizer':'/lib/satellizer/0.14.0/satellizer.min',
        "angularAMD": "/lib/angularAMD/0.2.1/angularAMD.min",
        "angular-animate":'/lib/angular-animate/1.5.5/angular-animate.min',
        "ngload": "/lib/angularAMD/0.2.1/ngload.min",
        "pagination":'/lib/pagination/0.02/pagination',
        'css': '/lib/require-css/0.1.8/css.min',
        'mainService':'/service/mainService',
        "app":'app'
    },
    map: {
    },
    shim: {
        "angular": { exports: "angular" },
        "angularAMD": ["angular"],
        "ngload": ["angularAMD"],
        "pagination": ["angular",'css!/lib/pagination/0.02/pagination.css'],
        "angular-ui-router": ["angular"]

    },
    deps: ['app','css'], //启动
    urlArgs: "time=" + (new Date()).getTime()  //防止读取缓存，调试用
});

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
//menus = [data.menus[6]];
    for(var i in menus){
        if(!menus[i].url){continue};
        //参数路由处理
        var route = menus[i].url.replace(/\{(\w+)[\?]\}/ ,":$1");
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

function dataPath(){
    if(parseURL('hash')==routes.default){
        return null;
    }else{
        return parseURL('hash')+'?define=AMD&time='+(new Date()).getTime();
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




