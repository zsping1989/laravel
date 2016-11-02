app.controller('admin-chart-bar-chartCtrl', ["$scope",'$rootScope', 'Model','View',
    function ($scope,$rootScope,Model,View) {
        $scope.data_key = '/admin/chart/bar-chart';
        $rootScope = View.with(datas.global,$rootScope,1);
        $scope = View.with(datas.list,$scope);
        require([
            'admin/chart/data',
            'echarts/echarts',
            '/lib/echart/theme/macarons.js',
            'echarts/chart/line',
            'echarts/chart/bar',
            'echarts/chart/scatter',
            'echarts/chart/k',
            'echarts/chart/pie',
            'echarts/chart/radar',
            'echarts/chart/force',
            'echarts/chart/chord',
            'echarts/chart/gauge',
            'echarts/chart/funnel',
            'echarts/chart/eventRiver'],function(dataMap,echarts, defaultTheme){
            var domMain = document.getElementById('main');
            var myChart = echarts.init(domMain, defaultTheme);
            var option = {
                timeline:{
                    data:[
                        '2002-01-01','2003-01-01','2004-01-01'
                    ],
                    label : {
                        formatter : function(s) {
                            return s.slice(0, 4);
                        }
                    },
                    autoPlay : true,
                    playInterval : 1000
                },
                options:[
                    {
                        title : {
                            'text':'2002全国宏观经济指标',
                            'subtext':'数据来自国家统计局'
                        },
                        tooltip : {'trigger':'axis'},
                        legend : {
                            x:'right',
                            'data':['GDP','金融','房地产'],
                            'selected':{
                                'GDP':true,
                                '金融':false,
                                '房地产':true
                            }
                        },
                        toolbox : {
                            'show':true,
                            orient : 'vertical',
                            x: 'right',
                            y: 'center',
                            'feature':{
                                'mark':{'show':true},
                                'dataView':{'show':true,'readOnly':false},
                                'magicType':{'show':true,'type':['line','bar','stack','tiled']},
                                'restore':{'show':true},
                                'saveAsImage':{'show':true}
                            }
                        },
                        calculable : true,
                        grid : {'y':80,'y2':100},
                        xAxis : [{
                            'type':'category',
                            'axisLabel':{'interval':0},
                            'data':[
                                '北京','\n天津','河北','\n山西','内蒙古','\n辽宁','吉林','\n黑龙江',
                                '上海','\n江苏','浙江','\n安徽','福建','\n江西','山东','\n河南',
                                '湖北','\n湖南','广东','\n广西','海南','\n重庆','四川','\n贵州',
                                '云南','\n西藏','陕西','\n甘肃','青海','\n宁夏','新疆'
                            ]
                        }],
                        yAxis : [
                            {
                                'type':'value',
                                'name':'GDP（亿元）',
                                'max':53500
                            },
                            {
                                'type':'value',
                                'name':'其他（亿元）'
                            }
                        ],
                        series : [
                            {
                                'name':'GDP',
                                'type':'bar',
                                'markLine':{
                                    symbol : ['arrow','none'],
                                    symbolSize : [4, 2],
                                    itemStyle : {
                                        normal: {
                                            lineStyle: {color:'orange'},
                                            barBorderColor:'orange',
                                            label:{
                                                position:'left',
                                                formatter:function(params){
                                                    return Math.round(params.value);
                                                },
                                                textStyle:{color:'orange'}
                                            }
                                        }
                                    },
                                    'data':[{'type':'average','name':'平均值'}]
                                },
                                'data': dataMap.dataGDP['2002']
                            },
                            {
                                'name':'金融','yAxisIndex':1,'type':'bar',
                                'data': dataMap.dataFinancial['2002']
                            },
                            {
                                'name':'房地产','yAxisIndex':1,'type':'bar',
                                'data': dataMap.dataEstate['2002']
                            }
                        ]
                    },
                    {
                        title : {'text':'2003全国宏观经济指标'},
                        series : [
                            {'data': dataMap.dataGDP['2003']},
                            {'data': dataMap.dataFinancial['2003']},
                            {'data': dataMap.dataEstate['2003']}
                        ]
                    },
                    {
                        title : {'text':'2004全国宏观经济指标'},
                        series : [
                            {'data': dataMap.dataGDP['2004']},
                            {'data': dataMap.dataFinancial['2004']},
                            {'data': dataMap.dataEstate['2004']}
                        ]
                    }
                ]
            };
            myChart.setOption(option, true)
        })

    }]);





