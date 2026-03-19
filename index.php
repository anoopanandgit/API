<?php


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
        selectUsers();
        break;
    case "PUT":
        updateUser();
        break;
    case "DELETE":
        deleteUser();
        break;


}







