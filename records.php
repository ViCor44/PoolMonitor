<?php 
/*
	Projeto Final LEI
	Ficheiro: records.php
	Autor: Victor Correia
	Descrição: Página para registo de valores na BD
*/
include('functions.php');


?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script>
        function GetFromIP(){
            var xmlhttp = new XMLHttpRequest();
            var IPdata;
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                IPdata = JSON.parse(this.responseText);                
            }
            };
            xmlhttp.open("GET", "ip_table_db.php", true);
            xmlhttp.send();
            setTimeout(function() {
		        for (i = 0; i < IPdata.length; i++){
                    GetArduinoInputs("http://" + IPdata[i].ip + "/ajax_inputs", IPdata[i].idPisc);                    
		}	    }, 700);
            setTimeout('GetFromIP()', 180000);
        }

        function GetArduinoInputs(ip, id_pisc){ 
            var idPisc = id_pisc;                    
            nocache = "&nocache=" + Math.random() * 1000000;
            var request = new XMLHttpRequest();
            request.onreadystatechange = function()
            {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        if (this.responseXML != null) {
                            // extract XML data from XML file (containing switch states and analog value)                            
                            var cloro = this.responseXML.getElementsByTagName('freeChlorine')[0].childNodes[0].nodeValue;
                            var pH = this.responseXML.getElementsByTagName('pH')[0].childNodes[0].nodeValue;
                            var temp = this.responseXML.getElementsByTagName('temperature')[0].childNodes[0].nodeValue;
                            var alarm = this.responseXML.getElementsByTagName('alarme')[0].childNodes[0].nodeValue;
                            inserir_registo(idPisc, cloro, pH, temp, alarm);
                        }
                    }
                }
                
            }            
            request.open("GET", ip + nocache, true);
            request.send(null);             
        }

        function inserir_registo(idPisc, cloro, pH, temp, alarm)
        {        
            //dados a enviar, vai buscar os valores dos campos que queremos enviar para a BD
            
            pageurl = 'store.php';            
            $.ajax({
        
                //url da pagina
                url: pageurl,
                //parametros a passar
                data: {
                    'idPisc' : idPisc,
                    'cloro' : cloro,
                    'pH' : pH,
                    'temp' : temp,
                    'alarm' : alarm
                },               
                type: 'POST',                            
                cache: false,
                //se ocorrer um erro na chamada ajax, retorna este alerta
                //possiveis erros: pagina nao existe, erro de codigo na pagina, falha de comunicacao/internet, etc etc etc
                error: function(){
                    alert('Erro: Falha de chamada AJAX!');
                },
                //retorna o resultado da pagina para onde enviamos os dados
                success: function(result)
                { 
                    //se foi inserido com sucesso
                    if($.trim(result) == '0')
                    {
                        alert("Ocorreu um erro ao inserir o seu registo!");
                    }                    
                }
            });            
        }
    </script>
    </head>
    <body onload="GetFromIP()">         
    </body>
</html>