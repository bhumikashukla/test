<?php
define("dba","pinbitcoins");
define("host","localhost");
define("user","root");
define("pass","");
function connection()
{
 $conn=mysql_connect(host,user,pass) or die(mysql_error());
 $dba=mysql_select_db(dba,$conn) or die(mysql_error()); 
}

function AppVersion()
{
	connection();
	$output = "";
	$id = $_POST["id"];
	$version = $_POST["version"];
	$url = $_POST["url"];
    $message = $_POST["message"];
	$date = date("YmdHis");	
		
	if($id != "0")
	{
		$q = "UPDATE appversion SET url = '$url', version = '$version', message = '$message' WHERE id = $id";	

		if(mysql_query($q))
		{			
			$output = "Record updated successfully.";		
		}
		else
		{
		   $output = "Error in processing request. Please try again.";		
		}
	}
	
	return $output; 
}

function AddEditItem()
{
	connection();
	$output = "";
	$itemid = $_POST["itemid"];
	$title = $_POST["title"];
	$price = $_POST["price"];	
	$description = $_POST["description"];
	$oldphotopath = $_POST["oldphotopath"];
	$date = date("Ymd");
	if($itemid == "0")
	{
	    if ((($_FILES["photo"]["type"] == "image/gif") || ($_FILES["photo"]["type"] == "image/jpeg") 
		|| ($_FILES["photo"]["type"] == "image/jpg") || ($_FILES["photo"]["type"] == 	"image/png")) && ($_FILES["photo"]["size"] < 20000000))
		{
				if ($_FILES["photo"]["error"] > 0)
				{
					$output = "Error: " . $_FILES["photo"]["error"] . "<br />";
				}
			   else
				{   
				   date_default_timezone_set('UTC');
		           $dt = date('YmdHis');
				   $rn = mt_rand();        
				   $file_name="upload/photos/items/" .$dt.$rn.".jpg";
				   move_uploaded_file($_FILES["photo"]["tmp_name"],  $file_name);
				}
		}
		else
		{
			$output = "Error: Invalid file format.";
		}
		if($output == "")
		{
			$q = "INSERT INTO items VALUES ('','$title','$description','$file_name','$price','{$date}',10)";	
			if(mysql_query($q))
			{	
				$id = mysql_insert_id();
				$output = "Item added successfully.";		
			}
			else
			{
			   $output = "Error in processing request. Please try again.";		
			}
		}		
	}
	else
	{
		if($_FILES["photo"]["size"] > 0)
		{
			if ((($_FILES["photo"]["type"] == "image/gif") || ($_FILES["photo"]["type"] == "image/jpeg") 
			|| ($_FILES["photo"]["type"] == "image/jpg") || ($_FILES["photo"]["type"] == 	"image/png")) && ($_FILES["photo"]["size"] < 20000000))
			{
			
					if ($_FILES["photo"]["error"] > 0)
					{
						$output = "Error: " . $_FILES["photo"]["error"] . "<br />";
					}
				   else
					{   
					   date_default_timezone_set('UTC');
					   $dt = date('YmdHis');
					   $rn = mt_rand();        
					   $file_name="upload/photos/items/" .$dt.$rn.".jpg";
					   move_uploaded_file($_FILES["photo"]["tmp_name"],  $file_name);
					   $q = "UPDATE items SET photopath = '$file_name' WHERE itemid = $itemid";
					   mysql_query($q);
					   if($oldphotopath != "")
					   {
							unlink($oldphotopath);
					   }
					}
			}
			else
			{
				$output = "Error: Invalid file format.";
			}
		}
		if($output == "")
		{
			$q = "UPDATE items SET title = '$title', description = '$description', price = '$price' WHERE itemid = $itemid";	
	
			if(mysql_query($q))
			{			
				$output = "Item updated successfully.";		
			}
			else
			{
			   $output = "Error in processing request. Please try again.";		
			}
		}
	}
	return $output; 
}

function InsertCategory()
{
	connection();
	$categoryid = $_POST["categoryid"];
	$name = $_POST["name"];
	$date = date("Ymd");
	$q = "SELECT * FROM categories WHERE name = '$name' AND categoryid <> $categoryid";
	$result=mysql_query($q);
	$rn = mysql_num_rows($result);
	if($rn == "0")
	{
		$q = "INSERT INTO categories VALUES ('','$name','{$date}',10)";				
		if(mysql_query($q))
		{
			$output = "Category added successfully.";		
		}
		else
		{
		   $output = "Error in processing request. Please try again.";		
		}	
	}
	else
	{
		$output = "Category already exists.";	
	}	
	
	return $output; 
}

function EditCategory()
{
	connection();
	$categoryid = $_POST["categoryid"];
	$name = $_POST["name"];
	$date = date("Ymd");
	$q = "SELECT * FROM categories WHERE name = '$name' AND categoryid <> $categoryid";
	$result=mysql_query($q);
	$rn = mysql_num_rows($result);
	if($rn == "0")
	{
		$q = "UPDATE categories SET name = '$name' WHERE categoryid = $categoryid";				
		if(mysql_query($q))
		{
			$output = "Category updated successfully.";		
		}
		else
		{
		   $output = "Error in processing request. Please try again.";		
		}	
	}
	else
	{
		$output = "Category already exists.";	
	}
	
	return $output; 
}

function SendEmails()
{		
	connection();
	$subject = $_POST["subject"];
	$message = $_POST["message"];
	$count = 0;
	$q ="SELECT * FROM users WHERE emailalters = 1";
	$result = mysql_query($q);
	while($row = mysql_fetch_array($result))
	{
		$to = $row["email"];		   
 	    $headers = "From:info@linkites.com";
  	    $headers .= "MIME-Version: Proximity App\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
 	    @mail($to,$subject,$message,$headers);
		$count+= 1;		
	}  
	$output = "Email has been sent to ". $count. " member(s).";
	return $output; 	
}