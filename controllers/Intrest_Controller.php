<?php
include('../models/Intrest.php');
$Intrest = new Intrest();
class Intrest_Controller{
    
    
     function upload_shared_intrest($data){
        
        $image ="";
        $name ="";
        $caption ="";
        
        extract($data);
        
        $Intrest = Intrest::upload_shared_intrest($image,$name,$caption);
               
        return json_encode($Intrest);
    }
    
     function get_shared_intrest($data){
         
        extract($data);
        
        $Result = Intrest::get_shared_intrest();
               
        return ($Result);
    }
    
    
     function get_selected_image($data){
         
        $id = ""; 
          
        extract($data);
        
        $Result = Intrest::get_selected_image($id);
              
        return ($Result);
    }
    
    
    
    
}
?>