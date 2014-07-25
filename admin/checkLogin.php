<?php
session_start();
include_once('config.php');
// username and password sent from form
$myusername=$_GET['email'];
$mypassword=md5($_GET['pwd']);
// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

$sql="SELECT * FROM adminusers WHERE email='$myusername' AND password='$mypassword' AND status=10";

$result=mysql_query($sql);
$row=mysql_fetch_row($result);
// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){
// Register $myusername, $mypassword and redirect to file "login_success.php"

$_SESSION["admin_id"]=$row['0'];
$_SESSION["myusername"]=$myusername;
$_SESSION["mypassword"]=$mypassword;
$_SESSION["role"]=$row['4'];
	if($row['4'] == "merchant")
	{
		echo "<span>10</span>";
	}
	else if($row['4'] == "superadmin")
	{
		echo "<span>20</span>";
	}
}
else {
	echo "<span>0</span>";
}
?>