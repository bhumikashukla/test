<?php
error_reporting(E_ALL ^ E_DEPRECATED);
class funcs_code 
{
   var $url  = "";
   var $conn="";
   var $dba="test"; 
   var $host="localhost";
   var $user="root";
   var $pass="";
  
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
    $q = "selct * from users WHERE username = $username & password = $password";
    $resdetail = mysql_query($q);  
	$rowdetail = mysql_fetch_assoc($resdetail);    
    $output = $rowdetail;      
    echo json_encode($output);
}

login('bhumika', '132132132132');
?>