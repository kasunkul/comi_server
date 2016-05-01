<?php
class ConnectionManager 
{
  
   
    public $host ='127.0.0.1';//set as ip of server
    public $user = 'root';
    public $pw ='';
    public $db ='comi_db';
   
    public function getConnection() {
             $this->db = new mysqli($this->host,$this->user,$this->pw,$this->db);
    }

}

?>