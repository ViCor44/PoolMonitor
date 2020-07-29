<!DOCTYPE html>
<html lang="en">
<head>
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
            var url = "users_db.php";
            // prepare the data
            var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'id', type: 'int' },
                    { name: 'username', type: 'string' },
                    { name: 'userType', type: 'string' },
                    { name: 'checkAdmin', type: 'bool' }                   
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
                  { text: 'Id', datafield: 'id', width: 'auto' },
                  { text: 'Utilizador', datafield: 'username', width: 'auto' },
                  { text: 'Tipo', datafield: 'userType', width: 'auto' },
                  { text: 'Autorização', datafield: 'checkAdmin', columntype: 'checkbox', width: 'auto', cellsalign: 'left'}                
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