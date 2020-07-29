<?php
include('connection.php');

$sql = "SELECT * FROM data_table";
$result = $conn->query($sql);

if (!empty($result) && $result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $orders[] = array(
			'Data' => $row['timestamp'],
            'Cloro' => $row['cloro']            		
		  );
    }
    echo json_encode($orders);
} else {
    echo "0 results";
}

?>