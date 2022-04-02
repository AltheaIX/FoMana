<?php
session_start();
date_default_timezone_set('Asia/Bangkok');
include('connection.php');
include('utility.php');

$code = $checkAuth($_SESSION['user']);
$id = $_POST['id'];
$time = date('y-m-d H:i:s', time());

try{
    $stmt = $pdo->prepare("SELECT * FROM foods WHERE id = :id");
    $stmt->execute(array(':id' => $id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($result);
}catch(PDOException $e){
    echo $e->getMessage();
}
$pdo = null;
?>