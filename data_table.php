<?php
/*
	Projeto Final LEI
	Ficheiro: data.php
	Autor: Victor Correia
	Descrição: Ficheiro que devolve a tabela data_table em formato json
*/	
    include('connection.php');
    include('functions.php');
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }
    if (isset($_POST['name'])) {
        $_SESSION['nome'] = e($_POST['name']);

    }
    if (isset($_POST['param'])) {
        $_SESSION['param'] = e($_POST['param']);
    }


    $sqlAux = "SELECT id FROM piscinas WHERE name='{$_SESSION['nome']}'";    
    $resultAux = $db->query($sqlAux);
    $row = $resultAux->fetch_assoc();
    $sql = "SELECT * FROM data_table WHERE id_pisc=".$row['id'];
    $result = $db->query($sql);
    
    if (!empty($result) && $result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $orders[] = array(            
                'Data' => $row['timestamp'],
                'Cloro' => $row['cloro'],
                'pH' => $row['pH'],
                'Temp' => $row['temp']            		
            );
        }
        header('Content-Type: application/json');
        echo json_encode($orders);
    } else {
        echo "0 results";
    }
?>