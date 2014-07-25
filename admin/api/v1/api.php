<?php
error_reporting(E_ERROR | E_PARSE);//Please don't remove this
OnLoad();

class funcs_code 
{
   var $url  = "http://me.intlfaces.com/admin/";
   var $conn="";
   var $dba="db169264_monicircle"; 
   var $host="internal-db.s169264.gridserver.com";
   var $user="db169264";
   var $pass="Id6ZpIb9e0oT3Z";  
   
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
function OnLoad()
{
   $method = $_GET['method'];
   if ($method == 'SocialSignIn')
   {
      SocialSignIn();
   }
   else if($method == 'SignOut')
   {
      SignOut();
   }
   else if($method == 'GetDeals')
   {
      GetDeals();
   }
   else if($method == 'GetCategories')
   {
      GetCategories();
   }
   else if($method == 'GeneratePromoCode')
   {
      GeneratePromoCode();
   }
   else if($method == 'GetUserProfile')
   {
      GetUserProfile();
   }
   else if($method == 'iOSPushNotification')
   {
	  iOSPushNotification();
   }
   else if($method == 'androidpushnotification')
   {
	  androidpushnotification();
   }
   else if($method == 'GetDealDetails')
   {
	  GetDealDetails();
   }
   else if($method == 'DeleteAccount')
   {
	  DeleteAccount();
   }
   else if($method == 'SearchDeal')
   {
	  SearchDeal();
   }
   else if($method == 'GetPendingDeals')
   {
	  GetPendingDeals();
   }
   else if($method == 'UserTeirStatus')
   {
	  UserTeirStatus();
   }
   else if($method == 'AddToWatchList')
   {
	  AddToWatchList();
   }
   else if($method == 'GetAppVersion')
   {
	GetAppVersion();
   }
   else if($method == 'GetWatchList')
   {
	GetWatchList();
   }

} 

function SocialSignIn()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "0";
    $date = date('YmdHis');
    $fname = "";
    $lname = "";
    $email = "";
    $pwd = "";	
    $imagepath = "";
    $fbid = "";
    $devicetoken = "";
    $devicetype = "";
    $deviceid = "";
    $lat = 0;
    $lng = 0;
	$ccn = 0;
    $city = "";
    if(isset($_POST["fname"]))
    {
	   $fname = $_POST["fname"];	
    }
    if(isset($_POST["lname"]))
    {
	   $lname = $_POST["lname"];	
    }
    if(isset($_GET["email"]))
    {
	$email = $_POST["email"];
        $email = mysql_escape_string($email);	   
    }
    if(isset($_POST["photopath"]))
    {
	$imagepath = $_POST["photopath"];	
    }
    if(isset($_POST["fbid"]))
    {
        $fbid = $_POST["fbid"];
        $pwd = mysql_escape_string(md5($fbid));	   
    }    
    if(isset($_POST['devicetoken']))
    {
        $devicetoken = $_POST['devicetoken'];
    }
    if(isset($_POST['devicetype']))
    {
        $devicetype= $_POST['devicetype'];
    }
    if(isset($_POST['deviceid']))
    {
        $deviceid = $_POST['deviceid'];
    }    
    if(isset($_POST["lat"]))
    {
        $lat = $_POST["lat"];
    }
    if(isset($_POST["lng"]))
    {
        $lng = $_POST["lng"];
    }
	if(isset($_POST["city"]))
    {
        $city = $_POST["city"];
    }
	if(isset($_POST["ccn"]))
    {
        $ccn = $_POST["ccn"];
    }
   	$q = "SELECT * FROM user WHERE email = '$email' AND fbuserid = '$fbid'";
    $res=mysql_query($q);	
    $row=mysql_fetch_row($res);	
    if(mysql_num_rows($res)==0)
    {	
		$q = "INSERT INTO `user`(`id`, `fbuserid`, `fname`, `lname`, `email`, `password`, `date`, `role`, `link`, `profilepic`,`devicetoken`, `devicetype`, `ccn`, `status`, `city`, `lat`, `lng`) VALUES ('','$fbid','$fname','$lname','$email','$pwd','{$date}','user','','$imagepath','$devicetoken','$devicetype','$ccn',10,'$city','$lat','$lng')";
		if(mysql_query($q))
		{
			$contents = array();
			$id = mysql_insert_id();
			$q = "SELECT `fname`, `lname`, `email`, `password`,`role`, `link`, `profilepic`, `devicetoken`, `devicetype`, `ccn` FROM `user` WHERE `id` = $id";
			$resdetail = mysql_query($q);	
			$rowdetail = mysql_fetch_assoc($resdetail);
            $output = $rowdetail;
		}
		else
		{
			$output = "0";		
		}   
	}
        else
        {
            $userid = $row["0"];
	    	$q = "UPDATE user SET devicetoken = '$devicetoken', devicetype = '$devicetype', profilepic = '$imagepath' WHERE id = $userid";        
            mysql_query($q);
            $q = "SELECT `fname`, `lname`, `email`, `password`,`role`, `link`, `profilepic`, `devicetoken`, `devicetype`, `ccn` FROM `user` WHERE `id` = $userid";
	    $resdetail = mysql_query($q);	
	    $rowdetail = mysql_fetch_assoc($resdetail);
            $output = $rowdetail;
        }
	echo json_encode($output);	
}

//For Sign Out
function SignOut()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "0";
    $id = 0;
    if(isset($_POST["Userid"]))
    {
        $id = $_POST["Userid"];
    }
    $q = "UPDATE user SET status = '0' WHERE id = $id";
    mysql_query($q);      
    echo json_encode($output);
}

function DeleteAccount()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "0";
    $id = 0;
    if(isset($_POST["Userid"]))
    {
        $id = $_POST["Userid"];
    }
    $q = "DELETE FROM `user` WHERE `id` = $id";
    mysql_query($q);      
    echo json_encode($output);
}

function GetUserProfile()
{
    $obj=new funcs_code(); 
    $obj->connection();
    $userid = 0; 
	$id = 0;		
    if(isset($_GET["userid"]))
    {
       $userid = $_GET["userid"];
    }
	if(isset($_GET["id"]))
    {
        $id = $_GET["id"];
    }
	if($id != "")
		{
			$q = "SELECT `id`, `fbuserid`, `fname`, `lname`, `email`, `password`, `date`, `role`, `link`, `profilepic`, `devicetoken`, `devicetype`, `ccn`, `status`, `city`, `lat`, `lng` FROM `user` WHERE id = $id"; 
		}
		else if($userid != "")
		{
			$q = "SELECT `id`, `fbuserid`, `fname`, `lname`, `email`, `password`, `date`, `role`, `link`, `profilepic`, `devicetoken`, `devicetype`, `ccn`, `status`, `city`, `lat`, `lng` FROM `user` WHERE fbuserid = $userid"; 
		}
    $resdetail = mysql_query($q);	 
    $rowdetail = mysql_fetch_assoc($resdetail);    
    $output = $rowdetail;            
    echo json_encode($output);
}

function GetDeals()
{
	$obj=new funcs_code();
	$obj->connection();
	$Categoryid = 0; 		
	if(isset($_GET["Categoryid"]))
	{
	    $CategoryID = $_GET["Categoryid"];
		$pageno=-1;
		if(isset($_GET["page"])){
			$pageno=$_GET["page"];
		}
		$pagesize=10;
		if(isset($_GET["pagesize"])){
			$pagesize=$_GET["pagesize"];
		} 
			$q = "SELECT `offerid`, `merchantid`, `startdate`, `enddate`, `offername`, `category`, `normalprice`, `discount`, `photopath`, `priceafterdiscount`, `latitude`, `longitude`, `location`, `description`, `term_condition`, `date`, `status` FROM `offers` WHERE status = 10 AND category = $CategoryID";
		  /*if($pageno>1){
			$q = $q." LIMIT ($pageno - 1) * $pagesize, $pagesize";
		  }else if($pageno==1){
			$q = $q." LIMIT 1, $pagesize";
		  }
		  $offers;*/
		  $res = mysql_query($q);
		  if(mysql_num_rows($res) > 0)
		  {	
			  while($deal = mysql_fetch_assoc($res)) {
				  $offerid = $deal['offerid'];
				  $q1 = "SELECT FILE_NAME FROM `file` WHERE `offer_id` = '$offerid'";
				   $res1 = mysql_query($q1);
				    while($pic = mysql_fetch_assoc($res1)) {
						$deal['photopath'] = $pic['FILE_NAME'];
				  	 $deals[] = array('deal'=>$deal);
					}
			  } 
		  }else{
				$deals=array();
		  }		  
	       
		header('Content-type: application/json');     
		echo json_encode(array('deals'=>$deals));
	}else{
		header('Content-type: application/json');     
		echo json_encode(array('deals'=>array()));
	}	  
}
function GetDealDetails()
{
	$obj=new funcs_code();
	$obj->connection();
	$DealID = 0; 		
	if(isset($_GET["dealid"]))
	{
	    $DealID = $_GET["dealid"];
		$pageno=-1;
		if(isset($_GET["page"])){
			$pageno=$_GET["page"];
		}
		$pagesize=10;
		if(isset($_GET["pagesize"])){
			$pagesize=$_GET["pagesize"];
		} 
			$q = "SELECT `offerid`, `merchantid`, `startdate`, `enddate`, `offername`, `category`, `normalprice`, `discount`, `photopath`, `priceafterdiscount`, `latitude`, `longitude`, `location`, `description`, `term_condition`, `date`, `status` FROM `offers` WHERE status = 10 AND offerid = $DealID";
		  /*if($pageno>1){
			$q = $q." LIMIT ($pageno - 1) * $pagesize, $pagesize";
		  }else if($pageno==1){
			$q = $q." LIMIT 1, $pagesize";
		  }
		  $offers;*/
		  $res = mysql_query($q);
		  if(mysql_num_rows($res) > 0)
		  {	
			  while($deal = mysql_fetch_assoc($res)) {
				  $offerid = $deal['offerid'];
				  $q1 = "SELECT FILE_NAME FROM `file` WHERE `offer_id` = '$offerid'";
				   $res1 = mysql_query($q1);
				    while($pic = mysql_fetch_assoc($res1)) {
						$deal['photopath'] = $pic['FILE_NAME'];
				    	$deals[] = array('deal'=>$deal);
					}
			  } 
		  }else{
				$deals=array();
		  }		  
	       
		header('Content-type: application/json');     
		echo json_encode(array('deals'=>$deals));
	}else{
		header('Content-type: application/json');     
		echo json_encode(array('deals'=>array()));
	}	  
}

function SearchDeal()
{
	$obj=new funcs_code();
	$obj->connection();
	$string = ''; 		
	if(isset($_GET["string"]))
	{
	    $string = $_GET["string"];
			$q = "SELECT `offerid`, `merchantid`, `startdate`, `enddate`, `offername`, `category`, `normalprice`, `discount`, `photopath`, `priceafterdiscount`, `latitude`, `longitude`, `location`, `description`, `term_condition`, `date`, `status` FROM `offers` WHERE status = 10 AND offername LIKE '%$string%' OR location LIKE '%$string%'";
		  /*if($pageno>1){
			$q = $q." LIMIT ($pageno - 1) * $pagesize, $pagesize";
		  }else if($pageno==1){
			$q = $q." LIMIT 1, $pagesize";
		  }
		  $offers;*/
		  $res = mysql_query($q);
		  if(mysql_num_rows($res) > 0)
		  {	
			  while($deal = mysql_fetch_assoc($res)) {
				   $deals[] = array('deal'=>$deal);
			  } 
		  }else{
				$deals=array();
		  }		  
	       
		header('Content-type: application/json');     
		echo json_encode(array('deals'=>$deals));
	}else{
		header('Content-type: application/json');     
		echo json_encode(array('deals'=>array()));
	}	  
}

function GetCategories()
{
	$obj=new funcs_code();
	$obj->connection();
	$userid = 0; 		
	if(isset($_GET["userid"]))
	{
	    $userid = $_GET["userid"];
	 }
                 
	$q = "SELECT `id`, `name`, `date` FROM `categories` WHERE `status` = 10";	
	      $res = mysql_query($q);
	      if(mysql_num_rows($res) > 0)
	      {	
			while($cat = mysql_fetch_assoc($res)) 
			{
				$category[] = array('cat'=>$cat);
			} 
	      } 
		  $results;
		//added total earning of users in items lists       
		/*$q = "SELECT 
		   totalrewards 
              FROM 
		users
	      WHERE userid = $userid";	
	      $res1 = mysql_query($q);
	      if(mysql_num_rows($res1) > 0)
	      {	
                  $row = mysql_fetch_assoc($res1);
                  $results["totalearning"] = $row["totalrewards"];
		  }       */
	header('Content-type: application/json'); 
	$results['category'] = $category;   
	echo json_encode(array('results'=>$results));
}

function GeneratePromoCode()
{
	$obj=new funcs_code();
	$obj->connection();
	$userid = 0; 		
	if(isset($_GET["userid"]))
	{
	    $userid = $_GET["userid"];
	}
	if(isset($_GET["dealid"]))
	{
	    $dealid = $_GET["dealid"];
	}
	 	$promocode = mt_rand();
		$sql="SELECT * FROM user_promocode WHERE deal_id='$dealid' AND user_id = $userid";
		$result=mysql_query($sql) or die(mysql_error());
			if(mysql_num_rows($result) > 0)
			{
				$query = "UPDATE `user_promocode` SET `promocode`='$promocode',`date`=now() WHERE `deal_id`='$dealid' AND user_id = $userid";
				mysql_query($query) or die(mysql_error());
				$q = "SELECT `id`, `deal_id`, `user_id`, `promocode`, `date` FROM `user_promocode` WHERE `deal_id` = $dealid AND user_id = $userid";
			$resdetail = mysql_query($q);	
			$rowdetail = mysql_fetch_assoc($resdetail);
            $output = $rowdetail['promocode'];
			}
			else{
				$query = "INSERT INTO `user_promocode`(`id`, `deal_id`, `user_id`, `promocode`, `date`) VALUES (NULL,'$dealid','$userid','$promocode',now())";
				if(mysql_query($query))
				{
					$id = mysql_insert_id();
					$q = "SELECT `id`, `deal_id`, `user_id`, `promocode`, `date` FROM `user_promocode` WHERE `id` = $id";
					$resdetail = mysql_query($q);	
					$rowdetail = mysql_fetch_assoc($resdetail);
					$output = $rowdetail['promocode'];
				}
				else
				{
					$output = "0";		
				}
			}
			header('Content-type: application/json'); 
			//echo json_encode($output);	
			$results['promocode'] = $output;   
			echo json_encode(array('results'=>$results));
	
}

function GetPendingDeals()
{
	$obj=new funcs_code();
	$obj->connection();
	$CategoryID = 0; 		
	$userid = 0; 
	$id = 0;		
    if(isset($_GET["userid"]))
    {
       $userid = $_GET["userid"];
    }
	if(isset($_GET["id"]))
    {
        $id = $_GET["id"];
    }
	if($id != "")
		{
			$q = "SELECT * FROM `user` WHERE `id` = $id";
			$resdetail = mysql_query($q);	
			if(mysql_num_rows($resdetail) > 0)
			{
				$rowdetail = mysql_fetch_assoc($resdetail);
				$fbuserid = $rowdetail['fbuserid'];
				$sql="SELECT * FROM user_promocode WHERE user_id ='$fbuserid'";
				$result=mysql_query($sql) or die(mysql_error());
				if(mysql_num_rows($result) > 0)
				{
					 while($row = mysql_fetch_assoc($result))
					 {
						 $dealid = $row['deal_id'];
						 $q = "SELECT `offerid`, `merchantid`, `startdate`, `enddate`, `offername`, `category`, `normalprice`, `discount`, `photopath`, `priceafterdiscount`, `latitude`, `longitude`, `location`, `description`, `term_condition`, `date`, `status` FROM `offers` WHERE status = 10 AND offerid != $dealid";
				  	 }
				}else{	
				$q = "SELECT `offerid`, `merchantid`, `startdate`, `enddate`, `offername`, `category`, `normalprice`, `discount`, `photopath`, `priceafterdiscount`, `latitude`, `longitude`, `location`, `description`, `term_condition`, `date`, `status` FROM `offers` WHERE status = 10";
				}
			}else{
				$deals=array();
		 		}	
		}
		else if($userid != "")
		{
			$sql="SELECT * FROM user_promocode WHERE user_id='$userid'";
			$result=mysql_query($sql) or die(mysql_error());
			if(mysql_num_rows($result) > 0)
			{
				 while($row = mysql_fetch_assoc($result)) {
					 $dealid = $row['deal_id'];
					 $q = "SELECT `offerid`, `merchantid`, `startdate`, `enddate`, `offername`, `category`, `normalprice`, `discount`, `photopath`, `priceafterdiscount`, `latitude`, `longitude`, `location`, `description`, `term_condition`, `date`, `status` FROM `offers` WHERE status = 10 AND offerid != $dealid";
			  } 
			
			}else{	
				$q = "SELECT `offerid`, `merchantid`, `startdate`, `enddate`, `offername`, `category`, `normalprice`, `discount`, `photopath`, `priceafterdiscount`, `latitude`, `longitude`, `location`, `description`, `term_condition`, `date`, `status` FROM `offers` WHERE status = 10";
				}
		}
		  $res = mysql_query($q);
		  if(mysql_num_rows($res) > 0)
		  {	
			  while($deal = mysql_fetch_assoc($res)) {
				   $deals[] = array('deal'=>$deal);
			  } 
		  }else{
				$deals=array();
		  }
	       
		header('Content-type: application/json');     
		echo json_encode(array('deals'=>$deals));	  
}

function UserTeirStatus()
{
	$obj=new funcs_code();
	$obj->connection();
	$userid = 0; 		
	if(isset($_GET["userid"]))
	{
	    $userid = $_GET["userid"];
		$pageno=-1;
		if(isset($_GET["page"])){
			$pageno=$_GET["page"];
		}
		$pagesize=10;
		if(isset($_GET["pagesize"])){
			$pagesize=$_GET["pagesize"];
		} 
			$q = "SELECT * FROM `user` WHERE `id` = $userid";
			$resdetail = mysql_query($q);	
			if(mysql_num_rows($resdetail) > 0)
			{
			  $rowdetail = mysql_fetch_assoc($resdetail);
			  $fbuserid = $rowdetail['fbuserid'];
			  $q = "SELECT * FROM `friend_request` WHERE `fbparentid` = $fbuserid";
			  $res = mysql_query($q);
			  if(mysql_num_rows($res) > 0)
			  {	
				  if(mysql_num_rows($res) <= 5){
					  $tiers[] = array('tier'=>'1');
					  }
				  else if(mysql_num_rows($res) <= 15){
				  	  $tiers[] = array('tier'=>'2');
				  }else{
					  $tiers[] = array('tier'=>'3');
					  }
			  }else{
					$tiers=array();
			  }	
			}else{
					$tiers=array();
			  }	
	       
		header('Content-type: application/json');     
		echo json_encode(array('tiers'=>$tiers));
	}else{
		header('Content-type: application/json');     
		echo json_encode(array('tiers'=>array()));
	}	  
}

function GetWatchList()
{
	$obj=new funcs_code();
	$obj->connection();
	$userid = 0; 		
	if(isset($_GET["userid"]))
	{
	    $userid = $_GET["userid"];
		$pageno=-1;
		if(isset($_GET["page"])){
			$pageno=$_GET["page"];
		}
		$pagesize=10;
		if(isset($_GET["pagesize"])){
			$pagesize=$_GET["pagesize"];
		} 
			$q = "SELECT * FROM `watchlist` WHERE `Userid` = $userid";
			$resdetail = mysql_query($q);	
			  if(mysql_num_rows($resdetail) > 0)
			  {	
				  while($watchlist = mysql_fetch_assoc($resdetail)) {
					   $watchlists[] = array('watchlist'=>$watchlist);
				  } 
			  }else{
					$watchlists=array();
			  }		
	       
		header('Content-type: application/json');     
		echo json_encode(array('watchlists'=>$watchlists));
	}else{
		header('Content-type: application/json');     
		echo json_encode(array('watchlists'=>array()));
	}	  
}

function AddToWatchList()
{
	$obj=new funcs_code();
	$obj->connection();
	$userid = 0; 
	$id = 0;
	$dealid = 0;		
	if(isset($_GET["userid"]))
	{
	    $userid = $_GET["userid"];
	}
	if(isset($_GET["id"]))
	{
	    $id = $_GET["id"];
	}
	if(isset($_GET["dealid"]))
	{
	    $dealid = $_GET["dealid"];
	}
		if($id != "")
		{
			$q = "SELECT * FROM `watchlist` WHERE `Userid` = $id AND Dealid = $dealid";
			$resdetail = mysql_query($q);	
			  if(mysql_num_rows($resdetail) == 0)
				{	
					$q = "INSERT INTO `watchlist`(`id`, `Userid`, `Dealid`, `date`) VALUES ('','$id','$dealid',now())";
					if(mysql_query($q))
					{
						$listid = mysql_insert_id();
						$q = "SELECT * FROM `watchlist` WHERE `id` = $listid";
						$resdetail = mysql_query($q);	
						  if(mysql_num_rows($resdetail) > 0)
						  {	
							  while($watchlist = mysql_fetch_assoc($resdetail)) 
							  {
								   $watchlists[] = array('watchlist'=>$watchlist);
							  } 
						  }else{
								$watchlists=array();
						  }	
					}else{
							$watchlists=array();
						  }
				}else
				{
					$q = "UPDATE `watchlist` SET `date`=now() WHERE Userid = $id AND Dealid = $dealid";
					if(mysql_query($q))
					{
						$que = "SELECT * FROM `watchlist` WHERE Userid = $id AND Dealid = $dealid";
						$resdetail = mysql_query($que);	
						while($watchlist = mysql_fetch_assoc($resdetail)) 
						  {
							   $watchlists[] = array('watchlist'=>$watchlist);
						  }
					}else{
							$watchlists=array();
						  }
				}
		}
		else if($userid != "")
		{
			$query = "SELECT * FROM `user` WHERE fbuserid = $userid"; 
			$res = mysql_query($query) or die(mysql_error());
			  if(mysql_num_rows($res) > 0)
				{
					$rowdetail = mysql_fetch_assoc($res);
					$id = $rowdetail['id'];
					$q = "SELECT * FROM `watchlist` WHERE `Userid` = $id";
					$resdetail = mysql_query($q);	
					  if(mysql_num_rows($resdetail) == 0)
						{	
							$q = "INSERT INTO `watchlist`(`id`, `Userid`, `Dealid`, `date`) VALUES ('','$id','$dealid',now())";
							if(mysql_query($q) or die(mysql_error()))
							{
								$id = mysql_insert_id();
								echo $q = "SELECT * FROM `watchlist` WHERE `id` = $id";
								$resdetail = mysql_query($q);	
								  if(mysql_num_rows($res) > 0)
								  {	
									  while($watchlist = mysql_fetch_assoc($res)) 
									  {
										   $watchlists[] = array('watchlist'=>$watchlist);
									  } 
								  }else{
										$watchlists=array();
								  }	
							}else{
									$watchlists=array();
								  }
						}else
						{
							$q = "UPDATE `watchlist` SET `date`=now() WHERE Userid = $id AND Dealid = $dealid";
							mysql_query($q);
							$que = "SELECT * FROM `watchlist` WHERE `id` = $id";
							$resdetail = mysql_query($que);	
							while($watchlist = mysql_fetch_assoc($resdetail)) 
							  {
								   $watchlists[] = array('watchlist'=>$watchlist);
							  }
						}
				}else{
							$watchlists=array();
					}
		}
	       
		header('Content-type: application/json');     
		echo json_encode(array('watchlist'=>$watchlists));
}

function GetAppVersion()
{
    $obj=new funcs_code();
    $obj->connection();	
    $output = "";
    $version = "";
    $devicetype = "ios";
    $response = array();	
    if(isset($_GET["version"]))
    {   
       $version = $_GET["version"];
    } 
    if(isset($_GET["devicetype"]))
    {   
       $devicetype = $_GET["devicetype"];
    }
    $q = "SELECT * FROM appversion WHERE devicetype = '$devicetype' order by id desc limit 1";
    $res=mysql_query($q);    		
    if(mysql_num_rows($res) > 0)
    {
        $row = mysql_fetch_assoc($res);
        if($row["version"] <= $version)
        {
           $response["valid"] = "true";	
           $response["url"] = $row["url"];
           $response["message"] = $row["message"];
        }	
        else
        {
           $response["valid"] = "false";	
           $response["url"] = $row["url"];
           $response["message"] = $row["message"];
        }		    			   
    }    
    $output = $response;  
    echo json_encode($output);
}

function iOSPushNotification($deviceToken, $message)
{
	echo $deviceToken = $_GET['deviceToken'];
	echo $message = $_GET['message'];
    $passphrase = "";
    $payload['aps'] = array(
        'alert' => $message,
        'badge' => 1,
        'sound' => 'default'
    );  
    $payload = json_encode($payload);
    $apnsHost = 'gateway.sandbox.push.apple.com';
    $apnsPort = 2195;
    //$apnsCert = '../../intlfacesapns.pem';
	$apnsCert = '../../RetirelyCertificates-pro.pem';
    $streamContext = stream_context_create();
    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
    stream_context_set_option($streamContext, 'ssl', 'passphrase', $passphrase);
    $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort,         $error,$errorString,60,STREAM_CLIENT_CONNECT,$streamContext);
    $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', $deviceToken) . chr(0) . chr(strlen($payload)) . $payload;
    fwrite($apns, $apnsMessage);
    @socket_close($apns);
    fclose($apns);
}

function androidpushnotification($deviceToken , $message)
{
		$deviceToken = $_GET['deviceToken'];
		$message = 'Congrats your requested amount has been paid';
		
        $registatoin_ids[0] = $deviceToken;
        $GOOGLE_API_KEY = "AIzaSyCmQebbiNodAp0wZnQxmRRaNWG49q7oTRs";
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => array("message" => $message),
         );
        $headers = array(
            'Authorization: key=' . $GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
          ('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        //echo $result;
}
