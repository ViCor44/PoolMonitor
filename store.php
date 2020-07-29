<?php
/*
	Projeto Final LEI
	Ficheiro: store.php
	Autor: Victor Correia
	Descrição: Guarda os parâmetros na base de dados
*/
    include('connection.php');
   //recebe os parâmetros
    $idPisc = $_REQUEST['idPisc'];
    echo ($idPisc);
    $cloro = $_REQUEST['cloro'];
    echo ($cloro);
    $pH = $_REQUEST['pH'];
    echo ($pH);
    $temp = $_REQUEST['temp'];
    $alarm = $_REQUEST['alarm'];
 
    try
    {
        //insere na BD
        $query = "INSERT INTO data_table (id_pisc, cloro, pH, temp, alarme) VALUES('".trim($idPisc)."','".trim($cloro)."','".trim($pH)."','".trim($temp)."','".trim($alarm)."')";
        mysqli_query($db, $query);
 
        //retorna 1 para no sucesso do ajax saber que foi com inserido sucesso
        echo "1";
    } 
    catch (Exception $ex)
    {
        //retorna 0 para no sucesso do ajax saber que foi um erro
        echo "0";
    }
?>