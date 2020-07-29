<?php
/*
	Projeto Final LEI
	Ficheiro: piscinas.php
	Autor: Victor Correia
	Descrição: Ficheiro que devolve a tabela piscinas em formato json
*/	
include('connection.php');
include('functions.php');

if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}

$sql = "SELECT * FROM users";
$result = $db->query($sql);
$rows = $result->num_rows;

if (!empty($result) && $result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $data[] = array(
            'id' => $row['id'],
            'username' => $row['username'],
            'userType' => $row['userType'], 
            'checkAdmin' => $row['checkAdmin']                              		
		  );
    }
    echo json_encode($data);
} else {
    echo "0 results";
}

?>