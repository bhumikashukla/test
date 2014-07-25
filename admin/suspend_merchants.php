<?php
include("config.php");
$id=$_REQUEST["id"];
$status=$_REQUEST["status"];
$q="UPDATE adminusers SET status = '$status' WHERE adminuserid = $id";
if(!mysql_query($q))
{
	die(mysql_error());
}
?>
