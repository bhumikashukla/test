<?php
include("connection.php");
if(isset($_POST['isbn']))
{
	$isbn = $_POST['isbn'];
	$query = "select * from book_list where book_isbn = '$isbn'";
	$row = mysql_query($query) or die(mysql_error());
	while($row_new= mysql_fetch_array($row))
			{
					
			}
}
?>