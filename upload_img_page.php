<?php
 define('HOST','127.0.0.1');
 define('USER','root');
 define('PASS','');
 define('DB','comi_db');
 
 $con = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to Connect');
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 $image = $_POST['image'];
 
 
 $sql = "INSERT INTO user_shared_intrest (image) VALUES (?)";
 
 $stmt = mysqli_prepare($con,$sql);
 
 mysqli_stmt_bind_param($stmt,"s",$image);
 mysqli_stmt_execute($stmt);
 
 $check = mysqli_stmt_affected_rows($stmt);
 
 if($check == 1){
 echo "Image Uploaded Successfully";
 }else{
 echo "Error Uploading Image";
 }
 mysqli_close($con);
 }else{
 echo "Error";
 }
 
 
 
 
  if($_SERVER['REQUEST_METHOD']=='GET'){
 $id = $_GET['id'];
 $sql = "select * from user_shared_intrest where id = '$id'";

 
 $r = mysqli_query($con,$sql);
 
 $result = mysqli_fetch_array($r);
 
 header('content-type: image/jpeg');
 
 echo base64_decode($result['image']);
 
 mysqli_close($con);
 
 }else{
 echo "Error";
 }