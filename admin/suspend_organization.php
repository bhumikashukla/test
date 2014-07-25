<?php
include("config.php");
$id=$_REQUEST["id"];
$status=$_REQUEST["status"];
$q="UPDATE organizations SET status = '$status' WHERE id = $id";
if(!mysql_query($q))
{
	die(mysql_error());
}
?>
