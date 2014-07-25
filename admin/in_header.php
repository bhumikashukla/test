<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="MoniCircle">
    <link rel="shortcut icon" href="images/favicon.png">
    <title>BLC | Admin Dashboard</title>
    <link href="css/style.css" rel="stylesheet">
     <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<?php include('config.php');
include_once("ps_pagination.php");?>

</head>
<body>
<?php if(isset($_SESSION["admin_id"]) != ""){?>
<div class="container">    	
        <div class="header fixed-top page-head">
        	<div class="clearfix">
            	<div class="clearfix head-content-left">
                    <div class="logo">
                        <span class="brand"></span>
                    </div> <!--logo-->
                    <div class="mobile-menu" id="menu"><span></span></div> <!--mobile-menu-->
                </div> <!--head-content-left-->
                <div class="head-content-right">
                    <div class="right user-block">						
                        <p>Welcome, <span id="user">Admin</span></p>
                        <a href="logout.php">Logout</a>						
                    </div> <!--user-block-->
                </div> <!--head-content-right-->
            </div>
        </div>
        	
    </div> <!--container-->
  
	<div class="navigation">
    	<div class="nav-block">
    	<ul class="nav-elements">
			<?php 
				$url1= $_SERVER['REQUEST_URI'];				
				$sub_url=explode('/',$url1);
				$size = sizeof($sub_url);
				$page_name =$sub_url[sizeof($sub_url)-1];
				$page_name = explode('?',$page_name);
				$page_name = $page_name[0];

			?>
        	<li><a href="users.php" <?php if($page_name == "users.php" || $page_name == "addmembers.php") { ?>class="active-nav" <?php } ?>>
            <span class="fa fa-user nav-ic"></span> Manage Members 
            <span class="fa fa-angle-right arrow"></span></a>
            </li>
            <li><a href="parents.php" <?php if($page_name == "parents.php" || $page_name == "addparents.php") { echo ''; ?>class="active-nav" <?php } ?>>
            <span class="fa fa-tasks nav-ic"></span>Manage Parents 
             <span class="fa fa-angle-right arrow"></span>
             </a>
            </li>
            <li><a href="book_list.php" <?php if($page_name == "book_list.php" || $page_name == "addbooks.php") { ?>class="active-nav" <?php } ?>>
            <span class="fa fa-shield nav-ic"></span> Manage Books 
            <span class="fa fa-angle-right arrow"></span>
            </a>
            </li>
            <li><a href="book_transaction.php" <?php if($page_name == "book_transaction.php" || $page_name == "addtransactions.php") { ?>class="active-nav" <?php } ?>>
            <span class="fa fa-star nav-ic"></span> Manage Transactions 
            <span class="fa fa-angle-right arrow"></span>
            </a>
            </li>
            
            <li><a href="book_reading_status.php" <?php if($page_name == "book_reading_status.php" || $page_name == "addreadingstatus.php") { ?>class="active-nav" <?php } ?>>
            <span class="fa fa-briefcase nav-ic"></span> Manage Reading Status 
            <span class="fa fa-angle-right arrow"></span>
            </a>
            </li>
            <!--<li><a href="trackorder.php" <?php //if($page_name == "trackorder.php") { ?>class="active-nav" <?php //} ?>><span class="fa fa-bar-chart-o nav-ic"></span> Settings <span class="fa fa-angle-right arrow"></span></a></li>-->
            <?php } ?>
        </ul>
        </div>
    </div> <!--navigation-->