function gen_dial(obj, base, value, charttitle) {
    obj.highcharts({
        chart: {
            type: 'gauge',
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false,
            height: 400,
        },
        credits: {"enabled": false},
        title: {
            text: charttitle,
        },

        pane: {
            startAngle: -90,
            endAngle: 90,
            background: null,
            center: ["50%", "60%"],
        },

        // the value axis
        yAxis: {
            min: 0,
            max: 100,

            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 15,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: 'ร้อยละ' + ' ' + [value],
                y: 100,
            },
            plotBands: [{
                from: 0,
                to: base,
                color: '#DF5353' // red
            },{
                from: base,
                to: 100,
                color: '#55BF3B' // green
            }]
        },
        series: [{
                name: "ร้อยละ",
                data: [value],
                tooltip: {
                    valueSuffix: " "
                },
                dataLabels:{
                    enabled : false
                },
                
            }]// จบ content
    });// จบ chart

}
