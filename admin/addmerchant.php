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
	$error = AddMerchant();
}
?>
<div class="container content-wrapper">
		<div class="clearfix content-left">
            <div class="section-header">
                <h1 class="clearfix section-title"><span class="fa fa-edit title-ic"></span>Add Merchant <a id="btn-add" href="merchants.php" class="btn btn-primary btn-main">View Merchants List</a></h1>
            </div> <!--section-header-->            
            <div class="section-data">
            	<div class="data-block set-width">
                    <form method="post" enctype="multipart/form-data" class="add-padding">
                        <div class="form-group">
                            <label for="username">User Name:<span>*</span></label>
                            <input type="text" id="username" name="username" required/>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="location">Email:<span>*</span></label>
                            <input type="email" id="email" name="email" required email />
                        </div> <!--form-group-->						
						<div class="form-group">
                            <label for="description">Password:<span>*</span></label>
                            <input type="password" name="password" id="password" required>
                        </div> <!--form-group-->
						<div class="form-group">
                            <label for="org-category">Orgnization:<span>*</span></label>							
                            <div class="select-element"> 
                                <div class="fa fa-caret-down drop-ic"></div> <!--drop-ic-->
                                <div class="select-control">									
									<select name="orgnization" id="orgnization" class="maxwidth" required>
										<option value="">Select Orgnization</option>
										<?php
											$res = mysql_query("select * from organizations");
											while($rows = mysql_fetch_array($res)){
											?>
											<option value="<?php echo $rows['id']; ?>"><?php echo $rows['name'] ; ?></option>
										<?php
											}
										?>
									</select>                                    
                                </div> <!--select-control-->
                            </div> <!--select-element-->
                        </div> <!--form-group-->						
                        <div class="right">
                            <a href="merchants.php" id="btn-cancel" class="btn btn-primary btn-main">Cancel</a>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-main">submit</button>
                        </div><br />
						<?php if(isset($error)){echo "<P>".$error."</p>";}?>
                    </form>
                </div>
            </div>
        </div> <!--content-left-->
    </div> <!--container-->
<?php include('in_footer.php'); ?>