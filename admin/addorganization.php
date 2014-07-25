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
	$error = AddEditOrganization();
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
$str="SELECT org.id as organizationid, org.name as orgname, org.categoryid as categoryid, org.location as location, org.description as description , org.status as status, cat.name as catname from organizations org, categories cat where cat.id = org.categoryid and org.id = $id";
$result=mysql_query($str);
$rn = mysql_num_rows($result);
if($rn!="0")
{
	$row = mysql_fetch_assoc($result);
	$id = $row["organizationid"];
	$name = $row["orgname"];
	
}
?>
<?php if($rn == "0") {?>
	<div class="container content-wrapper">
		<div class="clearfix content-left">
            <div class="section-header">
                <h1 class="clearfix section-title"><span class="fa fa-edit title-ic"></span>Add Organization <a id="btn-add" href="organizations.php" class="btn btn-primary btn-main">View Organization List</a></h1>
            </div> <!--section-header-->            
            <div class="section-data">
            	<div class="data-block set-width">
                    <form method="post" enctype="multipart/form-data" class="add-padding">
                        <div class="form-group">
                            <label for="orgname">Name:<span>*</span></label>
                            <input type="text" id="orgname" name="orgname" required/>
                        </div> <!--form-group-->						
						<div class="form-group">
                            <label for="org-category">Category:<span>*</span></label>							
                            <div class="select-element"> 
                                <div class="fa fa-caret-down drop-ic"></div> <!--drop-ic-->
                                <div class="select-control">
									<?php $categories_rows=mysql_query("select * from categories") ; ?>
									<select name="category" id="category" class="maxwidth" required>
										<option value="">Select Category</option>
										<?php while($cat=mysql_fetch_array($categories_rows)) { ?>
									   <option value="<?php echo $cat["id"]; ?>"><?php echo $cat['name']; ?></option>
									   <?php } ?>
									</select>                                    
                                </div> <!--select-control-->
                            </div> <!--select-element-->
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="location">Location:<span>*</span></label>
                            <input type="text" id="location" name="location" required />
                        </div> <!--form-group-->						
						<div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" rows="7" cols="41" style="height:100px;"></textarea>
                        </div> <!--form-group-->						
                        <div class="right">
                            <a href="organization.php" id="btn-cancel" class="btn btn-primary btn-main">Cancel</a>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-main">submit</button>
                        </div><br />
						<?php if(isset($error)){echo "<P>".$error."</p>";}?>
						<input type="hidden" name="organizationid" id="organizationid" value="0" />
                    </form>
                </div>
            </div>
        </div> <!--content-left-->
    </div> <!--container-->
<?php }else{?>	
	<div class="container content-wrapper">
		<div class="clearfix content-left">
            <div class="section-header">
                <h1 class="clearfix section-title"><span class="fa fa-edit title-ic"></span>Edit Organization</h1>
            </div> <!--section-header-->            
            <div class="section-data">
            	<div class="data-block set-width">
                    <form method="post" enctype="multipart/form-data" class="add-padding">
                        <div class="form-group">
                            <label for="orgname">Name:<span>*</span></label>
                            <input type="text" id="orgname" name="orgname" value="<?php echo $row['orgname']; ?>" required/>
                        </div> <!--form-group-->						
						<div class="form-group">
                            <label for="org-category">Category:<span>*</span></label>							
                            <div class="select-element"> 
                                <div class="fa fa-caret-down drop-ic"></div> <!--drop-ic-->
                                <div class="select-control">									
									<select name="category" id="category" class="maxwidth" required>
										<option value="">Select Category</option>
										<?php
											 $res = mysql_query("select * from categories");
											 while($rows = mysql_fetch_array($res)){
											 ?>
											 <option value="<?php echo $rows['id']; ?>" <?php if($rows['id'] == $row['categoryid']) { ?> selected="selected" <?php } ?>><?php echo $rows['name'] ; ?></option>
											 <?php
											 }
										   ?>
									</select>                                    
                                </div> <!--select-control-->
                            </div> <!--select-element-->
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="location">Location:<span>*</span></label>
                            <input type="text" id="location" name="location" value="<?php echo $row['location']; ?>" required />
                        </div> <!--form-group-->						
						<div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" rows="7" cols="41" style="height:100px;"><?php echo $row['description']; ?></textarea>
                        </div> <!--form-group-->						
                        <div class="right">
                            <a href="organization.php" id="btn-cancel" class="btn btn-primary btn-main">Cancel</a>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-main">submit</button>
                        </div><br />
						<?php if(isset($error)){echo "<P>".$error."</p>";}?>
						<input type="hidden" name="organizationid" id="organizationid" value="<?php echo $id; ?>" />
                    </form>
                </div>
            </div>
        </div> <!--content-left-->
    </div> <!--container--> 
<?php }?>	
<?php include('in_footer.php'); ?>