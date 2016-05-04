<?php
include('../models/User.php');
$User = new user();
   
class user_controller {
     
   
    
    function create_user_account($data){
        
        $username ="";
        $password = "";
        $lname= "";
        $dob= "";
        $email = "";
        $contact = "";
        
        extract($data);
        
        $User = User::create_user_account($username,$password,$fname,$lname,$dob,$email,$contact);
               
        return json_encode($User);
    }
        
    function user_login_check($data){
        
        $email = "";
        $password = "";
        
        extract($data);
        
        $User = User::user_login_check($email,$password);
               
        return json_encode($User);
    }
    
     function get_all_user_details($data){
        
        $Email = "";
        
        extract($data);
        
        $User = User::get_all_user_details($Email);
               
        return json_encode($User);
    }

    }
?>

