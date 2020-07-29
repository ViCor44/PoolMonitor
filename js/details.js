function GetInputs(ip)
        {
            var data = [0, 0, 0];
            nocache = "&nocache=" + Math.random() * 1000000;
            var request = new XMLHttpRequest();
            request.onreadystatechange = function()
            {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        if (this.responseXML != null) {
                            // extract XML data from XML file
                            data[0] = this.responseXML.getElementsByTagName('freeChlorine')[0].childNodes[0].nodeValue;
                            data[1] = this.responseXML.getElementsByTagName('pH')[0].childNodes[0].nodeValue;
                            data[2] = this.responseXML.getElementsByTagName('temperature')[0].childNodes[0].nodeValue;                           
                        }
                    } 
                }
            }
            request.open("GET", ip + nocache, false);
            request.send(null);
            return data;           
        }
        $(document).ready(function () {            

            var free;
            var data1 = [], data2 = [], data3 = [];           
            var timestamp = new Date();
            for (var i = 0; i < 10; i++) {
                free = 0;
                timestamp.setMilliseconds(0);
                timestamp.setSeconds(timestamp.getSeconds() - 1);
                data1.push({ timestamp: new Date(timestamp.valueOf()), value: free });
                data2.push({ timestamp: new Date(timestamp.valueOf()), value: free });
                data3.push({ timestamp: new Date(timestamp.valueOf()), value: free });
            }
            data1 = data1.reverse();
            data2 = data2.reverse();
            data3 = data3.reverse();
            // prepare jqxChart settings
            var settings1 = {
                title: " ",
                description: " ",
                enableAnimations: false,
                animationDuration: 1000,
                enableAxisTextAnimation: true,
                showLegend: false,
                padding: { left: 5, top: 5, right: 5, bottom: 5 },
                titlePadding: { left: 0, top: 0, right: 0, bottom: 10 },
                source: data1,
                xAxis:
                {
                    dataField: 'timestamp',
                    type: 'date',
                    baseUnit: 'second',
                    unitInterval: 5,
                    formatFunction: function (value) {
                        return $.jqx.dataFormat.formatdate(value, "hh:mm:ss", 'en-us');
                    },
                    gridLines: { step: 2 },
                    valuesOnTicks: true,
                    
                },
                colorScheme: 'scheme03',
                seriesGroups:
                    [
                        {
                            type: 'spline',
                            columnsGapPercent: 50,
                            alignEndPointsWithIntervals: true,
                            valueAxis:
                            {
                                minValue: 0,
                                maxValue: 1023,                                
                            },
                            series: [
                                    { dataField: 'value', opacity: 1, lineWidth: 2, symbolType: 'circle', fillColorSymbolSelected: 'white', symbolSize: 4 }
                                ]
                        }
                    ]
            };
            // create the chart
            $('#chartContainer1').jqxChart(settings1);
            // get the chart's instance
            var chart1 = $('#chartContainer1').jqxChart('getInstance'); 

            var settings2 = {
                title: " ",
                description: " ",
                enableAnimations: false,
                animationDuration: 1000,
                enableAxisTextAnimation: true,
                showLegend: false,
                padding: { left: 5, top: 5, right: 5, bottom: 5 },
                titlePadding: { left: 0, top: 0, right: 0, bottom: 10 },
                source: data2,
                xAxis:
                {
                    dataField: 'timestamp',
                    type: 'date',
                    baseUnit: 'second',
                    unitInterval: 5,
                    formatFunction: function (value) {
                        return $.jqx.dataFormat.formatdate(value, "hh:mm:ss", 'en-us');
                    },
                    gridLines: { step: 2 },
                    valuesOnTicks: true,
                    
                },
                colorScheme: 'scheme03',
                seriesGroups:
                    [
                        {
                            type: 'spline',
                            columnsGapPercent: 50,
                            alignEndPointsWithIntervals: true,
                            valueAxis:
                            {
                                minValue: 0,
                                maxValue: 1023,                                
                            },
                            series: [
                                    { dataField: 'value', opacity: 1, lineWidth: 2, symbolType: 'circle', fillColorSymbolSelected: 'white', symbolSize: 4 }
                                ]
                        }
                    ]
            };
            // create the chart
            $('#chartContainer2').jqxChart(settings2);
            // get the chart's instance
            var chart2 = $('#chartContainer2').jqxChart('getInstance');
            
            var settings3 = {
                title: " ",
                description: " ",
                enableAnimations: false,
                animationDuration: 1000,
                enableAxisTextAnimation: true,
                showLegend: false,
                padding: { left: 5, top: 5, right: 5, bottom: 5 },
                titlePadding: { left: 0, top: 0, right: 0, bottom: 10 },
                source: data3,
                xAxis:
                {
                    dataField: 'timestamp',
                    type: 'date',
                    baseUnit: 'second',
                    unitInterval: 5,
                    formatFunction: function (value) {
                        return $.jqx.dataFormat.formatdate(value, "hh:mm:ss", 'en-us');
                    },
                    gridLines: { step: 2 },
                    valuesOnTicks: true,
                    
                },
                colorScheme: 'scheme03',
                seriesGroups:
                    [
                        {
                            type: 'spline',
                            columnsGapPercent: 50,
                            alignEndPointsWithIntervals: true,
                            valueAxis:
                            {
                                minValue: 0,
                                maxValue: 1023,                                
                            },
                            series: [
                                    { dataField: 'value', opacity: 1, lineWidth: 2, symbolType: 'circle', fillColorSymbolSelected: 'white', symbolSize: 4 }
                                ]
                        }
                    ]
            };
            // create the chart
            $('#chartContainer3').jqxChart(settings3);
            // get the chart's instance
            var chart = $('#chartContainer3').jqxChart('getInstance');

            // auto update timer
            var ttimer = setInterval(function () {                
                var ip = "http://192.168.0.201/ajax_inputs";
                var source = GetInputs(ip);
                $('#barGauge1').jqxBarGauge({
                colorScheme: "scheme02",
                width: 300,
                height: 300,
                values: [source[0]], max: 1023, tooltip: {
                    visible: true, 
                }
                 });            
                if (data1.length >= 10)
                    data1.splice(0, 1);
                var timestamp = new Date();
                timestamp.setSeconds(timestamp.getSeconds());
                timestamp.setMilliseconds(0);
                data1.push({ timestamp: timestamp, value: source[0] });
                $('#chartContainer1').jqxChart('refresh');
                $('#barGauge2').jqxBarGauge({
                colorScheme: "scheme02",
                width: 300,
                height: 300,
                values: [source[1]], max: 1023, tooltip: {
                    visible: true, 
                }
                 });            
                if (data2.length >= 10)
                    data2.splice(0, 1);
                var timestamp = new Date();
                timestamp.setSeconds(timestamp.getSeconds());
                timestamp.setMilliseconds(0);
                data2.push({ timestamp: timestamp, value: source[1] });                
                $('#chartContainer2').jqxChart('refresh');
                $('#barGauge3').jqxBarGauge({
                colorScheme: "scheme02",
                width: 300,
                height: 300,
                values: [source[2]], max: 1023, tooltip: {
                    visible: true, 
                }
                 });            
                if (data3.length >= 10)
                    data3.splice(0, 1);
                var timestamp = new Date();
                timestamp.setSeconds(timestamp.getSeconds());
                timestamp.setMilliseconds(0);
                data3.push({ timestamp: timestamp, value: source[2] });                
                $('#chartContainer3').jqxChart('refresh');
            }, 2000);
        });