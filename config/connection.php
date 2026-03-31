<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");
// header("Access-Control-Allow-Headers: *");
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
// header("Access-Control-Allow-Credentials: true");
date_default_timezone_set('Asia/Kolkata'); // optional


$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'reacts';

// Tell PHP to write all error_log() messages to this file
$logFile = __DIR__ . "/error_log";
ini_set("log_errors", 1);
ini_set("error_log", $logFile);

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    $errorMessage = "[" . date('Y-m-d H:i:s') . "] MYSQLI CONNECTION ERROR: " . mysqli_connect_error() . PHP_EOL;
    file_put_contents($logFile, $errorMessage, FILE_APPEND);

    // Generic message to user (safe)
    die("Database connection failed. Please try again later.");
}
