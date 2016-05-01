<?php
require_once ('../controllers/User_Controller.php');
require_once ('../controllers/Intrest_Controller.php');
require_once ('../config/db_access_interface.php');
$AccessInterface = new db_access_interface();
$UserController = new user_controller();
$IntrestController = new Intrest_Controller();
 
if (isset($_GET['method'])) 
    {
		    $method = $_GET['method'];
		  
		    if ($method == "create_user_account") {
		        $ReturnVal = $UserController->create_user_account($_GET);
		        echo json_encode($ReturnVal);
		    }
                    
                    if ($method == "get_shared_intrest") {
		        $ReturnVal = $IntrestController->get_shared_intrest($_GET);
		        echo json_encode($ReturnVal);
		    }
                    
                    if ($method == "get_selected_image") {
		        $ReturnVal = $IntrestController->get_selected_image($_GET);
              
                       // clean the output buffer
                        ob_clean(); 
                        header('content-type: image/jpeg');
                        echo ($ReturnVal);
		    }
                    
    }
    
 if (isset($_POST['method'])) 
    {
	$method = $_POST['method'];	    
              
        
        
		    if ($method == "create_user_account") {
		        $ReturnVal = $UserController->create_user_account($_POST);
		        print ($ReturnVal);
		    }
                    
                  
		    if ($method == "user_login_check") {
		        $ReturnVal = $UserController->user_login_check($_POST);
		        print ($ReturnVal);
		    }
                    
                    if ($method == "upload_shared_intrest") {
		        $ReturnVal = $IntrestController->upload_shared_intrest($_POST);
		        print ($ReturnVal);
		    }
                    
    }
      
