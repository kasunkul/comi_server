<?php
include('../models/Intrest.php');
$Intrest = new Intrest();
class Intrest_Controller{
    
    
     function upload_shared_intrest($data){
        
        $image ="";
        $name ="";
        $caption ="";
        $intrest = "";
        $intrest_type = "";
        $capacity = "";
        
        extract($data);
        
        $Intrest = Intrest::upload_shared_intrest($image,$name,$caption,$intrest,$intrest_type,$capacity);
               
        return json_encode($Intrest);
    }
    
     function get_shared_intrest($data){
         
        extract($data);
        
        $Result = Intrest::get_shared_intrest();
               
        return ($Result);
    }
    
      function get_shared_activities($data){
         
        extract($data);
        
        $Result = Intrest::get_shared_activities();
               
        return ($Result);
    }
    
    
    
     function get_selected_image($data){
         
        $id = ""; 
          
        extract($data);
        
        $Result = Intrest::get_selected_image($id);
              
        return ($Result);
    }
    
       function get_all_intrest_detail($data){

        $Result = Intrest::get_all_intrest_details($data);
              
        return json_encode($Result);
    }
    
      function make_intrest_like($data){

          $intrest_id = "";
          $user_id = "";
          extract($data);
          
          
        $Result = Intrest::make_intrest_like($intrest_id,$user_id);
              
        return json_encode($Result);
    }
    
    function join_activity_action($data){

          $intrest_id = "";
          $user_id = "";
          extract($data);
          
          
        $Result = Intrest::join_activity_action($intrest_id,$user_id);
              
        return json_encode($Result);
    }
    
     function get_like_count($data){

        $Result = Intrest::get_like_counts($data);
              
        return json_encode($Result);
    }
    
    
    
    
     function get_like_status($data){

          $intrest_id = "";
          $username = "";
          extract($data);
          
          
        $Result = Intrest::get_like_status($intrest_id,$username);
              
        return json_encode($Result);
    }
    
     function get_join_status($data){

          $intrest_id = "";
          $username = "";
          extract($data);
          
          
        $Result = Intrest::get_join_status($intrest_id,$username);
              
        return json_encode($Result);
    }
    
     function get_intrest_type($data){

          $intrest_id = "";
          extract($data);
          
          
        $Result = Intrest::get_intrest_type($intrest_id);
              
        return json_encode($Result);
    }
    
}
?>