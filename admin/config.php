<?php
//session_start();
error_reporting(E_ALL ^ E_DEPRECATED);
$conn=mysql_connect("68.178.143.102","blcdbsynapse","Eastern#105");
//$conn=mysql_connect("localhost","root","");
if(!$conn)
{
  die('could not connect:'.mysql_error());
}
mysql_select_db("blcdbsynapse",$conn);
?>