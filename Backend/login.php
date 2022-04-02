<?php
error_reporting(1);
session_start();
date_default_timezone_set('Asia/Bangkok');
include('connection.php');

$username = $_POST['username'];
$password = md5($_POST['password']);
$time = date('y-m-d H:i:s', time());

try{
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username and password = :password');
    $stmt->execute(array(':username' => $username, ':password' => $password));
    $count = $stmt->rowCount();
    if($count > 0){
        // Modify $security with your own algorithm.
        $security = md5("$username$password$time");
        $stmt = $pdo->prepare('UPDATE users SET security = :security, last_login = :time WHERE username = :username');
        $stmt->execute(array(':time' => $time, ':username' => $username, ':security' => $security));
        $_SESSION['user'] = $security;
        echo "Login Success.";
    }
    else{
        echo "Incorrect username or password. Try again.";
    }
}catch (PDOException $e){
    echo $e->getMessage();
}
$pdo = null;
?>