<?php
include('connection.php');

$checkAuth = function ($code) use($pdo){
    try{
        $stmt = $pdo->prepare("SELECT * FROM users WHERE security = :security");
        $stmt->execute(array(':security' => $code));
        $auth = $stmt->rowCount();
        if($auth < 1){
            return "Non-Auth";
            exit();
        }
    }catch (PDOException $e){
        echo $e->getMessage();
    }
};

$checkAccess = function($code, $redirect) use($pdo){
    try{
        $stmt = $pdo->prepare("SELECT * FROM users WHERE security = :security");
        $stmt->execute(array(':security' => $code));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result['access'] !== "Admin"){
            $checkRed = ($redirect == true) ? header('Location: home.php') : "User";
            return $checkRed;
        }
        else{
            return "Admin";
        }
    }catch (PDOException $e){
        echo $e->getMessage();
    }
};

$getUsername = function ($security) use($pdo){
    try{
        $stmt = $pdo->prepare("SELECT * FROM users WHERE security = :security");
        $stmt->execute(array(':security' => $security));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['username'];
    }catch(PDOException $e){
        echo $e->getMessage();
    }
};

$totalRowFoods = function() use($pdo){
    try{
        $stmt = $pdo->prepare("SELECT * FROM foods");
        $stmt->execute();
        echo $stmt->rowCount();
    }catch(PDOException $e){
        echo $e->getMessage();
    }
};

$imageToBase64 = function($url){
    $image = "../" . $url;
    $imageData = base64_encode(file_get_contents($image));
    $mime = mime_content_type($image);
    $convert = "data: " . $mime . ";base64," . $imageData;
    echo $convert;
};
?>