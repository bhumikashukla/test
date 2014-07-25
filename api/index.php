<?php
class funcs_code 
{
   var $url  = "";
   var $conn="";
   var $dba="test_repo"; 
   var $host="localhost";
   var $user="root";
   var $pass="";  
   
   /*var $url  = "http://me.intlfaces.com/admin/";
   var $conn="";
   var $dba="linkixvk_monocircle"; 
   var $host="localhost";
   var $user="root";
   var $pass=""; */
   
   
  
   public function connection()
   {
      $this->conn=mysql_connect($this->host,$this->user,$this->pass) or die(mysql_error());	
      $this->dba=mysql_select_db($this->dba,$this->conn) or die(mysql_error());	
   }
   	
   public function query($sql_q)
   {
      $result=mysql_query($sql_q);
      if(!$result){die(mysql_error());}else{return $result;}
   }  
}
function login($username, $password)
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "0";
    $id = 0;
    if(isset($_POST["username"]))
    {
        $username = $_POST["username"];
    }
    if(isset($_POST["password"]))
    {
        $password = $_POST["password"];
    }
    $q = "UPDATE user SET status = '0' WHERE username = $username & password = $password";
    $resdetail = mysql_query($q);  
	$rowdetail = mysql_fetch_assoc($resdetail);    
    $output = $rowdetail;      
    echo json_encode($output);
}

login('bhumika', '123');
?>