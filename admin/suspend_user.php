<?php
include("config.php");
$id=$_REQUEST["id"];
$status=$_REQUEST["status"];
$q="UPDATE users SET status = $status WHERE userid = $id";
if(!mysql_query($q))
{
	die(mysql_error());
}
?>
