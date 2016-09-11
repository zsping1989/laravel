//获取路由数据,注册路由
requirejs(['/data/home/index/routes?define=AMD'],function(data){
    window.cacheData = {};
    //自动注册路由
    window.routes = handleRoute(data.menus);
    var url = parseURL();
    data.route = url['hash'] || url['path'];
    //当前路由不存在,自动组成路由
    if(window.routes[data.route] || ckeckUrl(data.route)){
        window.routes.default = data.route; //当前路由
        //window.routes[data.route] = {'as':data.route,'path':data.route};
    //默认根目录路由
    }else if(data.route=='/'){
        window.routes.default ='/home/auth/login';
    //没有对应路由跳转404页面
    }else {
        window.routes.default ='/admin/page404';
    }
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
            'lodash':'/lib/lodash/3.10.1/lodash.min',
            'backbone':'/lib/backbone/backbone.min',
            'joint':'/lib/joint/0.9.6/joint.min',
            'underscore':'/lib/underscore/1.8.3/underscore.min',
            "app":'app'
        },
        map: {
        },
        shim: {
            "angular": { exports: "angular" },
            "angularAMD": ["angular"],
            "ngload": ["angularAMD"],
            'lodash':['jquery'],
            'backbone':['jquery','lodash'],
            "joint": ["jquery",'lodash','backbone','css!/lib/joint/0.9.6/joint.css'],
            "angular-ui-router": ["angular"]
        },
        deps: ['app','css'], //启动
        urlArgs: ''//"time=" + (new Date()).getTime()  //防止读取缓存，调试用
    });

    function ckeckUrl(route){
        var flog = false;
        for (var i in window.routes){
            if(route.indexOf(i.replace(/\:.*/ ,""))==0){
                flog = true;
            }
        }
        return flog;
    }
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



