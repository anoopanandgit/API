<?php

include 'config/connection.php';


function checkStatus(){
    echo 'Status: OK';
}

function login(){
    echo 'User logged in';
}

function registerUser($conn){
    $request =file_get_contents("php://input");
   
    $data=json_decode($request);
    // var_dump($data);
    $name=$data->name;
    $email=$data->email;
    $password= $data->password;
    $hashed_password= password_hash($password, PASSWORD_BCRYPT);
    $address=$data->address;
    $created_at=date('y-m-d');
    $updated_at=date('y-m-d');
    $st=1;
    $image="default.png"; // change it according to your logic

    $query="INSERT INTO `users`( `name`, `email`, `password`, `address`, `image`, `created`, `updated_at`, `st`) VALUES (?,?,?,?,?,?,?,?)";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("ssssssss",$name,$email,$hashed_password,$address,$image,$created_at,$updated_at,$st);

    if($stmt->execute()){
        echo "User registered successfully";
    }
    else{
        echo "Error in user registration";
    }
}

function selectUsers(){
    echo 'Users selected';
}

function selectSingleUser(){
    echo 'Single user selected';
}

function updateUser(){
    echo 'User updated';
}

function deleteUser(){
    echo 'User deleted';
}