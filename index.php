<?php
include("config/db_access_interface.php");
$interface = new db_access_interface();
$interface->get_user_request_log($_SERVER);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//
//echo "<!DOCTYPE html> 
//  <html> 
//     <head> 
//        <meta charset='utf-8'> 
//        <title>COMI</title>
//    
//     </head>
// <body>
//    <div class='box'>
//      <label> Welcome to comi_server Please wait....</label>
//    </div>
// </body>
//  </html>";



$method = $_SERVER['REQUEST_METHOD'];


$data1 = "";
$data2 = "";

foreach($_POST as $key => $value){
 $data2 .= $value;
}
foreach($_GET as $key => $value){
 $data1 .= $value;
}






if ($method == 'POST') {
    $data2 = "post";
    $interface->save_request_data_log($data2);
    $path = "routing/main_routing.php";
    print ($interface->httpPost($path,$_POST));
    
    
} elseif ($method == 'GET') {
       $data1 = $_POST['method'];
    $interface->save_request_data_log($data1);
    $path = "routing/main_routing.php";
    echo $interface->redirect_get($path);
    
    
}else {
      header("Location:./".$redirect_path."?". $_SERVER['QUERY_STRING']);
}