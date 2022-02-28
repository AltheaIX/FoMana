<?php
include('connection.php');

$checkAuth = function ($code) use($pdo){
    try{
        $stmt = $pdo->prepare("SELECT * FROM users WHERE security = :security");
        $stmt->execute(array(':security' => $code));
        $auth = $stmt->rowCount();
        if($auth < 1){
            exit();
        }
    }catch (PDOException $e){
        echo $e->getMessage();
    }
};

$imageToBase64 = function($url){
    $image = $url;
    $imageData = base64_encode(file_get_contents($image));
    $mime = mime_content_type("https://i.pinimg.com/originals/1c/54/f7/1c54f7b06d7723c21afc5035bf88a5ef.png");
    $convert = "data: " . $mime . ";base64," . $imageData;
    echo $convert;
};

$checkAccess = function($code) use($pdo){
    try{
        $stmt = $pdo->prepare("SELECT * FROM users WHERE security = :security");
        $stmt->execute(array(':security' => $code));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result['access'] !== "Admin"){
            exit();
        }
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}
?>