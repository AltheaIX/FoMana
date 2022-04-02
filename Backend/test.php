<?php
session_start();

include('connection.php');
include('utility.php');

$stmt = $pdo->prepare("SELECT * FROM foods");
$stmt->execute();
echo $stmt->rowCount();
?>