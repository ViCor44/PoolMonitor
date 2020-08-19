<!DOCTYPE html>
<html lang="en">
<head>
    <title id='Description'>This example shows how to create a Grid from JSON data.</title>
    <link rel="stylesheet" href="css/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="css/jqx.light.css" type="text/css" />
    <link rel="stylesheet" href="css/jqx.darkblue.css" type="text/css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 minimum-scale=1" />	
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxgrid.selection.js"></script> 
    <script type="text/javascript" src="js/jqwidgets/jqxgrid.columnsresize.js"></script> 
    <script type="text/javascript" src="js/jqwidgets/jqxdata.js"></script> 
    <script type="text/javascript" src="js/demos.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var url = "ip_table_db.php";
            // prepare the data
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'ip', type: 'string' },
                    { name: 'name', type: 'string' },
                ],
                id: 'id',
                url: url
            };
            var dataAdapter = new $.jqx.dataAdapter(source);
            $("#grid").jqxGrid(
            {
                width: getWidth('Grid'),
                source: dataAdapter,
                columnsresize: false,
                altrows: true,
                theme: 'darkblue',
                columns: [
                  { text: 'IP', datafield: 'ip', width: 'auto' },
                  { text: 'Nome Piscina', datafield: 'name', width: 'auto' },
              ]              
            });
            $("#grid").jqxGrid('autoresizecolumns');            
        });
    </script>
</head>
<body class='default'>
        <div id="grid"></div>
</body>
</html>