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

// alle User werden ausgelesen
if ($action == 'read') {
    $sql = mysqli_query($connect, "SELECT * FROM user");
    $users = array();
    while ($row = mysqli_fetch_array($sql)) {
        array_push($users, array(
            "UserID" => $row['UserID'],
            "Firstname" => $row['Firstname'],
            "Lastname" => $row['Lastname'],
            "Brokername" => $row['Brokername'],
            "Email" => $row['Email'],
            "Password" => $row['Password']
        ));
    }
    $result['user'] = $users;
}

// ein bestimmter User wird ausgelesen
if ($action == 'getUser') {
    $userId = $_GET['UserID'] ?? null;

    if ($userId) {
        $stmt = mysqli_prepare($connect, "SELECT * FROM user WHERE UserID = ?");
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result_stmt = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_array($result_stmt);

        if ($user) {
            $result['user'] = array(
                "UserID" => $user['UserID'],
                "Firstname" => $user['Firstname'],
                "Lastname" => $user['Lastname'],
                "Brokername" => $user['Brokername'],
                "Email" => $user['Email'],
                "Password" => $user['Password']
            );
        } else {
            $result['error'] = true;
            $result['message'] = "User not found!";
        }

        mysqli_stmt_close($stmt);
    } else {
        $result['error'] = true;
        $result['message'] = "UserID is required!";
    }
}

// ein neuer User wird hinzugefügt
// es muss noch geprüft werden, ob die Email bereits existiert
if ($action == 'registration') {
    $firstname = $data['firstname'] ?? null;
    $lastname = $data['lastname'] ?? null;
    $brokername = $data['brokername'] ?? null;
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;

    if ($firstname && $lastname && $brokername && $email && $password) {
        $stmt = mysqli_prepare($connect, "INSERT INTO user (Firstname, Lastname, Brokername, Email, Password) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $brokername, $email, $password);
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

// ein User loggt sich ein
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
                "Firstname" => $user['Firstname'],
                "Lastname" => $user['Lastname'],
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

// ein User wird geupdatet
if ($action == 'updateUser') {
    $userid = $_GET['UserID'] ?? null;
    $firstname = $data['firstname'] ?? null;
    $lastname = $data['lastname'] ?? null;
    $brokername = $data['brokername'] ?? null;
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;

    if ($userid) {
        // Abrufen der aktuellen Benutzerdaten
        $stmt = mysqli_prepare($connect, "SELECT * FROM user WHERE UserID = ?");
        mysqli_stmt_bind_param($stmt, "i", $userid);
        mysqli_stmt_execute($stmt);
        $result_stmt = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_array($result_stmt);

        if ($user) {
            // Verwenden Sie die vorhandenen Daten, wenn die neuen Daten nicht ausgefüllt sind
            $firstname = $firstname ?? $user['Firstname'];
            $lastname = $lastname ?? $user['Lastname'];
            $brokername = $brokername ?? $user['Brokername'];
            $email = $email ?? $user['Email'];
            $password = $password ?? $user['Password'];

            // Aktualisieren der Benutzerdaten
            $stmt = mysqli_prepare($connect, "UPDATE user SET Firstname=?, Lastname=?, Brokername=?, Email=?, Password=? WHERE UserID=?");
            mysqli_stmt_bind_param($stmt, "sssssi", $firstname, $lastname, $brokername, $email, $password, $userid);
            $execute = mysqli_stmt_execute($stmt);

            if ($execute) {
                // Abrufen der aktualisierten Benutzerdaten
                $stmt = mysqli_prepare($connect, "SELECT * FROM user WHERE UserID = ?");
                mysqli_stmt_bind_param($stmt, "i", $userid);
                mysqli_stmt_execute($stmt);
                $result_stmt = mysqli_stmt_get_result($stmt);
                $user = mysqli_fetch_array($result_stmt);

                if ($user) {
                    $result['user'] = array(
                        "UserID" => $user['UserID'],
                        "Firstname" => $user['Firstname'],
                        "Lastname" => $user['Lastname'],
                        "Brokername" => $user['Brokername'],
                        "Email" => $user['Email'],
                        "Password" => $user['Password']
                    );
                }

                $result['message'] = "User updated successfully!";
            } else {
                $result['error'] = true;
                $result['message'] = "Failed to update user!";
            }

            mysqli_stmt_close($stmt);
        } else {
            $result['error'] = true;
            $result['message'] = "User not found!";
        }
    } else {
        $result['error'] = true;
        $result['message'] = "UserID is required!";
    }
}

echo json_encode($result);
mysqli_close($connect);
?>