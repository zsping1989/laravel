/**
 * Created by zhangshiping on 16-5-12.
 */
//require.s.contexts._.config.paths.data = '/Admin/index';
//dump(require.s.contexts._.defined.data);

define(['app',dataPath(),'admin/public/headerController','admin/public/leftController'], function (app,datas) {
    var datas = datas || data;

    dump(datas);
    app.register.controller('admin-apiCtrl', ["$scope", '$rootScope','Model','View','$alert', function ($scope,$rootScope,Model,View,$alert) {
        $scope = View.with(datas,$scope);
        $rootScope.nav = datas.nav;
        /* 获取数据,刷新数据 */
        $scope.getData = Model.getData;
        $scope.initselect = function(){
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



