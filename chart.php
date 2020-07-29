<?php 
/*
	Projeto Final LEI
	Ficheiro: chart.php
	Autor: Victor Correia
	Descrição: Apresenta gráfico com parâmetros guardados
*/
    include('functions.php');
    
    if (!isLoggedIn()) {        
        header('location: login.php');
        $_SESSION['msg'] = "You must log in first";
    }

    if (isset($_POST['name'])) {
        $_SESSION['nome'] = e($_POST['name']);

    }
        if (isset($_POST['param'])) {
        $_SESSION['param'] = e($_POST['param']);
    }
?>
<!DOCTYPE html>
<html>
<head>      
    <link rel="stylesheet" href="css/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="css/jqx.light.css" type="text/css" />
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxchart.core.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxchart.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxdraw.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxrangeselector.js"></script> 
    <script type="text/javascript" src="js/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxtooltip.js"></script>
    <script type="text/javascript" src="js/jqwidgets/globalization/globalize.js"></script>   
    <script type="text/javascript">
        $(document).ready(function () {
        var param = "<?php echo $_SESSION['param']; ?>";
        var d1 = new Date();
        var d2 = new Date(d1.getTime() + 86400000);
        var date1 = d1.toLocaleDateString('En-Us');
        var date2 = d2.toLocaleDateString('En-Us');        
		var source =
		{
			 datatype: "json",
			 datafields: [
				 { name: 'Data', type: 'date'},
                 { name: 'Cloro'},
                 { name: 'Temp'},                
				 { name: 'pH'}				
			],
			url: 'data_table.php'
		};

        var dataAdapter = new $.jqx.dataAdapter(source, { async: false, autoBind: true, loadError: function (xhr, status, error) { alert('Error loading "' + source.url + '" : ' + error); } });

	
        var settings = {
            title: "<?php echo $_SESSION['nome']; ?>",
            description: "<?php echo $_SESSION['param']; ?>",
            enableAnimations: false,
            animationDuration: 1000,
            enableAxisTextAnimation: true,
            showLegend: false,
            padding: { left: 5, top: 5, right: 5, bottom: 5 },
            titlePadding: { left: 0, top: 0, right: 0, bottom: 10 },
            source: dataAdapter,
            xAxis:
            {
                dataField: 'Data',
                type: 'date',
                baseUnit: 'hour',
                unitInterval: 20,
                formatFunction: function (value) {
                    return $.jqx.dataFormat.formatdate(value, "dd/MM/yyyy HH:mm");
                },
                showTickMarks: true, 
                tickMarksInterval: Math.round(dataAdapter.records.length / 20),                 
                gridLinesInterval: Math.round(dataAdapter.records.length / 10),
                valuesOnTicks: true,
                minValue: date1,
                maxValue: date2,
                labels: {
                    angle: -45,
                    rotationPoint: 'topright',
                    offset: { x: 0, y: -30 }
                },
                rangeSelector:{
                    formatFunction: function (value) {
                        return $.jqx.dataFormat.formatdate(value, "dd/MM/yy");
                    },
                    theme: 'dark',
                    size: 70,
                    backgroundColor: 'rgb(216, 210, 210)',
                    baseUnit: 'minute',
                    gridLines:{visible:false},
                    serieType: 'area'
                }
                
            },
            colorScheme: 'scheme26',
            seriesGroups:
                [
                    {
                        type: 'spline',
                        columnsGapPercent: 50,
                        alignEndPointsWithIntervals: true,
                        valueAxis:
                        {
                            minValue: 0,
                            maxValue: 'auto',                                
                        },
                        series: [
                                { dataField: param, opacity: 1, lineWidth: 2, symbolType: 'circle', fillColorSymbolSelected: 'white', symbolSize: 4 }
                            ]
                    }
                ]
            };            
            $('#jqxChart').jqxChart(settings);
            $("#print").click(function () {
                var content = $('#jqxChart')[0].outerHTML;
                var newWindow = window.open('', '', 'width=800, height=500'),
                document = newWindow.document.open(),
                pageContent =
                    '<!DOCTYPE html>' +
                    '<html>' +
                    '<head>' +
                    '<meta charset="utf-8" />' +
                    '<title>PoolMonitor Chart</title>' +
                    '</head>' +
                    '<body>' + content + '</body></html>';
                try
                {
                    document.write(pageContent);
                    document.close();
                    newWindow.print();
                    newWindow.close();
                }
                catch (error) {
                }
            });
            $("#print").jqxButton({});            
            $("#jqxDate").jqxDateTimeInput({ width: 250, height: 25,  selectionMode: 'range'});
                $("#jqxDate").on('change', function (event) {
                    var chart = $("#jqxChart").jqxChart('getInstance');
                    var selection = $("#jqxDate").jqxDateTimeInput('getRange');
                    if (selection.from != null) {                              
                        chart.xAxis.minValue = selection.from.toLocaleDateString('en-US');
                        chart.xAxis.maxValue = selection.to.toLocaleDateString('en-US');
                        chart.update();
                        $("#selection").html("<div>From: " + selection.from.toLocaleDateString() + " <br/>To: " + selection.to.toLocaleDateString() + "</div>");
                    }
                });
                 
                $("#jqxDate").jqxDateTimeInput();
	});
    </script>        
</head>
<body onload="if (location.href.indexOf('reload')==-1) {location.replace(location.href+'?reload')}">
    <div class="container">		
		<header class="bp-header cf">
			<div class="dummy-logo">
                <img class="fit-logo" src="img/logo.png">
                <h1 style="left: 500px; float: center"><?php echo $_SESSION['nome']; ?></h1>
                <br>
                <br>
                <br>
                <h4>Seleccione intervalo de datas:<h4>
                <div id='jqxDate' style="margin-left: 40px;"></div>                		
            </div>
        </header> 
        <div class="content-chart">       	
            <div id="jqxChart" style="padding: 10px">
                <div id="jqxRangeSelectorContent">
            </div>
            </div>
            <div style='margin-top: 10px;'>
			    <input style='float: left;' id="print" type="button" value="Imprimir Gráfico" />
		    </div>
        </div>	
    </div>
</body>
</html>