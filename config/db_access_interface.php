<?php
    class db_access_interface
{
        function connect() {
            require_once("ConnectionManager.php");
            $newDb = new ConnectionManager();
            $newDb->getConnection();
            return $newDb->db;
        }
      
        function connect2() {
            require_once("ConnectionManager.php");
            $newDb = new ConnectionManager();
            return $newDb;
        }

        function flush($result, $db_connection) {
            mysql_free_result($result);
            mysql_close($db_connection);
        }

        function getDate() {
            $today = date("Y-m-d h:i:s");
            return $today;
        }
        public function Convert_To_ARRAY($result) {
                $array = array();
                            while($row = $result->fetch_assoc())
                            {
                                         $array[] = $row;
                            }
                 return $array;
        }
 
        function redirect_get($redirect_path) {
            ob_start();
            header("Location:./".$redirect_path."?". $_SERVER['QUERY_STRING']);
            ob_end_flush();
            die();
        }
        
        function redirect_post(){
            $ch = curl_init("http://127.0.0.1/comi_server/?");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
        }
          function httpPost($rel_path, $data)
            {
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => 'http://localhost:80/comi_server/'.$rel_path,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_FOLLOWLOCATION => true
                ));
                $output = curl_exec($ch);
                return $output;
            }
            
            function get_user_request_log($data){
                
                extract($data);
                                
                $db = db_access_interface::connect();
                 $sQuery = "INSERT INTO user_request_log(
                                        request_uri,
                                        request_method,
                                        query_string,
                                        http_user_agent,
                                        remote_addr,
                                        remote_port,
                                        server_port
                                    )
                                    VALUE(
                                        '".$REQUEST_URI."',
                                        '".$REQUEST_METHOD."',
                                        '".$QUERY_STRING."',
                                        '".$HTTP_USER_AGENT."',
                                        '".$REMOTE_ADDR."',
                                        '".$REMOTE_PORT."',
                                        '".$SERVER_PORT."'  
                                    )";

                     $result = $db->query($sQuery);
            }
            
            function save_request_data_log($data){
                
                $db = db_access_interface::connect();
                 $sQuery = "INSERT INTO request_content_log_debug(
                                        content_values
                                    )
                                    VALUE(
                                       
                                        '".$data."' 
                                    )";;

                     $result = $db->query($sQuery);
            }
}
?>