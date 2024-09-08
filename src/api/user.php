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

if ($action == 'read') {
    $sql = mysqli_query($connect, "SELECT * FROM user");
    $users = array();
    while ($row = mysqli_fetch_array($sql)) {
        array_push($users, array(
            "UserID" => $row['UserID'],
            "Name" => $row['Name'],
            "Brokername" => $row['Brokername'],
            "Email" => $row['Email'],
            "Password" => $row['Password']
        ));
    }
    $result['user'] = $users;
}

if ($action == 'registration') {
    $name = $data['name'] ?? null;
    $brokername = $data['brokername'] ?? null;
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;

    if ($name && $brokername && $email && $password) {
        $stmt = mysqli_prepare($connect, "INSERT INTO user (Name, Brokername, Email, Password) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $name, $brokername, $email, $password);
        $execute = mysqli_stmt_execute($stmt);

        if ($execute) {
            $result['message'] = "User added successfully!";
            $result['error'] = false;
        } else {
            $result['error'] = true;
            $result['message'] = "Failed to add user!";
        }

        mysqli_stmt_close($stmt);
    } else {
        $result['error'] = true;
        $result['message'] = "All fields are required!";
    }
}

if ($action == 'login') {
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;

    if ($email && $password) {
        $stmt = mysqli_prepare($connect, "SELECT * FROM user WHERE Email=? AND Password=?");
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        $result_stmt = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_array($result_stmt);

        if ($user) {
            // generiert token
            $token = bin2hex(random_bytes(64));
            $result['message'] = "Login successful!";
            $result['error'] = false;
            $result['user'] = array(
                "UserID" => $user['UserID'],
                "Name" => $user['Name'],
                "Brokername" => $user['Brokername'],
                "Email" => $user['Email'],
                "Password" => $user['Password']
            );
            $result['token'] = $token;
        } else {
            $result['error'] = true;
            $result['message'] = "Invalid email or password!";
        }

        mysqli_stmt_close($stmt);
    } else {
        $result['error'] = true;
        $result['message'] = "Email and password are required!";
    }
}

if ($action == 'update') {
    $userid = $data['userid'] ?? null;
    $name = $data['name'] ?? null;
    $brokername = $data['brokername'] ?? null;
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;

    if ($userid && $name && $brokername && $email && $password) {
        $stmt = mysqli_prepare($connect, "UPDATE user SET Name=?, Brokername=?, Email=?, Password=? WHERE UserID=?");
        mysqli_stmt_bind_param($stmt, "ssssi", $name, $brokername, $email, $password, $userid);
        $execute = mysqli_stmt_execute($stmt);

        if ($execute) {
            $result['message'] = "User updated successfully!";
        } else {
            $result['error'] = true;
            $result['message'] = "Failed to update user!";
        }

        mysqli_stmt_close($stmt);
    } else {
        $result['error'] = true;
        $result['message'] = "All fields are required!";
    }
}

echo json_encode($result);
mysqli_close($connect);
?>