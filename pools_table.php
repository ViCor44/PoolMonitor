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
    <script type="text/javascript" src="js/jqxcore.js"></script>
    <script type="text/javascript" src="js/jqxbuttons.js"></script>
    <script type="text/javascript" src="js/jqxcheckbox.js"></script>
    <script type="text/javascript" src="js/jqxscrollbar.js"></script>
    <script type="text/javascript" src="js/jqxmenu.js"></script>
    <script type="text/javascript" src="js/jqxgrid.js"></script>
    <script type="text/javascript" src="js/jqxgrid.selection.js"></script> 
    <script type="text/javascript" src="js/jqxgrid.columnsresize.js"></script> 
    <script type="text/javascript" src="js/jqxdata.js"></script> 
    <script type="text/javascript" src="js/demos.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var url = "pools.php";
            // prepare the data
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'Id', type: 'int' },
                    { name: 'Name', type: 'string' },
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
                  { text: 'ID', datafield: 'Id', width: 'auto' },
                  { text: 'Nome Piscina', datafield: 'Name', width: 'auto' },
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