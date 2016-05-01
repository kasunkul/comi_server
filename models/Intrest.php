<?php

require_once ('../config/ConnectionManager.php');
require_once ('../config/db_access_interface.php');

    class intrest
{
        
         private $id = '';
         private $image = '';
         private $name = '';
         private $caption = '';
                 
         
         
           public function upload_shared_intrest($image,$name,$caption){
                 $dbObject = new db_access_interface();
                 $dbObject2 = new ConnectionManager();
              header('Content-Type: application/json');
           
            
                
                    $db = $dbObject->connect();
 
                     $sQuery = "INSERT INTO user_shared_intrest(
                                        image,
                                        name,
                                        caption
                                    )
                                    VALUE(
                                        '".$image."',
                                        '".$name."',
                                        '".$caption."'
                                    )";

                     $result = $db->query($sQuery);
                     
                    
                                        
                     
                     if(mysqli_affected_rows($db) > 0){
                        $JSONReponse[] = array('response'=>'1');
                     }
                     else{
                        $JSONReponse[] = array('response'=>'0');
                     }
       
                     return ($JSONReponse);

                     
          
            }
            
            function get_shared_intrest(){
                 
                
                
                  $dbObject = new db_access_interface();
                  $dbObject2 = new ConnectionManager();
              header('Content-Type: application/json');
           
            
                
                     $db = $dbObject->connect();
 
                     $sQuery = "select * from user_shared_intrest";

                     $resultSelectAll = $db->query($sQuery);
                     
                    
                     $i=0;
                     
                    while($result = mysqli_fetch_array($resultSelectAll)) {

                        $url = "http://192.168.8.101/comi_server/?method=get_selected_image&id=";
                        
                        $url.=$result['id'];
                        
                        $JSONReponse[] = array('name'=>$result['name'],'image'=>$url);
                        
                        $i++;
                           
                    }          

                    
                     if($i == 0){
                         $JSONReponse[] = array('response'=>'0');
                     }
       
                     return ($JSONReponse);
                
            }
            
            function get_selected_image($id){
              
                  $dbObject = new db_access_interface();
                  $dbObject2 = new ConnectionManager();
                  $dbOn = $dbObject->connect2();
                   
                     $db = $dbObject->connect();
 
                     $sQuery = "select * from user_shared_intrest WHERE id = '".$id."'";

                     $resultSelect = $db->query($sQuery);
                    
                     $rowcol= $dbObject->Convert_To_ARRAY($resultSelect);
                
               return base64_decode($rowcol[0]['image']);
               
            }
                     
}
