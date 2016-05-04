<?php

require_once ('../config/ConnectionManager.php');
require_once ('../config/db_access_interface.php');

    class intrest
{
        
         private $id = '';
         private $image = '';
         private $name = '';
         private $caption = '';
           
         
         
           public function upload_shared_intrest($image,$name,$caption,$intrest,$intrest_type,$capacity){
                 $dbObject = new db_access_interface();
                 $dbObject2 = new ConnectionManager();
              header('Content-Type: application/json');
              
                 $db = $dbObject->connect();
              
              
                     $sINTQuery = "select id from intrest_category WHERE cat_name = '".$intrest."'";

                     $resultSelect = $db->query($sINTQuery);
                    
                     $Intrestsel= $dbObject->Convert_To_ARRAY($resultSelect);
                     
                     
                     
                     $sQueryType = "select id from intrest_type WHERE type_name = '".$intrest_type."'";

                     $resultSelect = $db->query($sQueryType);
                    
                     $intresttypeSel = $dbObject->Convert_To_ARRAY($resultSelect);
                     
                                 
                   
 
                     $sQuery = "INSERT INTO user_shared_intrest(
                                        image,
                                        name,
                                        caption,
                                        flag,
                                        intrest_type,
                                        intrest_category,
                                        capacity
                                    )
                                    VALUE(
                                        '".$image."',
                                        '".$name."',
                                        '".$caption."',
                                        '1',
                                        '".$intresttypeSel[0]['id']."',
                                        '".$Intrestsel[0]['id']."',
                                        '".$capacity."'
                                            
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
 
                     $sQuery = "select * from user_shared_intrest WHERE intrest_type = 2";

                     $resultSelectAll = $db->query($sQuery);
                     
                    
                     $i=0;
                     
                    while($result = mysqli_fetch_array($resultSelectAll)) {

                        $url = "http://192.168.8.101/comi_server/?method=get_selected_image&id=";
                        
                        $url.=$result['id'];
                        
                        $caption = $result['caption'];
                        $ID = $result['id'];
                        
                        $temp_string = $result['name']."^".$caption;
                        
                        $JSONReponse[] = array('name'=>$temp_string,'image'=>$url);
                        
                        $i++;
                           
                    }          

                    
                     if($i == 0){
                         $JSONReponse[] = array('response'=>'0');
                     }
       
                     return ($JSONReponse);
                
            }
            
            
            
             function get_intrest_type($intrest_id){
                 
                
                
                  $dbObject = new db_access_interface();
                  $dbObject2 = new ConnectionManager();
                  header('Content-Type: application/json');
           
            
                
                     $db = $dbObject->connect();
 
                     $sQuery = "select intrest_type from user_shared_intrest WHERE id = ".$intrest_id."";

                     $resultSelectAll = $db->query($sQuery);
                     
                 
                     if($resultSelectAll->num_rows > 0){
                         
                         $Intrestsel= $dbObject->Convert_To_ARRAY($resultSelectAll);
                         $JSONReponse[] = array('response'=>'1','type'=>$Intrestsel[0]['intrest_type']);
                     }
                     else{
                         $JSONReponse[] = array('response'=>'0');
                     }
       
                     return ($JSONReponse);
                
            }
            
            
               function get_shared_activities(){
                 
                
                
                  $dbObject = new db_access_interface();
                  $dbObject2 = new ConnectionManager();
              header('Content-Type: application/json');
           
            
                
                     $db = $dbObject->connect();
 
                     $sQuery = "select * from user_shared_intrest WHERE intrest_type = 1";

                     $resultSelectAll = $db->query($sQuery);
                     
                    
                     $i=0;
                     
                    while($result = mysqli_fetch_array($resultSelectAll)) {

                        $url = "http://192.168.8.101/comi_server/?method=get_selected_image&id=";
                        
                        $url.=$result['id'];
                        
                        $caption = $result['caption'];
                        $ID = $result['id'];
                        
                        $temp_string = $result['name']."^".$caption;
                        
                        $JSONReponse[] = array('name'=>$temp_string,'image'=>$url);
                        
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
            
            
            function get_all_intrest_details($int_id){
                 
                
                    $dbObject = new db_access_interface();
                    $dbObject2 = new ConnectionManager();
               
              
                    $db = $dbObject->connect();
                   

                     $resultSelect = $db->query("SELECT * FROM user_shared_intrest WHERE id = '".$int_id."'");
                    
                     $Intrestsel= $dbObject->Convert_To_ARRAY($resultSelect);
                     
                       header('Content-Type: application/json');
                       
                       
                     if ($resultSelect->num_rows > 0) {
                 
                         
                         
                        $JSONReponse[] = array('response'=>'1');
                        $JSONReponse[] = array('id'=>$Intrestsel[0]['id']);
                        $JSONReponse[] = array('name'=>$Intrestsel[0]['name']);
                        $JSONReponse[] = array('caption'=>$Intrestsel[0]['caption']);
                        
                        $start_date = new DateTime($Intrestsel[0]['shared_date']);
                       

                        $now = new DateTime('now');
                        $now->setTimezone(new DateTimeZone('Asia/Colombo'));
                        $str_server_now = $now->format('Y-m-d H:i:s');
                        
                        
                        $var = $str_server_now; 

                        $since_start = $start_date->diff(new DateTime($str_server_now));
                      
                        
                        
                        if(intval($since_start->h) > 24){
                            $temp = ($since_start->h)."days";
                             $JSONReponse[] = array('shared_date'=>$temp);
                        }else if(intval($since_start->i) > 60){
                             $temp = ($since_start->i)."hours";
                             $JSONReponse[] = array('shared_date'=>$temp);
                             
                        }else if(intval($since_start->i) <= 60 && intval($since_start->i) > 0 ){
                             $temp = ($since_start->i)."mins";
                             $JSONReponse[] = array('shared_date'=>$temp);
                        }
                        else{
                             $temp = ($since_start->s)."seconds";
                             $JSONReponse[] = array('shared_date'=>$temp);
                        }
                       
                      
                        
                        $JSONReponse[] = array('intrest_type'=>$Intrestsel[0]['intrest_type']);
                        $JSONReponse[] = array('intrest_category'=>$Intrestsel[0]['intrest_category']);
                        
                          
                    }
                    else{
                     
                        $JSONReponse[] = array('response'=>'0');
                       
                    }
                    
                    return ($JSONReponse);
                    
            }
            
            
            public function make_intrest_like($intrest_id,$user_name){
                 $dbObject = new db_access_interface();
                 $dbObject2 = new ConnectionManager();
                 header('Content-Type: application/json');
              
                 $db = $dbObject->connect();
              
                 
                                 $flagQuery = "SELECT id 
                                                    FROM user_table
                                                    WHERE username = '".$user_name."'";
                                  $result = $db->query($flagQuery);
                                  $usernameID= $dbObject->Convert_To_ARRAY($result);
                 
                 
                 $user_id = $usernameID[0]['id'];
                 
                 
                    $checkQuery = "SELECT * 
                                FROM user_liked_intrest
                                WHERE user_id = '".$user_id."' AND intrest_id = '".$intrest_id."'";
                    $result = $db->query($checkQuery);    
                 
                    
                          
                     if ($result->num_rows > 0) {

                                  $flagQuery = "SELECT * 
                                                    FROM user_liked_intrest
                                                    WHERE user_id = '".$user_id."' AND intrest_id = '".$intrest_id."'";
                                  $result = $db->query($flagQuery);
                                  $IntLike= $dbObject->Convert_To_ARRAY($result);
                                  
                                  if($IntLike[0]['flag'] == 1){
                                       $flagQuery = "UPDATE user_liked_intrest 
                                                     SET flag = 0
                                                     WHERE user_id = '".$user_id."' AND intrest_id = '".$intrest_id."'";
                                       $result = $db->query($flagQuery);
                                  }
                                  else{
                                        $flagQuery = "UPDATE user_liked_intrest 
                                                     SET flag = 1
                                                     WHERE user_id = '".$user_id."' AND intrest_id = '".$intrest_id."'";
                                         $result = $db->query($flagQuery);
                                  }
                     
                     }else{
                           $sQuery = "INSERT INTO user_liked_intrest(
                                                       user_id,
                                                       intrest_id,
                                                       flag
                                                   )
                                                   VALUE(
                                                       '".$user_id."',
                                                       '".$intrest_id."',
                                                       '1'
                                                   )";

                                    $result = $db->query($sQuery); 
                     }
                                        
                     
                     if(mysqli_affected_rows($db) > 0){
                        $JSONReponse[] = array('response'=>'1');
                     }
                     else{
                        $JSONReponse[] = array('response'=>'0');
                     }
       
                     return ($JSONReponse);

                     
          
            }
            
            
            public function join_activity_action($intrest_id,$user_name){
                 $dbObject = new db_access_interface();
                 $dbObject2 = new ConnectionManager();
                 header('Content-Type: application/json');
              
                 $db = $dbObject->connect();
              
                 
                                 $flagQuery = "SELECT id 
                                                    FROM user_table
                                                    WHERE username = '".$user_name."'";
                                  $result = $db->query($flagQuery);
                                  $usernameID= $dbObject->Convert_To_ARRAY($result);
                 
                 
                 $user_id = $usernameID[0]['id'];
                 
                 
                    $checkQuery = "SELECT * 
                                FROM user_joined_intrest
                                WHERE user_id = '".$user_id."' AND intrest_id = '".$intrest_id."'";
                    $result = $db->query($checkQuery);    
                 
                    
                          
                     if ($result->num_rows > 0) {

                                  $flagQuery = "SELECT * 
                                                    FROM user_joined_intrest
                                                    WHERE user_id = '".$user_id."' AND intrest_id = '".$intrest_id."'";
                                  $result = $db->query($flagQuery);
                                  $IntLike= $dbObject->Convert_To_ARRAY($result);
                                  
                                  if($IntLike[0]['flag'] == 1){
                                       $flagQuery = "UPDATE user_joined_intrest 
                                                     SET flag = 0,updated_date = now()
                                                     WHERE user_id = '".$user_id."' AND intrest_id = '".$intrest_id."'";
                                       $result = $db->query($flagQuery);
                                  }
                                  else{
                                        $flagQuery = "UPDATE user_joined_intrest 
                                                     SET flag = 1,updated_date = now()
                                                     WHERE user_id = '".$user_id."' AND intrest_id = '".$intrest_id."'";
                                         $result = $db->query($flagQuery);
                                  }
                     
                     }else{
                           $sQuery = "INSERT INTO user_joined_intrest(
                                                       user_id,
                                                       intrest_id,
                                                       flag,
                                                       joined_date
                                                   )
                                                   VALUE(
                                                       '".$user_id."',
                                                       '".$intrest_id."',
                                                       '1',
                                                       now()
                                                   )";

                                    $result = $db->query($sQuery); 
                     }
                                        
                     
                     if(mysqli_affected_rows($db) > 0){
                        $JSONReponse[] = array('response'=>'1');
                     }
                     else{
                        $JSONReponse[] = array('response'=>'0');
                     }
       
                     return ($JSONReponse);

                     
          
            }
            
            public function get_like_counts($intrest_id){
                
                 $dbObject = new db_access_interface();
                 $dbObject2 = new ConnectionManager();
                 header('Content-Type: application/json');
              
                 $db = $dbObject->connect();
              
                    $checkQuery = "SELECT COUNT(*) as count
                                FROM user_liked_intrest
                                WHERE flag = 1 AND intrest_id = ".$intrest_id."";
                    $result = $db->query($checkQuery);   
                   
                   
                     if($result->num_rows > 0){
                        $IntLikeCount= $dbObject->Convert_To_ARRAY($result);
                        $JSONReponse[] = array('response'=>'1','likecount'=> $IntLikeCount[0]['count']);
                        
                     }
                     else{
                        $JSONReponse[] = array('response'=>'0');
                     }
       
                     return ($JSONReponse);
            }
            
            
            
            public function get_like_status($intrest_id,$username){
                
                 $dbObject = new db_access_interface();
                 $dbObject2 = new ConnectionManager();
                 header('Content-Type: application/json');
              
                 $db = $dbObject->connect();
              
                    $checkQuery = "SELECT id
                                FROM user_table
                                WHERE username = '".$username."'";
                    $result = $db->query($checkQuery);   
                   
                   
                     if($result->num_rows > 0){
                        
                        $Int= $dbObject->Convert_To_ARRAY($result);
                        
                        
                           $checkQuery = "SELECT flag
                                FROM user_liked_intrest
                                WHERE user_id = '".$Int[0]['id']."' AND intrest_id = '".$intrest_id."'";
                             $results = $db->query($checkQuery);  
                             
                              if($results->num_rows > 0){
                             
                                     $IntFlag= $dbObject->Convert_To_ARRAY($results);
                        
                                     $JSONReponse[] = array('response'=>'1','status'=> $IntFlag[0]['flag']);
                              }else{
                                      $JSONReponse[] = array('response'=>'0','status'=> '0');
                              }
                             
                     }
                     else{
                        $JSONReponse[] = array('response'=>'0','status'=> '0');
                     }
       
                     return ($JSONReponse);
            }
            
            
            public function get_join_status($intrest_id,$username){
                
                 $dbObject = new db_access_interface();
                 $dbObject2 = new ConnectionManager();
                 header('Content-Type: application/json');
              
                 $db = $dbObject->connect();
              
                    $checkQuery = "SELECT id
                                FROM user_table
                                WHERE username = '".$username."'";
                    $result = $db->query($checkQuery);   
                   
                   
                     if($result->num_rows > 0){
                        
                        $Int= $dbObject->Convert_To_ARRAY($result);
                        
                        
                           $checkQuery = "SELECT flag
                                FROM user_joined_intrest
                                WHERE user_id = '".$Int[0]['id']."' AND intrest_id = '".$intrest_id."'";
                             $results = $db->query($checkQuery);  
                             
                              if($results->num_rows > 0){
                             
                                     $IntFlag= $dbObject->Convert_To_ARRAY($results);
                        
                                     $JSONReponse[] = array('response'=>'1','status'=> $IntFlag[0]['flag']);
                              }else{
                                      $JSONReponse[] = array('response'=>'0','status'=> '0');
                              }
                             
                     }
                     else{
                        $JSONReponse[] = array('response'=>'0','status'=> '0');
                     }
       
                     return ($JSONReponse);
            }
            
}           
                     

