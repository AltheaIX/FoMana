<?php
include('utility.php');

if(isset($_FILES['file']['tmp_name'])){
   $filename = $_FILES['file']['name'];

   // Change this with your image upload location!
   $rootDir = $_SERVER['DOCUMENT_ROOT']."/FoMana/";
   $uploadDir = "Uploads/".$filename;
   $dir = $rootDir . $uploadDir;

   $ext = array("jpg","gif","jpeg","png");
   $imageFileType = strtolower(pathinfo($dir,PATHINFO_EXTENSION));
   if(in_array(strtolower($imageFileType), $ext)) {
      if(move_uploaded_file($_FILES['file']['tmp_name'],$dir)){
          echo $uploadDir;
      }
      else{
          echo "Upload failed!";
      }
   }
   exit();
}