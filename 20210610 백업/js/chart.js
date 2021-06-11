;(function($){

    //입력 데이터 샘플
    var dataSet = {
        가치분석 : {
            '개발가능성': 7, 
            '경사완만': 7,
            '인구유입률': 5,
            '개발호재': 10,
            '도로유무': 5
        },
        개발축: {
            '기간': 10, 
            '수익': 3
        },
        보조축: {
            '기간' : 6, 
            '수익': 4
        },
        보전축: {
            '기간': 6,
            '수익': 0
        }
    };

    //가치분석 데이터 고르기
    var setData01 = function(dataSet){
        var dataSet = dataSet;
        var values = [];
        var key = '가치분석';
        var value = 0;

        var target = dataSet[key];
        for( item in target){
            value = target[item];
            values.push(value);
        };
        return values;
    };

    //축분석 데이터 고르기
    var setData02 = function(dataSet){
        var dataSet = dataSet;
        var labeledValues = {
            '기간': [],
            '수익': []
        };
        var keys = ['개발축', '보조축', '보전축'];
        var labels = ['기간', '수익'];

        keys.forEach(function(item){
            var target = dataSet[item];
            labels.forEach(function(label, idx){
                if(idx === 0) labeledValues[label].push(target[label]);
                else labeledValues[label].push(target[label]);
            })
        })

        return labeledValues;
    };

    var initChart01 = function(datas){
        var data = datas;
        
        var pointRadius = $(window).innerWidth() > 480 ? 18 : 10;
        var pointFontSize = $(window).innerWidth() > 480 ? 15 : 13;
        var labelFontSize = $(window).innerWidth() > 480 ? 20 : 15;

        var config = {
            type: 'radar', 
            data : {
                labels: ['개발가능성', '경사완만', '인구유입률', '개발호재', '도로유무'],
                datasets: [{
                  label: '점수',
                  data: data,
                  fill: true,
                  backgroundColor: 'rgba(120, 104, 230, 0.5)',
                  borderColor: '#7868e6',
                  borderWidth: 4,
                  pointBackgroundColor: '#7868e6',
                  pointBorderColor: '#7868e6',
                  pointRadius: pointRadius,
                  pointHoverRadius: 18,
                  pointHoverBorderColor: '#7868e6',
                  datalabels: {
                    color: '#fff',
                    labels: {
                        title: {
                            font: {
                                size: pointFontSize,
                                weight: '800'
                            }
                        }
                    }
                  }
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scale: {
                    ticks: {
                        min: 0,
                        max: 11,
                        stepSize: 1,
                        backdropColor: 'transparent',
                        fontColor: 'rgba(255,255,255,.7)',
                        fontSize: 0,
                        padding: 0,
                    },
                    angleLines: {
                        color: 'transparent'
                    },
                    gridLines: {
                        color: ['rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
                                ,'rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
                                ,'rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
                                ,'rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
                                ,'rgba(255, 255, 255, 0.03)','rgba(255, 255, 255, 0.25)'
                                ,'transparent']
                    },
                    pointLabels: {
                        fontColor: '#fff',
                        fontSize: labelFontSize,
                        fontFamily: 'GmarketSansMedium',
                        borderWidth: 10,
                    }
                },
                legend: {
                    display: false,
                },
            }
        };
        var chart01 =   new Chart(document.getElementById('chart01'), config);       
    };
           
    var initChart02 = function(datas){
        var data = datas;

        var borderWidth = $(window).innerWidth() > 480 ? 12 : 4;
        var barPercentage = ( $(window).innerWidth() <= 980 && $(window).innerWidth() > 480)? 0.1 : 0.15;

        var config = {
            type: 'bar',
            data: {
                labels: ['개발축', '보조축', '보전축'],
                borderColor: '#fff',
                datasets: [
                    {
                        labels: '기간',
                        data: data['기간'],
                        backgroundColor: ['#7868e6','#23dc7a','#ff5555'],
                        datalabels: {
                            backgroundColor: ['#7868e6','#23dc7a','#ff5555'],
                            borderColor: ['#7868e6','#23dc7a','#ff5555']
                        },
                    },
                    {
                        labels: '수익',
                        data: data['수익'],
                        backgroundColor: ['#7868e6','#23dc7a','#ff5555'],
                        datalabels: {
                            backgroundColor: ['#7868e6','#23dc7a','#ff5555'],
                            borderColor: ['#7868e6','#23dc7a','#ff5555']
                        }
                    }
                ],
        
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: -180 //y축 tick hide
                    }
                },
                scales: {
                    xAxes: [
                        {
                            display: false,
                            categoryPercentage: 1.0,
                            barPercentage: barPercentage
                        }
                    ],
                    yAxes:[
                        {   //display: false,
                            ticks: {
                                min: 0,
                                max: 13,
                                stepSize: 1,
                                fontSize: 0,
                                mirror: true
                            },

                        },{
                            gridLines:{
                                color: ['rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
                                        ,'rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
                                        ,'rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
                                        ,'rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
                                        ,'rgba(255, 255, 255, 0.25)','rgba(255, 255, 255, 0.03)'
                                        ,'transparent', 'transparent', 'transparent']
                            }
                        }
                    ],

                },
                legend: {
                    display: false,
                },
                plugins: {
                    datalabels: {
                        display: true,
                        anchor: 'end',
                        align: 'end',
                        offset: -2,
                        borderWidth: borderWidth,
                        formatter: function(value, context){
                            //박스 스타일 조정위해 공백 삽입
                            if(value<10) return ' ' + value + ' ';
                        },
                        borderRadius: 30,
                        color: '#fff',
                        font: {
                            size: 15,
                            weight: '600',
                            lineHeight: '14px'
                        }
                    }
                }
            }
        };
        var chart02 = new Chart(document.getElementById('chart02'), config);
    };


    $(window).on('load', function(event) {
        event.preventDefault();
        //차트 생성
        initChart01(setData01(dataSet));
        initChart02(setData02(dataSet));
    });

})(jQuery);