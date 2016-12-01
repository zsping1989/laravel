app.controller('admin-user-frameworkCtrl', ["$scope",'$rootScope', 'Model','View','$http',
    function ($scope,$rootScope,Model,View,$http) {
    $rootScope = View.with(datas.global,$rootScope,1);
    $scope = View.with(datas,$scope);

    /* 条件查询数据 */
    $scope.getData = Model.getData;
        require(['joint'],function(joint){
            //三方jquery插件画图
            var graph = new joint.dia.Graph();
            var paper = new joint.dia.Paper({
                el: $('#paper'),
                height: $scope.height+200,
                gridSize: 1,
                model: graph,
                perpendicularLinks: true,
                restrictTranslate: true
            });

            var member = function (x, y, rank, name, image, background, textColor) {

                textColor = textColor || "#000";

                var cell = new joint.shapes.org.Member({
                    position: {x: x, y: y},
                    attrs: {
                        '.card': {fill: background, stroke: 'none'},
                        image: {'xlink:href': '/img/joint/' + image, opacity: 0.7},
                        '.rank': {text: rank, fill: textColor, 'word-spacing': '-5px', 'letter-spacing': 0},
                        '.name': {text: name, fill: textColor, 'font-size': 13, 'font-family': 'Arial', 'letter-spacing': 0}
                    }
                });
                graph.addCell(cell);
                return cell;
            };

            function link(source, target, breakpoints) {

                var cell = new joint.shapes.org.Arrow({
                    source: {id: source.id},
                    target: {id: target.id},
                    vertices: breakpoints,
                    attrs: {
                        '.connection': {
                            'fill': 'none',
                            'stroke-linejoin': 'round',
                            'stroke-width': '2',
                            'stroke': '#4b4a67'
                        }
                    }

                });
                graph.addCell(cell);
                return cell;
            }
            var colour = {'level_6':'#f4f4f4','level_2':'#367fa9','level_3':'#008d4c','level_4':'#00acd6','level_5':'#d73925','level_1':'#e08e0b'};
            var barts = {}; //图标对象

            for(var i in $scope.roles){
                var x = $scope.roles[i].x || ($scope.width-200)/(Math.pow(2,$scope.level_count[$scope.roles[i].level]))+($scope.roles[i].level_num*200)-1;
                var y = $scope.roles[i].y || 115*$scope.roles[i].level;
                //画图
                barts['id'+$scope.roles[i].id] = member(
                    x, //宽
                    y, //高
                    $scope.roles[i].name, //角色名称
                    $scope.roles[i].users, //用户名称
                    'male.png', //图片
                    colour['level_'+$scope.roles[i].level]); //背景颜色

                //划线链接
                if($scope.roles[i].parent_id){
                    //拐点1确定
                    var spinodal1 = barts['id'+$scope.roles[i].parent_id].position();
                    var spinodal2 = barts['id'+$scope.roles[i].id].position();
                    link(
                        barts['id'+$scope.roles[i].id],
                        barts['id'+$scope.roles[i].parent_id],
                        [{x:spinodal2.x+100,y:spinodal1.y+100},{x:spinodal1.x+100,y:spinodal1.y+100}]);
                }
            }
        });


    $scope.saveCoord = function(){
        var data = [];
        for(var i in barts){
            var coord = barts[i].position();
            data[data.length] = {id: i.replace('id',''),x:coord.x,y:coord.y};
        }
        $http({
            method: 'POST',
            url: '/admin/user/framework',
            data: {positions:data}
        })
    }




}]);



