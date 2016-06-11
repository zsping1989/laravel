/**
 * Created by zhangshiping on 16-5-12.
 */
//require.s.contexts._.config.paths.data = '/Admin/index';
//dump(require.s.contexts._.defined.data);

define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    var datas = datas || data;

    dump(datas);
    app.register.controller('admin-apiCtrl', ["$scope", '$rootScope','Model','View','$alert','$http', function ($scope,$rootScope,Model,View,$alert,$http) {
        //数据分配
        $scope = View.with(datas,$scope);
        $rootScope.nav = datas.nav;

        /* 获取数据,刷新数据 */
        $scope.getData = Model.getData;

        //接口参数添加
        $scope.addparams=[];
        $scope.addparam = function(){
            $scope.addparams[$scope.addparams.length] = {};
        }

        //接口参数重置
        $scope.reset = function(){
            for(var i in $scope.api[$scope.select[$scope.select.length-1]].params){
                $scope.api[$scope.select[$scope.select.length-1]].params[i].example = '';
            }
        }

        //接口提交
        $scope.params = {};
        /* 树状数据变成一维数组 */
        function treeToArr(tree, key, deep) {
            key = key ? key + '-' : '';
            deep = deep ? deep + 1 : 1;
            var result = [];
            if (typeof tree == 'object') {
                for (var i in tree) {
                    if (typeof tree[i] != 'object') {
                        result[result.length] = {"key": key + i, "k": i, "type": typeof tree[i], "value": tree[i], "deep": deep};
                    } else {
                        result[result.length] = {"key": key + i, "k": i, "type": typeof tree[i], "value": "array", "deep": deep};
                        var res = treeToArr(tree[i], key + i, deep);
                        for (var j = 0; j < res.length; j++) {
                            result[result.length] = res[j];
                        }
                    }
                }
            } else {
                result[result.length] = {"key": key, "k": 0, "type": typeof tree, "value": tree, "deep": deep};
            }
            return result;
        }
        $scope.submit = function(){
            var $form = window.document.getElementsByTagName('form')[0];
            var $dd = window.document.getElementById('dd');
            $form.target = 'view';
            $dd.disabled = false;
            $form.submit();
            $form.target = '_blank';
            $dd.disabled = 'disabled';
            //get方式
            var obj = {};
            var api = $scope.api[$scope.select[$scope.select.length-1]];
            if(api.method==1){
                obj.method = 'GET';
                obj.params = $scope.params;
            }else{
                obj.method = 'POST';
                obj.data = $scope.params;
            }
            obj.url = api.url;
            //扁平数据
            $http(obj).success(function (datas) {
                $scope.result = treeToArr(datas);
            }).error(function(datas){
                $scope.result = treeToArr(datas);
            });
        }

        //接口选择
        $scope.initselect = function(){
            $scope.addparams=[];
            //接口选择默认选中项
            var select = [];
            if($scope.select){
                for(var i in $scope.select){
                    i = Number(i);
                    if($scope.select[i+1] && datas.api[$scope.select[i]].id==datas.api[$scope.select[i+1]].parent_id){
                        select[select.length] = $scope.select[i];
                    }else{
                        break;
                    }
                }
                select = $scope.select.slice(0,select.length+1);
            }
            var flog = false;
            for(var i in datas.api){
                if(!select.length){
                    select[0] = i;
                    flog = true; //可以退出
                    continue;
                }
                if(datas.api[i].level>datas.api[select[select.length-1]].level && datas.api[select[select.length-1]].id==datas.api[i].parent_id){
                    select[select.length] = i;
                    flog = true; //可以退出
                }else{
                    if(flog){
                        break;
                    }
                }
            }
            $scope.select = select;
        }
        $scope.initselect();

        var selectlength = [];
        for(var i=1;i<datas.max_level-1;++i ){
            selectlength[i-1] = i-1;
        }
        $scope.selectlength = selectlength;
    }]);
})



