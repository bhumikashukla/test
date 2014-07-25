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

	$error = AddEditOffer();
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
	

$str="SELECT * FROM offers WHERE offerid = $id";
$result=mysql_query($str);
$rn = mysql_num_rows($result);
if($rn!="0")
{
	$row = mysql_fetch_assoc($result);
	$id = $row["offerid"];
	$merchantid = $row["merchantid"];
	$offername = $row["offername"];
	$discount = $row["discount"];
    $priceafterdiscount = $row["priceafterdiscount"];
	$photopath = $row["photopath"];
	$description = $row["description"];
	$startdate = $row["startdate"];
	$enddate = $row["enddate"];
	$normalprice = $row["normalprice"];
	$term_condition = $row["term_condition"];
	$location = $row["location"];
	$catid = $row["category"];
	$latitude = $row["latitude"];
	$longitude = $row["longitude"];
}


?>
<script>
$(function() {

$("#datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
$("#datepicker1" ).datepicker({dateFormat: 'yy-mm-dd' });
 /*$( "#datepicker" ).datepicker({  
	    onSelect: function (dateText, inst) {
            var date = $.datepicker.parseDate($.datepicker._defaults.dateFormat, dateText);
            $("#datepicker1").datepicker("option", "minDate", date)
            // the following is optional
            //$("#datepicker1").datepicker("setDate", date);
        }
    });*/

});
</script>

<script>
function discount_cal(){
	var normalprice = $('#normalprice').val();
	var discount = $('#discount').val();
	var datepicker1 = $('#datepicker1').val(); 
	var datepicker = $('#datepicker').val(); 
	//alert(datepicker1 +" "+datepicker);
	$('#startdate').val(datepicker);
	$('#enddate').val(datepicker1);
	var normalprice = parseInt(normalprice);
	var discount = parseInt(discount);
	
	var priceafterdiscount = ((normalprice * discount) / 100);
	var dics_price = normalprice - priceafterdiscount;
	$('#priceafterdiscount').val(dics_price);
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<script>
// This example adds a search box to a map, using the Google Place Autocomplete
// feature. People can enter geographical searches. The search box will return a
// pick list containing a mix of places and predicted search terms.

function initialize() {

  var markers = [];
  var map = new google.maps.Map(document.getElementById('map-canvas'), {
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
var dlat = $("#lat").val();
var dlng = $("#lng").val();

  var defaultBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(dlat, dlng),
      new google.maps.LatLng(dlat, dlng));
  map.fitBounds(defaultBounds);

  // Create the search box and link it to the UI element.
  var input = /** @type {HTMLInputElement} */(
      document.getElementById('pac-input'));
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  var searchBox = new google.maps.places.SearchBox(
    /** @type {HTMLInputElement} */(input));

  // [START region_getplaces]
  // Listen for the event fired when the user selects an item from the
  // pick list. Retrieve the matching places for that item.
  google.maps.event.addListener(searchBox, 'places_changed', function() {
    var places = searchBox.getPlaces();

    for (var i = 0, marker; marker = markers[i]; i++) {
      marker.setMap(null);
    }

    // For each place, get the icon, place name, and location.
    markers = [];
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, place; place = places[i]; i++) {
      var image = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      var marker = new google.maps.Marker({
        map: map,
        icon: image,
        title: place.name,
        position: place.geometry.location,
		draggable:true
      });
	  $('#lat').val(marker.position.lat());
	  $('#lng').val(marker.position.lng());
	  google.maps.event.addListener(marker, 'dragend', function() {
                      url = "https://maps.googleapis.com/maps/api/geocode/json";
                     jQuery.ajax({
                         type: "GET",
                         dataType: "json",
                         url: url,
                         data: {'latlng':marker.position.lat()+","+marker.position.lng(), "sensor":true},
                         success: function(data){
                           var addComps = data.results[0].address_components;
                           jQuery("#lat").val(data.results[0].geometry.location.lat);
                           jQuery("#lng").val(data.results[0].geometry.location.lng);
                           jQuery("#address").val(data.results[0].formatted_address);
						   jQuery("#pac-input").val(data.results[0].formatted_address); 
                           marker.setTitle(data.results[0].formatted_address);
                         },
                         error: function(err){          
                           console.log(err)
                         }
                     });
                   });

      markers.push(marker);

      bounds.extend(place.geometry.location);
    }

    map.fitBounds(bounds);
  });
  // [END region_getplaces]

  // Bias the SearchBox results towards places that are within the bounds of the
  // current map's viewport.
  google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });
}

google.maps.event.addDomListener(window, 'load', initialize);
    </script>
<?php if($rn == "0") {?>

	<div class="container content-wrapper">
		<div class="clearfix content-left">
            <div class="section-header">
                <h1 class="clearfix section-title"><span class="fa fa-edit title-ic"></span>Add Offer <a id="btn-add" href="offers.php" class="btn btn-primary btn-main">View Offers List</a></h1>
            </div> <!--section-header-->            
            <div class="section-data">
            	<div class="data-block set-width">
                    <form method="post" enctype="multipart/form-data" class="add-padding">
                    <?php if(isset($error)){echo "<P>".$error."</p>";}?>
                        <div class="form-group">
                            <label for="offername">Name:<span>*</span></label>
                            <input type="text" id="offername" name="offername" required/>
                        </div> <!--form-group-->
						<?php  
							$usertype=getUserType();
						    if($usertype!="merchant") { ?>
						<div class="form-group">
                            <label for="org-category">Marchant:<span>*</span></label>							
                            <div class="select-element"> 
                                <div class="fa fa-caret-down drop-ic"></div> <!--drop-ic-->
                                <div class="select-control">
									<?php $merchants_rows=mysql_query("select adminuserid , username from adminusers where role = 'merchant'") ; ?>
									<select name="merchantid" id="merchantid" class="maxwidth" required>
										<option value="" disabled="disabled" selected="selected">Select Merchant</option>
										<?php while($mer=mysql_fetch_array($merchants_rows)) { ?>
									   <option value="<?php echo $mer["adminuserid"]; ?>"><?php echo $mer['username']; ?></option>
									   <?php } ?>
									</select>                                    
                                </div> <!--select-control-->
                            </div> <!--select-element-->
                        </div> <!--form-group-->	
						<?php } else { ?>
							<input type="hidden" name="merchantid" id="merchantid" value="<?php echo  $_SESSION['admin_id']; ?>" /> 
						<?php }	?>  
                        <div class="form-group">
                            <label for="org-category">Category:<span>*</span></label>							
                            <div class="select-element"> 
                                <div class="fa fa-caret-down drop-ic"></div> <!--drop-ic-->
                                <div class="select-control">
									<?php $cat_rows=mysql_query("SELECT * FROM `categories`") ; ?>
									<select name="catid" id="catid" class="maxwidth" required>
										<option value="" disabled="disabled" selected="selected">Select Category</option>
										<?php while($rows=mysql_fetch_array($cat_rows)) { ?>
									   <option value="<?php echo $rows["id"]; ?>"><?php echo $rows['name']; ?></option>
									   <?php } ?>
									</select>                                    
                                </div> <!--select-control-->
                            </div> <!--select-element-->
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">Start Date :<span>*</span></label>
                            <input type="text" name="datepicker" id="datepicker" required>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">End Date :<span>*</span></label>
                            <input type="text" name="datepicker1" id="datepicker1" required>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">Normal Price ($):<span>*</span></label>
                            <input type="text" id="normalprice" name="normalprice" required />
                        </div> <!--form-group-->               
                        <div class="form-group">
                            <label for="discount">Discount(In %):<span>*</span></label>
                            <input type="text" id="discount" onchange="discount_cal();"  name="discount" required />
                        </div> <!--form-group-->
						<div class="form-group">
                            <label for="priceafterdiscount">Price After Discount ($):<span>*</span></label>
                            <input type="text" id="priceafterdiscount" name="priceafterdiscount" required />
                        </div> <!--form-group-->
						<div class="form-group">
                            <label for="priceafterdiscount">Photo:<span>*</span></label>
                            <input name="files[]" id="photo" type="file" multiple required/>
                        </div> <!--form-group-->
                        <div class="form-group">
                         <!-- <label for="priceafterdiscount">Set as feature deal:<span>*</span></label>
                              <input type="checkbox" name="feature" />-->                        
                              <label>
                                <input type="checkbox" name="feature_deal"></input> Set as feature deal
                                </label>
                        </div>
                        <div class="form-group">
                            <label for="priceafterdiscount">Map:</label>
                            <input id="pac-input" name="map_location" class="controls" type="text" placeholder="Search Box">
                            <div id="map-canvas" style="width:450px; height:300px;"></div>
                        </div> <!--form-group-->
						<div class="form-group">
                            <label for="priceafterdiscount">Description:</label>
                            <textarea name="description" id="description" rows="7" cols="41" style="height:100px;"></textarea>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="priceafterdiscount">Term & Condition:</label>
                            <textarea name="tc" id="tc" rows="7" cols="41" style="height:100px;"></textarea>
                        </div> <!--form-group-->						
                        <div class="right">
                            <a href="offers.php" id="btn-cancel" class="btn btn-primary btn-main">Cancel</a>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-main">submit</button>
                        </div><br />
						<?php //if(isset($error)){echo "<P>".$error."</p>";}?>
						<input type="hidden" name="offerid" id="offerid" value="0" /> 
						<input type="hidden" name="oldphotopath" id="oldphotopath" value="" />
                        <input type="hidden" name="startdate" id="startdate" value="" />
                        <input type="hidden" name="enddate" id="enddate" value="" />
                        <input type="hidden" name="lat" id="lat" value="" />
                        <input type="hidden" name="lng" id="lng" value="" />
                        <input type="hidden" name="address" id="address" value="" />
                    </form>
                </div>
            </div>
        </div> <!--content-left-->
    </div> <!--container-->
<?php }else{?>	
	<div class="container content-wrapper">
		<div class="clearfix content-left">
            <div class="section-header">
                <h1 class="clearfix section-title"><span class="fa fa-edit title-ic"></span>Edit Offer</h1>
            </div> <!--section-header-->            
            <div class="section-data">
            	<div class="data-block set-width">
                    <form method="post" enctype="multipart/form-data" class="add-padding">
                    <?php if(isset($error)){echo "<P>".$error."</p>";}?>
                        <div class="form-group">
                            <label for="offername">Name:<span>*</span></label>
                            <input type="text" id="offername" name="offername" value="<?php echo $offername; ?>" required/>
                        </div> <!--form-group-->	
                        <div class="form-group">
                            <label for="discount">Start Date :<span>*</span></label>
                            <input type="text" name="datepicker" id="datepicker" value="<?php echo $startdate; ?>"  required>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">End Date :<span>*</span></label>
                            <input type="text" name="datepicker1" id="datepicker1" value="<?php echo $enddate; ?>"  required>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">Normal Price ($):<span>*</span></label>
                            <input type="text" id="normalprice" name="normalprice" required value="<?php echo $normalprice; ?>" />
                        </div> <!--form-group-->               					                 
                        <div class="form-group">
                            <label for="discount">Discount(In %):<span>*</span></label>
                            <input type="text" id="discount" name="discount" onchange="discount_cal();" value="<?php echo $discount; ?>" required />
                        </div> <!--form-group-->
						<div class="form-group">
                            <label for="priceafterdiscount">Price After Discount:<span>*</span></label>
                            <input type="text" id="priceafterdiscount" name="priceafterdiscount" value="<?php echo $priceafterdiscount; ?>" required />
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="priceafterdiscount">Map:</label>
                            <input id="pac-input" name="map_location" class="controls" type="text" placeholder="Search Box" value="<?php echo $location;?> ">
                            <div id="map-canvas" style="width:450px; height:300px;"></div>
                        </div> <!--form-group-->
						<div class="form-group">
                        
                            <label for="photo">Photo:<span>*</span></label>
                            <input name="photo[]" id="photo" type="file"  multiple required/><br />
                            <?php 
							$file= "select * from file where offer_id= $id";
							$result_file=mysql_query($file)or die(mysql_error());
							while( $row_file=mysql_fetch_array($result_file)){
							echo "<img src='$row_file[FILE_NAME]' width='40px' height='40px'/>" 
							;}?>
                         </div> 
                         <div class="form-group">
                            <label>
                                <input type="checkbox" name="feature_deal_update"></input> Set as feature deal
                                </label>

                        
						<div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" rows="7" cols="41" style="height:100px;"><?php echo $description; ?></textarea>
                        </div> <!--form-group-->	
                        <div class="form-group">
                            <label for="priceafterdiscount">Term & Condition:</label>
                            <textarea name="tc" id="tc" rows="7" cols="41" style="height:100px;"><?php echo $term_condition; ?></textarea>
                        </div> <!--form-group-->						
                        <div>
                       <input type="hidden" name="catid" value="<?php echo $catid  ;?>" />
                       
                         
                        </div>
                        <div class="right">
                            <a href="offers.php" id="btn-cancel" class="btn btn-primary btn-main">Cancel</a>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-main">submit</button>
                        </div>
                        <br />
						<?php //if(isset($error)){echo "<P>".$error."</p>";}?>
						<input type="hidden" name="offerid" id="offerid" value="<?php echo $id; ?>" />
						<input type="hidden" name="merchantid" id="merchantid" value="<?php echo $merchantid; ?>" />  			
						<input type="hidden" name="oldphotopath" id="oldphotopath" value="<?php echo $photopath; ?>" />
                        <input type="hidden" name="lat" id="lat" value="<?php echo $latitude; ?>" />
                        <input type="hidden" name="lng" id="lng" value="<?php echo $longitude; ?>" />
                         <input type="hidden" name="startdate" id="startdate" value="" />
                        <input type="hidden" name="enddate" id="enddate" value="" />
                    </form>
                </div>
            </div>
        </div> <!--content-left-->
        
    </div> <!--container--> 
<?php }?>	
<?php include('in_footer.php'); ?>