<?php 
session_start();
if($_SESSION["myusername"]=="" && $_SESSION["mypassword"]=="")
{
	header("location:index.php");
} 
include('in_header.php');
include('function.php');
$error='';
if(isset($_POST["submit"])=="Submit")
{
	$error = AddEditCategory();
}
?>
<?php
if(isset($_GET["id"]) != "")
{
	$id = $_GET["id"];
}
else
{
	$id = 0;
}
$str="SELECT * FROM categories WHERE id = $id";
$result=mysql_query($str);
$rn = mysql_num_rows($result);
if($rn!="0")
{
	$row = mysql_fetch_assoc($result);
	$id = $row["id"];
	$name = $row["name"];
	
}
?>
<?php if($rn == "0") {?>
<div class="container content-wrapper">
		<div class="clearfix content-left">
            <div class="section-header">
                <h1 class="clearfix section-title"><span class="fa fa-edit title-ic"></span>Add Category <a id="btn-add" href="category.php" class="btn btn-primary btn-main">View Category List</a></h1>
            </div> <!--section-header-->            
            <div class="section-data">
            	<div class="data-block set-width">
                    <form method="post" enctype="multipart/form-data" class="add-padding">
                        <div class="form-group">
                            <label for="catname">Name:<span>*</span></label>
                            <input type="text" id="catname" name="catname" value="" required/>
                        </div> <!--form-group-->
                        <div class="right">
                            <a href="category.php" id="btn-cancel" class="btn btn-primary btn-main">Cancel</a>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-main">submit</button>
                        </div><br />
						<?php if(isset($error)){echo "<P>".$error."</p>";}?>
						<input type="hidden" name="catid" id="catid" value="0" />
                    </form>
                </div>
            </div>
        </div> <!--content-left-->
    </div> <!--container--> 
<?php }else{?>	
	<div class="container content-wrapper">
		<div class="clearfix content-left">
            <div class="section-header">
                <h1 class="clearfix section-title"><span class="fa fa-edit title-ic"></span>Edit Category</h1>
            </div> <!--section-header-->            
            <div class="section-data">
            	<div class="data-block set-width">
                    <form method="post" enctype="multipart/form-data" class="add-padding">
                        <div class="form-group">
                            <label for="catname">Name:<span>*</span></label>
                            <input type="text" id="catname" name="catname" value="<?php echo $name; ?>" required/>
                        </div> <!--form-group-->
                        <div class="right">
                            <a href="category.php" id="btn-cancel" class="btn btn-primary btn-main">Cancel</a>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-main">submit</button>
                        </div><br />
						<?php if(isset($error)){echo "<P>".$error."</p>";}?>
						<input type="hidden" name="catid" id="catid" value="<?php echo $id; ?>" />
                    </form>
                </div>
            </div>
        </div> <!--content-left-->
    </div> <!--container--> 
<?php }?>	
<?php include('in_footer.php'); ?>