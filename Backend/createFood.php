<?php
error_reporting(1);
session_start();
date_default_timezone_set('Asia/Bangkok');
include('connection.php');
include('utility.php');

$code = $checkAuth($_SESSION['user']);
$access = $checkAccess($_SESSION['user'], true);
$name = "Veve";
$image = "https://asset.kompas.com/crops/89gV9XIgLw8Tzv2im_h4C9aEjd8=/0x0:993x662/750x500/data/photo/2021/03/27/605ed24c33816.jpg";
$price = 5000;
$time = date('y-m-d H:i:s', time());

try{
    $stmt = $pdo->prepare('SELECT * FROM foods WHERE name = :name');
    $stmt->execute(array(':name' => $name));
    if($stmt->rowCount() < 1){
        $stmt = $pdo->prepare('INSERT INTO foods (name, image, price, create_date) VALUES (:name, :image, :price, :createDate)');
        $stmt->execute(array(':name' => $name, ':image' => $image, ':price' => $price, ':createDate' => $time));
    }else{
        echo "Food Name is already used.";
    }
} catch (PDOException $e){
    echo $e->getMessage();
}
$pdo = null;
?>