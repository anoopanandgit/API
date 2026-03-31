<?php
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: *');
// header('Access-Control-Allow-Headers: *');

// if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     http_response_code(200);
//     exit();
// }
include 'config/connection.php';


function checkStatus()
{
    echo 'Status: OK';
}

function login()
{
    echo 'User logged in';
}

function registerUser($conn)
{
    $request = file_get_contents("php://input");

    $data = json_decode($request);
    // var_dump($data);
    $name = $data->name;
    $email = $data->email;
    $password = $data->password;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $address = $data->address;
    $created_at = date('y-m-d');
    $updated_at = date('y-m-d');
    $st = 1;
    $image = "default.png"; // change it according to your logic

    $query = "INSERT INTO `users`( `name`, `email`, `password`, `address`, `image`, `created`, `updated_at`, `st`) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssss", $name, $email, $hashed_password, $address, $image, $created_at, $updated_at, $st);

    if ($stmt->execute()) {
        $response = ['status' => 1, 'message' => "User registered successfully"];
        // echo "User registered successfully";
    } else {
        $response = ['status' => 0, 'message' => "Error in user registration"];
        // echo "Error in user registration";
    }
    echo json_encode($response);
}

function selectUsers($conn)
{
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

    // echo json_encode($users);

    // echo json_encode([
    //     "status" => "success",
    //     "data" => $users
    // ]);
    // echo 'Users selected';
    // $query = "SELECT * FROM `users` order by `id` desc";
    // $result = $conn->query($query);    
    // $users = $result->fetch_all(MYSQLI_ASSOC);
    //  $users = [];
    // if ($result) {
    //     while ($row = mysqli_fetch_assoc($result)) {
    //         $users[] = $row;
    //     }
    // }
    echo json_encode($users);
}

function selectSingleUser($conn)
{
    echo 'Single user selected';
}

function updateUser($conn)
{
    // echo 'User updated';
    $request = file_get_contents("php://input");

    $data = json_decode($request);
    // var_dump($data);
    $id=$data->id;
    $name = $data->name;
    $email = $data->email;
     // Check if password is null or empty
    $password = $data->password;
   
    $address = $data->address;    
    $updated_at = date('y-m-d');
    $st = 1;
    $image = "default.png"; // change it according to your logic

     if (!empty($password)) {
       
       
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql="UPDATE `users` SET `name`=?,`email`=?,`password`=?,`address`=?,`image`=?,`updated_at`=? WHERE `id`=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("ssssssi",$name,$email,$hashed_password,$address,$image,$updated_at,$id);
    }
    else{
         $response = ['status' => 0, 'message' => "Password is required"];
        echo json_encode($response);
        return;
        $sql="UPDATE `users` SET `name`=?,`email`=?,`address`=?,`image`=?,`updated_at`=? WHERE `id`=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param("sssssi",$name,$email,$address,$image,$updated_at,$id);
    }
   
    if($stmt->execute()){
        $response = ['status' => 1, 'message' => "User updated successfully"];
        echo json_encode($response);

    }

}

function deleteUser($conn)
{
    // echo 'User deleted';
    $sql = "DELETE FROM users WHERE id=?";
    $path = explode('/', $_SERVER['REQUEST_URI']);    
    
    if (isset($path[3]) && is_numeric($path[3])) {       
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $path[3]);
        $stmt->execute();
        $response = ['status' => 1, 'message' => "User deleted successfully"];
    } else {
        $response = ['status' => 0, 'message' => "User ID is required for deletion"];
    }
     echo json_encode($response);

}