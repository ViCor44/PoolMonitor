<?php
/*
	Projeto Final LEI
	Ficheiro: piscinas.php
	Autor: Victor Correia
	Descrição: Ficheiro que devolve a tabela piscinas em formato json
*/	
include('connection.php');
include('functions.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
$sql = "SELECT * FROM piscinas";
$result = $db->query($sql);
$rows = $result->num_rows;

if (!empty($result) && $result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $data[] = array(
            'Id' => $row['id'],
			'Name' => $row['name'],                                		
		  );
    }
    echo json_encode($data);
} else {
    echo "0 results";
}

?>