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

	$error = AddEditReadingStatus();
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
	

$str="SELECT * FROM book_reading_status WHERE id = $id";
$result=mysql_query($str);
$rn = mysql_num_rows($result);
if($rn!="0")
{
	$row = mysql_fetch_assoc($result);
	$id = $row["id"];
	$member_id = $row["member_id"];
    $book_id = $row["book_id"];
	$start_date = $row["start_date"];
    $end_date = $row["end_date"];
	$total_reading_days = $row["total_reading_days"];
	$level = $row["level"];
	$word_count = $row["word_count"];
	$points = $row["points"];
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
function treatAsUTC(date) {
    var result = new Date(date);
    result.setMinutes(result.getMinutes() - result.getTimezoneOffset());
    return result;
}

function daysBetween(startDate, endDate) {
    var millisecondsPerDay = 24 * 60 * 60 * 1000;
    return (treatAsUTC(endDate) - treatAsUTC(startDate)) / millisecondsPerDay;
}

function total_days(){
	//var normalprice = $('#normalprice').val();
	//var discount = $('#discount').val();
	var datepicker1 = $('#datepicker1').val(); 
	var datepicker = $('#datepicker').val();
	count = daysBetween($('#datepicker').val(), $('#datepicker1').val()); 
	//alert(count);
	//alert(daydiff(parseDate(datepicker1), parseDate(datepicker)));
	$('#startdate').val(datepicker);
	$('#enddate').val(datepicker1);
	$('#totaldays').val(count);
	//var normalprice = parseInt(normalprice);
	//var discount = parseInt(discount);
	
	//var priceafterdiscount = ((normalprice * discount) / 100);
	//var dics_price = normalprice - priceafterdiscount;
	//$('#priceafterdiscount').val(dics_price);
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
                <h1 class="clearfix section-title"><span class="fa fa-edit title-ic"></span>Add book reading status <a id="btn-add" href="book_reading_status.php" class="btn btn-primary btn-main">View book reading status List</a></h1>
            </div> <!--section-header-->            
            <div class="section-data">
            	<div class="data-block set-width">
                    <form method="post" enctype="multipart/form-data" class="add-padding">
                    <?php if(isset($error)){echo "<P>".$error."</p>";}?>
                        <div class="form-group">
                            <label for="org-category">Member Name:<span>*</span></label>							
                            <div class="select-element"> 
                                <div class="fa fa-caret-down drop-ic"></div> <!--drop-ic-->
                                <div class="select-control">
									<?php $merchants_rows=mysql_query("select id , member_name from members_list") ; ?>
									<select name="member" id="member" class="maxwidth" required>
										<option value="" disabled="disabled" selected="selected">Select Member</option>
										<?php while($mer=mysql_fetch_array($merchants_rows)) { ?>
									   <option value="<?php echo $mer["id"]; ?>"><?php echo $mer['member_name']; ?></option>
									   <?php } ?>
									</select>                                    
                                </div> <!--select-control-->
                            </div> <!--select-element-->
                        </div> <!--form-group-->	
                        
                        <div class="form-group">
                            <label for="org-category">Book Name:<span>*</span></label>							
                            <div class="select-element"> 
                                <div class="fa fa-caret-down drop-ic"></div> <!--drop-ic-->
                                <div class="select-control">
									<?php $merchants_rows=mysql_query("select id , book_name from book_list") ; ?>
									<select name="booklist" id="booklist" class="maxwidth" required>
										<option value="" disabled="disabled" selected="selected">Select Book</option>
										<?php while($mer=mysql_fetch_array($merchants_rows)) { ?>
									   <option value="<?php echo $mer["id"]; ?>"><?php echo $mer['book_name']; ?></option>
									   <?php } ?>
									</select>                                    
                                </div> <!--select-control-->
                            </div> <!--select-element-->
                        </div> <!--form-group-->
                        	
                        <div class="form-group">
                            <label for="discount">Start Date :<span>*</span></label>
                            <input type="text" name="datepicker" id="datepicker"required>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">End Date :<span>*</span></label>
                            <input type="text" name="datepicker1" id="datepicker1" onchange="total_days();" required>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">Total Reading Days:<span>*</span></label>
                            <input type="text" id="totaldays" name="totaldays" required />
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">Book complexity:<span>*</span></label>
                            <input type="text" id="level" name="level" required />
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">Word count:<span>*</span></label>
                            <input type="text" id="wordcount" name="wordcount" required />
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">Member points:<span>*</span></label>
                            <input type="text" id="points" name="points" required />
                        </div> <!--form-group-->
								
                        <div class="right">
                            <a href="parents.php" id="btn-cancel" class="btn btn-primary btn-main">Cancel</a>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-main">submit</button>
                        </div><br />
						<?php //if(isset($error)){echo "<P>".$error."</p>";}?>
						<input type="hidden" name="id" id="id" value="0" /> 
                        <input type="hidden" name="lat" id="lat" value="" />
                        <input type="hidden" name="lng" id="lng" value="" />
                        <input type="hidden" name="address" id="address" value="" />
                        <input type="hidden" name="startdate" id="startdate" value="" />
                        <input type="hidden" name="enddate" id="enddate" value="" />
                    </form>
                </div>
            </div>
        </div> <!--content-left-->
    </div> <!--container-->
<?php }else{?>	
	<div class="container content-wrapper">
		<div class="clearfix content-left">
            <div class="section-header">
                <h1 class="clearfix section-title"><span class="fa fa-edit title-ic"></span>Edit book reading status</h1>
            </div> <!--section-header-->            
            <div class="section-data">
            	<div class="data-block set-width">
                    <form method="post" enctype="multipart/form-data" class="add-padding">
                    <?php if(isset($error)){echo "<P>".$error."</p>";}?>
                        <div class="form-group">
                            <label for="org-category">Member Name:<span>*</span></label>							
                            <div class="select-element"> 
                                <div class="fa fa-caret-down drop-ic"></div> <!--drop-ic-->
                                <div class="select-control">
									<?php $merchants_rows=mysql_query("select id , member_name from members_list") ; ?>
									<select name="member" id="member" class="maxwidth" required>
										<option value="" disabled="disabled" selected="selected">Select Member</option>
										<?php while($mer=mysql_fetch_array($merchants_rows)) { ?>
									   <option value="<?php echo $mer["id"]; ?>"  <?php if($mer["id"] == $member_id){?> selected="selected" <?php }?>><?php echo $mer['member_name']; ?></option>
									   <?php } ?>
									</select>                                    
                                </div> <!--select-control-->
                            </div> <!--select-element-->
                        </div> <!--form-group-->	
                        
                        <div class="form-group">
                            <label for="org-category">Book Name:<span>*</span></label>							
                            <div class="select-element"> 
                                <div class="fa fa-caret-down drop-ic"></div> <!--drop-ic-->
                                <div class="select-control">
									<?php $merchants_rows=mysql_query("select id , book_name from book_list") ; ?>
									<select name="booklist" id="booklist" class="maxwidth" required>
										<option value="" disabled="disabled" selected="selected">Select Book</option>
										<?php while($mer=mysql_fetch_array($merchants_rows)) { ?>
									   <option value="<?php echo $mer["id"]; ?>"  <?php if($mer["id"] == $book_id){?> selected="selected" <?php }?>><?php echo $mer['book_name']; ?></option>
									   <?php } ?>
									</select>                                    
                                </div> <!--select-control-->
                            </div> <!--select-element-->
                        </div> <!--form-group-->
                        	
                        <div class="form-group">
                            <label for="discount">Start Date :<span>*</span></label>
                            <input type="text" name="datepicker" id="datepicker" value="<?php echo $start_date; ?>" required>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">End Date :<span>*</span></label>
                            <input type="text" name="datepicker1" id="datepicker1" onchange="total_days();" value="<?php echo $end_date; ?>" required>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">Total Reading Days:<span>*</span></label>
                            <input type="text" id="totaldays" name="totaldays" value="<?php echo $end_date; ?>" required />
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">Book complexity:<span>*</span></label>
                            <input type="text" id="level" name="level" value="<?php echo $level; ?>" required />
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">Word count:<span>*</span></label>
                            <input type="text" id="wordcount" name="wordcount" value="<?php echo $word_count; ?>" required />
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="discount">Member points:<span>*</span></label>
                            <input type="text" id="points" name="points" value="<?php echo $points; ?>" required />
                        </div> <!--form-group-->
                        <div class="right">
                            <a href="book_transaction.php" id="btn-cancel" class="btn btn-primary btn-main">Cancel</a>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-main">submit</button>
                        </div>
                        <br />
						<?php //if(isset($error)){echo "<P>".$error."</p>";}?>
						<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
                         <input type="hidden" name="startdate" id="startdate" value="<?php echo $start_date; ?>" />
                        <input type="hidden" name="enddate" id="enddate" value="<?php echo $end_date; ?>" />
                    </form>
                </div>
            </div>
        </div> <!--content-left-->
        
    </div> <!--container--> 
<?php }?>	
<?php include('in_footer.php'); ?>