<?php 
session_start();
if($_SESSION["myusername"]=="" && $_SESSION["mypassword"]=="")
{
header("location:index.php");
} 
include('in_header.php');
if(isset($_REQUEST['task']) && $_REQUEST['task']=='delete' && $_REQUEST['id']!='' )
   {
        $sql="DELETE FROM `categories` WHERE `id`=".$_REQUEST['id'];
if(mysql_query($sql))
   {
	    
	?>
	<script>
		window.location.href = 'category.php';
	</script>
	 <?php 
   }
 
 }
?>
	<div class="container content-wrapper">
		<div class="clearfix content-left">
            <div class="section-header">
                <h1 class="clearfix section-title"><span class="fa fa-shield title-ic"></span>Manage Categories<a id="btn-add" href="addcategory.php" class="btn btn-primary btn-main">Add Category</a></h1>
            </div> <!--section-header-->
            
            <div class="section-data">
                <div class="stats-block">
                    <div class="item-stats item1">
                        <h3 class="lead-title">550</h3>
                        <p>Hotels</p>
                    </div> <!--item-stats-->
                    
                    <div class="item-stats item2">
                        <h3 class="lead-title">550</h3>
                        <p>iOS Apps</p>
                    </div> <!--item-stats-->
                    
                    <div class="item-stats item3">
                        <h3 class="lead-title">550</h3>
                        <p>Restaurants</p>
                    </div> <!--item-stats-->
                    
                    <div class="item-stats item4">
                        <h3 class="lead-title">550</h3>
                        <p>Schools</p>
                    </div> <!--item-stats-->
                </div> <!--stats-block-->
                
            	<div class="data-block" style="display:none;">
                    <h2 class="block-title"><span class="fa fa-search title-ic"></span>Search</h2>
                    <form class="add-padding">
                        <div class="form-group inline-group">
                            <label for="org-name">Name/Location:</label>
                            <input type="text" required name="org-name">
                        </div> <!--form-group-->
                        <div class="form-group inline-group">
                            <label for="org-category">Category:</label>
                            <div class="select-element">
                                <div class="fa fa-caret-down drop-ic"></div> <!--drop-ic-->
                                <div class="select-control">
                                    <select name="org-category">
                                        <option>-- Select --</option>
                                        <option>All</option>
                                        <option>Hotel</option>
                                    </select>
                                </div> <!--select-control-->
                            </div> <!--select-element-->
                        </div> <!--form-group-->
                        <div class="form-button">
                            <button type="submit" name="submit" class="btn btn-primary btn-main">Search</button>
                        </div> <!--form-button-->
                    </form>
                </div> <!--data-block-->            
            	<div class="table-responsive data-block">
                	<h2 class="block-title"><span class="fa fa-bars title-ic"></span>Category List</h2>
                    <div class="add-padding">
                        <table class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-sm-5">Category Name</th>                                    
                                    <th class="col-sm-1">Action</th>
                                </tr>
                            </thead>
							<tbody>
							<?php
								$sql ="SELECT * FROM categories";
								$pager = new PS_Pagination($conn, $sql,100, 20, "param1=value1&param2=value2");
								$pager->setDebug(true);
								$rs1 = $pager->paginate();	
								if($rs1)
								{
								    $i=0;
									while($row = mysql_fetch_array($rs1))   
								    {
										$i=$i+1;								
							 ?>
                                <tr>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td>
                                        <ul class="clearfix action-btns">
                                            <li><a href="addcategory.php?id=<?php echo $row['id']; ?>" title="Edit" class="fa fa-edit"></a></li>
                                            <li><a href="category.php?task=delete&id=<?php echo $row['id']; ?>" title="Delete" class="fa fa-trash-o" onclick="return confirm('Are you sure? You want to delete this category?');"></a></li>
                                        </ul>
                                    </td>
                                </tr>
							<?php } } ?>
                            </tbody>
                        </table>                                        
                        <div class="right">
                        <ul class="pagination">
							<?php echo $pager->renderFullNav()?>
                            </ul>
                            <ul class="pagination" style="display:none;">
                                <li><a href="#">First</a></li>
                                <li><a href="#" class="fa fa-angle-double-left"></a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#" class="fa fa-angle-double-right"></a></li>
                                <li><a href="#">Last</a></li>
                            </ul>
                        </div>
                    </div> <!--add-padding-->
               </div> <!--data-block-->
            </div> <!--section-data-->
        </div> <!--content-left-->        
    </div> <!--container-->
<?php include('in_footer.php'); ?> 