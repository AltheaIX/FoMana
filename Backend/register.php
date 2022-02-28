<?php
date_default_timezone_set('Asia/Bangkok');
include('connection.php');

$username = $_GET['username'];
$password = md5($_GET['password']);
$time = date('y-m-d H:i:s', time());

try{
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(array(':username' => $username));
    $count = $stmt->rowCount();
    if($count < 1 && (strlen($username) >= 5)){
        $stmt = $pdo->prepare("INSERT INTO users (username, password, register_date) VALUES (:username, :password, :time)");
        $stmt->execute(array(':username' => $username, ':password' => $password, ':time' => $time));
        echo "Register success. You can login now";
    }
    else if(strlen($username) < 5){
        echo "Username need to be higher or equals with 5.";
    }
    else{
        echo "Username already taken. Try to use another name.";
    }
}catch(PDOException $e){
    echo $e->getMessage();
}
$pdo = null;
?>