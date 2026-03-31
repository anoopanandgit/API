<?php

// CORS Headers - must be set FIRST
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'functions/functions.php';
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . "/error_log.txt");


$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case "POST":
        registerUser($conn);
        break;
    case "GET":
           $sql = "SELECT * FROM users";
            $path = explode('/', $_SERVER['REQUEST_URI']);
            // print_r($path);
            //  $path[3]="abcjdgjx";
            
            if (isset($path[3]) && is_numeric($path[3])) {
                $sql .= " WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $path[3]);
                $stmt->execute();
                $result = $stmt->get_result();
                $users = $result->fetch_assoc();
            } else {
                $result = $conn->query($sql);
                if (!$result) {
                    echo json_encode(["error" => $conn->error]);
                    return;
                }

                $users = $result->fetch_all(MYSQLI_ASSOC);
            }
            echo json_encode($users);
        // selectUsers($conn);
        break;
    case "PUT":
        updateUser($conn);
        break;
    case "DELETE":
        deleteUser($conn);
        break;
}







