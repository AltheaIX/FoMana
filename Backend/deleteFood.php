<?php
session_start();
date_default_timezone_set('Asia/Bangkok');
include('connection.php');
include('utility.php');

$code = $checkAuth($_SESSION['user']);
$access = $checkAccess($_SESSION['user'], true);
$id = $_POST['id'];
$time = date('y-m-d H:i:s', time());

try{
    $stmt = $pdo->prepare('SELECT * FROM foods WHERE id = :id');
    $stmt->execute(array(':id' => $id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($stmt->rowCount() > 0){
        $stmt = $pdo->prepare('DELETE FROM foods WHERE id = :id');
        $stmt->execute(array(':id' => $id));
        echo "Food has been deleted!";
    }else{
        echo "Food doesn't exist on the database!";
    }
} catch (PDOException $e){
    echo $e->getMessage();
}
$pdo = null;
?>