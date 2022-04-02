<?php
session_start();
date_default_timezone_set('Asia/Bangkok');
include('connection.php');
include('utility.php');

$code = $checkAuth($_SESSION['user']);
$access = $checkAccess($_SESSION['user'], true);
$time = date('y-m-d H:i:s', time());

$reff = $_SERVER['HTTP_REFERER'];
$urlParse = parse_url($reff, PHP_URL_QUERY);
$strParse = parse_str($urlParse, $parse);
$id = ($_POST['id'] == $parse['id']) ? $parse['id'] : exit();
$name = $_POST['name'];
$image = $_POST['filename'];
$price = $_POST['price'];

try{
    $stmt = $pdo->prepare('SELECT * FROM foods WHERE id = :id');
    $stmt->execute(array(':id' => $id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($stmt->rowCount() > 0){
        $stmt = $pdo->prepare('UPDATE foods SET name = :name, image = :image, price = :price, last_updated = :last_update WHERE id = :id');
        $stmt->execute(array(':name' => $name, ':image' => $image, ':price' => $price, ':last_update' => $time, ':id' => $result['id']));
        echo "Food updated!";
    }else{
        echo "Food doesn't exist on the database!";
    }
} catch (PDOException $e){
    echo $e->getMessage();
}
$pdo = null;
?>