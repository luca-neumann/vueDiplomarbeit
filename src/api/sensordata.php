<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$result = array();
$result['error'] = false;

// connect to the database
$host_name = 'localhost';
$host_user = 'root';
$host_password = '';
$host_db = 'smartsensornetz';

$connect = @mysqli_connect($host_name, $host_user, $host_password, $host_db);

if ($connect && $host_db) {
    $connect_db = @mysqli_select_db($connect, $host_db);
    if ($connect_db) {
        $result['is_db_connected'] = true;
        $result['connection_msg'] = 'Successfully connected to the database';
    } else {
        $result['is_db_connected'] = false;
        $result['connection_msg'] = 'Failed to connect to the database, please check the database name';
    }
} else {
    $result['is_db_connected'] = false;
    $result['connection_msg'] = 'Failed to connect to the database, please check the database credentials';
}

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// actions
$action = $_GET['action'] ?? '';

// alle Sensordaten werden ausgelesen
if ($action == 'read') {
    $sql = mysqli_query($connect, "SELECT * FROM sensordata");
    $sensordata = array();
    while ($row = mysqli_fetch_array($sql)) {
        array_push($sensordata, array(
            "ValueID" => $row['ValueID'],
            "ClientID" => $row['ClientID'],
            "Pm1.0" => $row['Pm1.0'],
            "Pm2.5" => $row['Pm2.5'],
            "Pm10" => $row['Pm10'],
            "Timestamp" => $row['Timestamp'],
            "Date" => $row['Date']
        ));
    }
    $result['sensordata'] = $sensordata;
}



echo json_encode($result);
mysqli_close($connect);
?>