

<?php
  class Model{
        public function __construct(){
         $tns = "(DESCRIPTION =
         (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
         (CONNECT_DATA =
         (SERVER = DEDICATED)
         (SERVICE_NAME = orcl)
       ))";
       $conn = new \PDO("oci:dbname=".$tns.";charset=utf8","wzy","wzy");
       $this->pdo = $conn;
        }    

  }

?>