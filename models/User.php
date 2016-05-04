<?php
require_once ('../config/ConnectionManager.php');
require_once ('../config/db_access_interface.php');

    class user
{
        
        private $dbObject;
	private $username="";
	private $fname="";
	private $lname="";
	private $dob="";
	private $email="";
	private $profile_pic="";

   
        /**
         * function checks if email exists or username exists return true if exist
         * @param string $email email of user
         * @param string $password password of user
         */
	public function user_exists($username,$password){
            
           $email_exist = self::existing_email($password);
           $username_exist = self::existing_username($username);   
           
           if($email_exist || $username_exist){
               return boolval(true);
           }else{
               return boolval(false);
           }
           
        }
        /**
         * function checks if email exists and return true if exist
         * @param string $email email of user
         */
        public function existing_email($email){
                     $dbObject = new db_access_interface();
                     $dbObject2 = new ConnectionManager();
             
             
                     $db = $dbObject->connect();
 
                     $sQuery = "SELECT COUNT(*) as count FROM `user_table` WHERE user_table.email = '".$email."'";


                     $result = $db->query($sQuery);
                     $dbOn = $dbObject->connect2();
                     $rowcol= $dbObject->Convert_To_ARRAY($result);
                     
                     if($rowcol[0]['count'] == 0){
                         
                         return boolval(false);
                     }  else {
                          return boolval(true);
                     }

	}
         /**
         * function checks if username exists and return true if exist
         * @param string $username username of user
         */
        public function existing_username($username){
            
                     $dbObject = new db_access_interface();
                     $dbObject2 = new ConnectionManager();
                     $db = $dbObject->connect();
 
                     $sQuery = "SELECT COUNT(*) as count FROM `user_table` WHERE user_table.username = '".$username."'";


                     $result = $db->query($sQuery);
                     $dbOn = $dbObject->connect2();
                     $rowcol= $dbObject->Convert_To_ARRAY($result);
                     
                     
                     if($rowcol[0]['count'] == 0){
                         
                         return boolval(false);
                     }  else {
                          return boolval(true);
                     }

	}
        /**
         * 
         * @param type $username
         * @param type $password
         * @param type $fname
         * @param type $lname
         * @param type $dob
         * @param type $email
         * @param type $contact
         * @return 1 -'success',-1 - 'email or username already exists',0 - 'server error'
         */
        public function create_user_account($username,$password,$fname,$lname,$dob,$email,$contact){
                 $dbObject = new db_access_interface();
                 $dbObject2 = new ConnectionManager();
              header('Content-Type: application/json');
            $user_exists = self::user_exists($username,$email);
            
            if(!$user_exists){
                
                    $db = $dbObject->connect();
 
                     $sQuery = "INSERT INTO user_table(
                                        username,
                                        password,
                                        fname,
                                        lname,
                                        dob,
                                        email,
                                        contact
                                    )
                                    VALUE(
                                        '".$username."',
                                        '".$password."',
                                        '".$fname."',
                                        '".$lname."',
                                        '".$dob."',
                                        '".$email."',
                                        '".$contact."'
                                    )";

                     $result = $db->query($sQuery);
                     
                    
                                        
                     
                     if(mysqli_affected_rows($db) > 0){
                        $JSONReponse[] = array('response'=>'1');
                     }
                     else{
                        $JSONReponse[] = array('response'=>'0');
                     }
       
                     return ($JSONReponse);

                     
            }else{
                  $JSONReponse[] = array('response'=>'-1');
                  return $JSONReponse ;
            }
                     
        }
        
          public function user_login_check($email,$password){
                 $dbObject = new db_access_interface();
                 $dbObject2 = new ConnectionManager();
             
            $user_email_exists = self::existing_email($email);
            
            if($user_email_exists){
                
                    $db = $dbObject->connect();
 
                    $CheckQuery = "SELECT COUNT(*) as row_count
                                FROM `user_table` 
                                WHERE user_table.email = '".$email."' AND user_table.password = '".$password."'";
                     
                     $result = $db->query($CheckQuery);
                     $rowcol= $dbObject->Convert_To_ARRAY($result);
                    
                        if($rowcol[0]['row_count']!= 0){
                            
                                $sQuery = "SELECT user_table.username, user_table.fname,user_table.email,user_table.contact 
                                            FROM `user_table` 
                                            WHERE user_table.email = '".$email."' AND user_table.password = '".$password."'";
                                
                                $result = $db->query($sQuery);
                                $rowcol = $dbObject->Convert_To_ARRAY($result);

                                $JSONReponse[] = array('response'=>'1');
                                $JSONReponse[] = array('username'=>$rowcol[0]['username']);
                                $JSONReponse[] = array('username'=>$rowcol[0]['fname']);
                                
                        }else{
                             $JSONReponse[] = array('response'=>'0');
                        }
                             return $JSONReponse ;
                   
            }else{
                  $JSONReponse[] = array('response'=>'-2');
                  return $JSONReponse ;
            }
                     
        }
        
         public function get_all_user_details($email){
            
                     $dbObject = new db_access_interface();
                     $dbObject2 = new ConnectionManager();
                     $db = $dbObject->connect();
 
                     $sQuery = "SELECT user_table.id,
                                user_table.email,
                                user_table.dob,
                                user_table.contact,
                                user_table.flag,
                                user_table.username,
                                CONCAT(user_table.fname,' ',user_table.lname) as name
                                FROM `user_table` 
                                WHERE user_table.email = '".$email."'";


                     $result = $db->query($sQuery);
                     $dbOn = $dbObject->connect2();
                     $rowcol= $dbObject->Convert_To_ARRAY($result);
                     
                     
                     if($result->num_rows == 0){
                         
                           $JSONReponse[] = array('response'=>'0');
                             
                     }  else {
                            $JSONReponse[] = array('response'=>'1',
                                                    'email'=>$rowcol[0]['email'],
                                                    'dob'=>$rowcol[0]['dob'],
                                                    'contact'=>$rowcol[0]['contact'],
                                                    'flag'=>$rowcol[0]['flag'],
                                                    'username'=>$rowcol[0]['username'],
                                                    'name'=>$rowcol[0]['name']);
                     }
                        
                     return $JSONReponse;
	}
        
        

}