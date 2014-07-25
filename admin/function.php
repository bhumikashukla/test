<?php
/*define("dba","blcdbsynapse");
define("host","localhost");
define("user","root");
define("pass","");*/
define("dba","blcdbsynapse");
define("host","68.178.143.102");
define("user","blcdbsynapse");
define("pass","Eastern#105");
function connection()
{
 $conn=mysql_connect(host,user,pass) or die(mysql_error());
 $dba=mysql_select_db(dba,$conn) or die(mysql_error()); 
}

function AddEditOffer()
{
	connection();
	$output = "";
	$id = $_POST["id"];
	$membername = $_POST["membername"];
	$fathername = $_POST["fathername"];
	$mothername = $_POST["mothername"];
    $fatherphone = $_POST["fatherphone"];
	$motherphone = $_POST["motherphone"];
	$memberdob = $_POST["memberdob"];
	$memberage = $_POST["memberage"];
	$memberclass = $_POST["memberclass"];
	$memberschool = $_POST["memberschool"];
	$lat = $_POST["lat"];
	$lng = $_POST["lng"];
	$address = $_POST["map_location"];
	$date = date("YmdHis");
	
	
	
	if($id == "0")
	{
		$q = "SELECT * from members_list where father_phone = '$fatherphone' OR mother_phone = '$motherphone'";
		$r = mysql_query($q);
		if(mysql_num_rows($r) == 0)
		{
		/*	if ((($_FILES["files"]["type"] == "image/gif") || ($_FILES["files"]["type"] == "image/jpeg") 
			|| ($_FILES["files"]["type"] == "image/jpg") || ($_FILES["files"]["type"] == 	"image/png")) )
			{
				*/
				$query1="INSERT INTO `members_list` SET `member_name`='$membername',`mother_name`='$mothername',`father_name`='$fathername',`mother_phone`='$motherphone',`father_phone`='$fatherphone',`member_dob`='$memberdob',`member_age`='$memberage',`member_class`='$memberclass',`member_school`='$memberschool',`location`='$address',`latitude`='$lat',`longitude`='$lng',`club_id`='1'";
				  
						if(mysql_query($query1))
							{	
								$id = mysql_insert_id();
								$output = "Member added successfully.";		
							}
							else
							{
							   $output = "Error in processing request. Please try again.";		
							}
						 $errors= array();
						 /*foreach($_FILES['files']['tmp_name'] as $key => $tmp_name )
						 {
							$file_name = $key.$_FILES['files']['name'][$key];
							$file_size =$_FILES['files']['size'][$key];
							$file_tmp =$_FILES['files']['tmp_name'][$key];
							$file_type=$_FILES['files']['type'][$key];
	                        $desired_dir="upload/photos/offers/";
							$url="http://monicircle.intlfaces.com/admin/";
							$path=$url.$desired_dir.$file_name;
						   if($file_size > 2097152)
						   {
						   $errors[]='File size must be less than 2 MB';
						   }
	
							 $query="INSERT into file (`id`,`offer_id`,`FILE_NAME`,`FILE_SIZE`,`FILE_TYPE`)               VALUES(NULL,'$id','$path','$file_size','$file_type')";
							
							if(empty($errors)==true)
								{
									if(is_dir($desired_dir)==false)
									{
										mkdir("$desired_dir", 0700);		// Create directory if it does not exist
									}
									if(is_dir("$desired_dir/".$file_name)==false)
									{
										move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
									}
									else
									{									// rename the file if another one exist
										$new_dir="$desired_dir/".$file_name.time();
										 rename($file_tmp,$new_dir) ;				
									}
								 mysql_query($query) or die(mysql_error());			
								}
								else
								{
										print_r($errors);
								}
						 }*/
			}
			else
			{
				$output = "Error in processing request. Record aleady exists.";		
			}
		return $output; 			 
	}
	else
	{
		$errors= array();
		 /*foreach($_FILES['photo']['tmp_name'] as $key => $tmp_name )
		 {
			echo $file_name = $key.$_FILES['photo']['name'][$key];
			$file_size =$_FILES['photo']['size'][$key];
			$file_tmp =$_FILES['photo']['tmp_name'][$key];
			$file_type=$_FILES['photo']['type'][$key];
			$desired_dir="upload/photos/offers/";
			$url="http://monicircle.intlfaces.com/admin/";
			
			$path=$url.$desired_dir.$file_name;
		   if($file_size > 2097152)
			   {
			   $errors[]='File size must be less than 2 MB';
			   }
	
			 $query_fileupdate= "UPDATE file SET FILE_NAME = '$path',FILE_SIZE='$file_size',FILE_TYPE ='$file_type' WHERE offer_id = $offerid";
			
			if(empty($errors)==true)
				{
					if(is_dir($desired_dir)==false)
					{
						mkdir("$desired_dir", 0700);		// Create directory if it does not exist
					}
					if(is_dir("$desired_dir/".$file_name)==false)
					{
						move_uploaded_file($file_tmp,"$desired_dir/".$file_name);
					}
					else
					{									// rename the file if another one exist
						$new_dir="$desired_dir/".$file_name.time();
						 rename($file_tmp,$new_dir) ;				
					}
				 mysql_query($query_fileupdate) or die(mysql_error());			
				}
				else
				{
						print_r($errors);
				}
		 }*/
	
	
	/*
	if($_FILES["photo"]["size"] > 0)
	{
	if ((($_FILES["photo"]["type"] == "image/gif") || ($_FILES["photo"]["type"] == "image/jpeg") 
	|| ($_FILES["photo"]["type"] == "image/jpg") || ($_FILES["photo"]["type"] == 	"image/png")) && ($_FILES["photo"]["size"] < 20000000))
	{
	
	if ($_FILES["photo"]["error"] > 0)
	{
		$output 4= "Error: " . $_FILES["photo"]["error"] . "<br />";
	}
	else
	{   
	   date_default_timezone_set('UTC');
	   $dt = date('YmdHis');
	   $rn = mt_rand();        
	   $file_name="upload/photos/offers/" .$dt.$rn.".jpg";
	   move_uploaded_file($_FILES["photo"]["tmp_name"],  $file_name);
	   $q = "UPDATE offers SET photopath = '$file_name' WHERE offerid = $offerid";
	   mysql_query($q);
	   if($oldphotopath != "")
	   {
			@unlink($oldphotopath);
	   }
	}
	}
	else
	{
	$output = "Error: Invalid file format.";
	}
	}*/
	/*if(isset($_POST["feature_deal_update"]))
	{
		$checkbox_update=$_POST["feature_deal_update"];
	}
	if ($checkbox_update=="on")
	{
	
	$query_update = "UPDATE offers SET offername = '$offername',category = '$catid', description = '$description', discount = $discount,photopath='',feature_deal=10, priceafterdiscount = $priceafterdiscount, latitude = '$lat', longitude = '$lng',location = '$address' WHERE offerid = $offerid";	
	
	if(mysql_query($query_update))
	{			
	$output = "Offer updated successfully.";		
	}
	else
	{
	$output = "Error in processing request. Please try again.";		
	}
	
	}
	else
	{*/
	$query_update = "UPDATE `members_list` SET `member_name`='$membername',`mother_name`='$mothername',`father_name`='$fathername',`mother_phone`='$motherphone',`father_phone`='$fatherphone',`member_dob`='$memberdob',`member_age`='$memberage',`member_class`='$memberclass',`member_school`='$memberschool',`location`='$address',`latitude`='$lat',`longitude`='$lng',`club_id`='1' WHERE id = '$id'";
	if(mysql_query($query_update))
	{			
		$output = "Member updated successfully.";		
	}
	else
	{
		$output = "Error in processing request. Please try again.";		
	}
	//}
	}
	return $output; 	 
}

/******************************************************************************************************************/

function AddEditParents()
{
	connection();
	$output = "";
	$id = $_POST["id"];
	$parent_name = $_POST["parentname"];
    $parent_phone = $_POST["parentphone"];
	$parent_relation = $_POST["parentrelation"];
	$no_of_children = $_POST["childrencount"];
	$date = date("YmdHis");
	if($id == "0")
	{
		$q = "SELECT * from parents_list where parent_phone = '$parent_phone'";
		$r = mysql_query($q) or die(mysql_error());
		if(mysql_num_rows($r) == 0)
		{
			$q= "INSERT INTO `parents_list` SET `parent_name`='$parent_name',`parent_phone`='$parent_phone',`parent_relation`='$parent_relation',`no_of_children`='$no_of_children',`date`='{$date}'";		
			if(mysql_query($q))
			{	
				$id = mysql_insert_id();
				$output = "Parent added successfully.";		
			}
			else
			{
			   $output = "Error in processing request. Please try again.";		
			}
		}
		else 
		{
			$output = "Error in processing request. Record already exists.";
		}
		
			
	}
	else
	{
		$q = "UPDATE `parents_list` SET `parent_name`='$parent_name',`parent_phone`='$parent_phone',`parent_relation`='$parent_relation',`no_of_children`='$no_of_children',`date`='{$date}' WHERE id = '$id'";	
		
		if(mysql_query($q))
		{			
			$output = "Parent updated successfully.";		
		}
		else
		{
		   $output = "Error in processing request. Please try again.";		
		}	
	}
	return $output ; 
}

/*****************************************************************************************/

function AddEditBookDetails()
{
	connection();
	$output = "";
	$id = $_POST["id"];
	$book_isbn = $_POST["bookisbn"];
	$book_name = $_POST["bookname"];
	$series = $_POST["series"];
    $publisher = $_POST["publisher"];
	$author = $_POST["author"];
	$book_condition	 = $_POST["bookcondition"];
	$owned_by = $_POST["owner"];
	$level = $_POST["level"];
	$word_count = $_POST["wordcount"];
	$book_status = $_POST["bookstatus"];
	$oldphotopath = $_POST["oldphotopath"];
	$date = date("YmdHis");
	if($id == "0")
	{
		$q = "SELECT * from book_list where book_isbn = '$book_isbn'";
		$r = mysql_query($q);
		if(mysql_num_rows($r) == 0)
		{
			$q= "INSERT INTO `book_list` SET `book_name`='$book_name',`series`='$series',`publisher`='$publisher',`author`='$author',`book_isbn`='$book_isbn',`book_condition`='$book_condition',`owned_by`='$owned_by',`level`='$level',`word_count`='$word_count',`book_status`='$book_status'";		
					if(mysql_query($q))
					{	
						$newid = mysql_insert_id();
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
								   $file_name="upload/" .$dt.$rn.".jpg";
								   move_uploaded_file($_FILES["photo"]["tmp_name"],  $file_name);
								   $q = "UPDATE book_list SET book_preview = '$file_name' WHERE id = $newid";
								   mysql_query($q);
								   if($oldphotopath != "")
								   {
										@unlink($oldphotopath);	
								   }
								   $output = "Book added successfully.";	
								}
							}
						else
						{
							$output = "Error: Invalid file format.";
						}	
					}
					else
					{
					   $output = "Error in processing request. Please try again.";		
					}
				}
				else
				{
					$output = "Error in processing request. Please try again.";
				}
		}
		else
		{
			$output = "Error in processing request. Record aleady exists.";
		}
	}
	else
	{
		$q= "UPDATE `book_list` SET `book_name`='$book_name',`series`='$series',`publisher`='$publisher',`author`='$author',`book_isbn`='$book_isbn',`book_condition`='$book_condition',`owned_by`='$owned_by',`level`='$level',`word_count`='$word_count',`book_status`='$book_status' WHERE id = '$id'";		
					if(mysql_query($q))
					{	
						$id = mysql_insert_id();
						//$output = "Parent added successfully.";		
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
								   $file_name="upload/" .$dt.$rn.".jpg";
								   move_uploaded_file($_FILES["photo"]["tmp_name"],  $file_name);
								   $q = "UPDATE book_list SET book_preview = '$book_preview' WHERE id = $id";
								   mysql_query($q);
								   if($oldphotopath != "")
								   {
										@unlink($oldphotopath);
										$output = "Book added successfully.";	
								   }
								}
							}
						else
						{
							$output = "Error: Invalid file format.";
						}	
					}
					else
					{
					  $output = "Book added successfully.";	
					}
				}
				else
				{
				   $output = "Error in processing request. Please try again.";		
				}	
	}
	return $output ; 
}

/******************************************************************************************************/

function AddEditTransactions()
{
	connection();
	$output = "";
	$id = $_POST["id"];
	$member_id = $_POST["member"];
    $book_id = $_POST["booklist"];
	$book_trasaction = $_POST["booktransactions"];
	$date = date("YmdHis");
	if($id == "0")
	{
		$q = "SELECT * from book_trasaction_records where book_id = '$book_id'";
		$r = mysql_query($q);
		if(mysql_num_rows($r) == 0)
		{
			$q = "INSERT INTO `book_trasaction_records`(`id`, `book_id`, `member_id`, `book_trasaction`, `issued_date`) VALUES ('','$book_id','$member_id','$book_trasaction','{$date}')";			
			if(mysql_query($q))
			{	
				$id = mysql_insert_id();
				$output = "Transactions added successfully.";		
			}
			else
			{
			   $output = "Error in processing request. Please try again.";		
			}
		}
		else
		{
		   $output = "Error in processing request. Record aleady exists.";		
		}
			
	}
	else
	{
		
		
			$q = "UPDATE book_trasaction_records SET book_trasaction = '$book_trasaction' WHERE id = '$id'";	
	        
			if(mysql_query($q))
			{			
				$output = "Transactions updated successfully.";		
			}
			else
			{
			   $output = "Error in processing request. Please try again.";		
			}
		
	}
	return $output ; 
}

/******************************************************************************************************/

function AddEditReadingStatus()
{
	connection();
	$output = "";
	$id = $_POST["id"];
	$member_id = $_POST["member"];
    $book_id = $_POST["booklist"];
	$start_date = $_POST["startdate"];
    $end_date = $_POST["enddate"];
	$total_reading_days = $_POST["totaldays"];
	$level = $_POST["level"];
	$word_count = $_POST["wordcount"];
	$points = $_POST["points"];
	$date = date("YmdHis");
	if($id == "0")
	{
		$q = "SELECT * from book_reading_status where book_id = '$book_id'";
		$r = mysql_query($q);
		if(mysql_num_rows($r) == 0)
		{
			$q = "INSERT INTO `book_reading_status` SET `book_id`='$book_id',`member_id`='$member_id',`start_date`='$start_date',`end_date`='$end_date',`total_reading_days`='$total_reading_days',`level`='$level',`word_count`='$word_count',`points`='$points'";			
			if(mysql_query($q))
			{	
				$id = mysql_insert_id();
				$output = "Reading status added successfully.";		
			}
			else
			{
			   $output = "Error in processing request. Please try again.";		
			}
		}
		else
		{
		   $output = "Error in processing request. Record aleady exists.";		
		}
	}
	else
	{
		
		
			$q = "UPDATE `book_reading_status` SET `book_id`='$book_id',`member_id`='$member_id',`start_date`='$start_date',`end_date`='$end_date',`total_reading_days`='$total_reading_days',`level`='$level',`word_count`='$word_count',`points`='$points' WHERE id = '$id'";	
	        
			if(mysql_query($q))
			{			
				$output = "Reading status updated successfully.";		
			}
			else
			{
			   $output = "Error in processing request. Please try again.";		
			}
		
	}
	return $output ; 
}

/*********************OLD DATA**********************************/
/****************************************************************************************************/
function AddMerchant()
{
	connection();
	$output = "";
	$username = $_POST["username"];
	$email = $_POST["email"];	
	$password = $_POST["password"];
	$orgnization = $_POST['orgnization'];
	$password = md5($password);
	$date = date("Ymd");	
	$q = "SELECT * FROM adminusers WHERE email = '$email'";
    $res=mysql_query($q);
    if(mysql_num_rows($res) == 0)
    {
		$q1 = "SELECT * FROM adminusers WHERE username = '$username'";
		$res1=mysql_query($q1);
		if(mysql_num_rows($res1) == 0)
		{
			$q2 = "INSERT INTO adminusers VALUES ('','$username','$email','$password','merchant','$orgnization','{$date}',10)";	
			if(mysql_query($q2))
			{	
				$id = mysql_insert_id();
				$output = "Merchant added successfully.";		
			}
			else
			{
			   $output = "Error in processing request. Please try again.";		
			}
		}
		else
		{
			$output = "Username already register.";
		}
	}
	else
	{
		$output = "Email already register.";
	}	
	return $output; 
}

function getUserType(){
	$adminuserid=$_SESSION['admin_id'];
	$usertyperow=mysql_fetch_assoc(mysql_query("select role from adminusers where adminuserid= $adminuserid limit 1")) or die(mysql_error());
	$usertype=$usertyperow["role"];
	return $usertype;
}

function AddEditCategory()
{
	connection();
	$output = "";
	$catid = $_POST["catid"];
	$catname = $_POST["catname"];
	$date = date("YmdHis");
	if($catid == "0")
	{
	    
		
			$q = "INSERT INTO categories VALUES ('','$catname','{$date}',10)";			
			if(mysql_query($q))
			{	
				$id = mysql_insert_id();
				$output = "Category added successfully.";		
			}
			else
			{
			   $output = "Error in processing request. Please try again.";		
			}
			
	}
	else
	{
		
		
			$q = "UPDATE categories SET name = '$catname' WHERE id = '$catid'";	
	        
			if(mysql_query($q))
			{			
				$output = "Category updated successfully.";		
			}
			else
			{
			   $output = "Error in processing request. Please try again.";		
			}
		
	}
	return $output ; 
}

function AddEditOrganization(){
	connection();
	$output = "";
	$organizationid = $_POST["organizationid"];
	$orgname = $_POST["orgname"];
	$category = $_POST['category'];
	$location = $_POST['location'];
	$description = $_POST['description'];

	
	$date = date("YmdHis");
	if($organizationid == "0")
	{
	    
		
			$q = "INSERT INTO organizations VALUES ('','$orgname','$category','$location','$description','{$date}',10)";			
			if(mysql_query($q))
			{	
				$id = mysql_insert_id();
				$output = "Organization added successfully.";		
			}
			else
			{
			   $output = "Error in processing request. Please try again.";		
			}
			
	}
	else
	{
		
		
			$q = "UPDATE organizations SET name = '$orgname', categoryid = '$category', location = '$location', description = '$description' WHERE id = '$organizationid'";	
			
	        
			if(mysql_query($q))
			{			
				$output = "Category updated successfully.";		
			}
			else
			{
			   $output = "Error in processing request. Please try again.";		
			}
		
	}
	return $output ; 
}