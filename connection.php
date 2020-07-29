<?php
/*
	Projeto Final LEI
	Ficheiro: connection.php
	Autor: Victor Correia
	Descrição: Ficheiro de conexão com a base de dados
*/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "poolmonitor";

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>