<?php 
	session_start();
	if($_SESSION["myusername"]=="" && $_SESSION["mypassword"]=="")
	{
	header("location:index.php");
	} 
	include('in_header.php');
	$user_promocode="select * from 	user_promocode";
	$result_promocode=mysql_query($user_promocode) or die (mysql_error());

	?>
		<div class="container content-wrapper">
		<div class="clearfix content-left">
            <div class="section-header">
                <h1 class="clearfix section-title"><span class="fa fa-shield title-ic"></span>Users</h1>
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
                	<h2 class="block-title"><span class="fa fa-bars title-ic"></span> User List</h2>
                    <div class="add-padding">
                        <table class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-sm-2">First Name</th>
                                    <th class="col-sm-2">Last Name</th>
                                    <th class="col-sm-4">Email</th>
                                    <th class="col-sm-2">Promocode</th>
                                    <th class="col-sm-3">Deal</th>
                                </tr>
                            </thead>
							<tbody>
							  <tr>
                              <?php 
							     while($row=mysql_fetch_row($result_promocode))
								 {
									  $user_id=$row[2];
									 $deal_id=$row[1];									 
				                     $user_detail= "select * from user where fbuserid = '$user_id'";
									 $user_result=mysql_query($user_detail) or die(mysql_error());
									 $deal="select * from offers where offerid=$deal_id";
									 $deal_result=mysql_query($deal) or die(mysql_error());
									 $row2=mysql_fetch_array($deal_result);
									 
									  while($row1=mysql_fetch_array($user_result))
									  {
							  ?> <tr>
                                    <td><?php echo $row1["2"]; ?></td>
                                    <td><?php echo $row1["3"]; ?></td>
                                    <td><?php echo $row1["4"];?></td>
                                    <td><?php echo $row[3]; ?></td>
                                    <td><?php echo $row2[4];?></td>
                                  </tr>
                                  <?php }?>
								  <?php  }?>  
                                    <td></td>
                                    <td>
                                       <?php /*?> <ul class="clearfix action-btns">                                            
                                            <li><a href="users.php?task=delete&id=<?php echo $row['userid']; ?>" title="Delete" class="fa fa-trash-o" onclick="return confirm('Are you sure? You want to delete this user?');"></a></li>
                                        </ul><?php */?>
                                    </td>
                                </tr>
							
                            </tbody>
                        </table>                                        
                        <div class="right">
                        <ul class="pagination">
							<?php //echo $pager->renderFullNav()?>
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