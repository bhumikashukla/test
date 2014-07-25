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
	

$str="SELECT * FROM members_list WHERE id = $id";
$result=mysql_query($str);
$rn = mysql_num_rows($result);
if($rn!="0")
{
	$row = mysql_fetch_assoc($result);
	$id = $row["id"];
	$member_name = $row["member_name"];
	$mother_name = $row["mother_name"];
	$father_name = $row["father_name"];
    $mother_phone = $row["mother_phone"];
	$father_phone = $row["father_phone"];
	$member_dob	 = $row["member_dob"];
	$member_age = $row["member_age"];
	$member_class = $row["member_class"];
	$member_school = $row["member_school"];
	$club_id = $row["club_id"];
	$location = $row["location"];
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
function treatAsUTC(date) {
    var result = new Date(date);
    result.setMinutes(result.getMinutes() - result.getTimezoneOffset());
    return result;
}

function daysBetween(startDate, endDate) {
    var millisecondsPerDay = 24 * 60 * 60 * 1000;
    return (treatAsUTC(endDate) - treatAsUTC(startDate)) / millisecondsPerDay;
}
function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}
function date_cal()
{	
	startdate = $('#datepicker1').val();
	//alert(getAge(startdate));
	$('#memberage').val(getAge(startdate));
	/*var normalprice = $('#normalprice').val();
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
	$('#priceafterdiscount').val(dics_price);*/
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
                <h1 class="clearfix section-title"><span class="fa fa-edit title-ic"></span>Add member <a id="btn-add" href="users.php" class="btn btn-primary btn-main">View members List</a></h1>
            </div> <!--section-header-->            
            <div class="section-data">
            	<div class="data-block set-width">
                    <form method="post" enctype="multipart/form-data" class="add-padding">
                    <?php if(isset($error)){echo "<P>".$error."</p>";}?>
                        <div class="form-group">
                            <label for="offername">Member's Name:<span>*</span></label>
                            <input type="text" id="membername" name="membername" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Father's Name:<span>*</span></label>
                            <input type="text" id="fathername" name="fathername" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Mother's Name:<span>*</span></label>
                            <input type="text" id="mothername" name="mothername" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Father's Phone:<span>*</span></label>
                            <input type="text" maxlength="10" id="fatherphone" pattern="[0-9]*" name="fatherphone" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Mother's Phone:<span>*</span></label>
                            <input type="text" id="motherphone" maxlength="10" pattern="[0-9]*" name="motherphone" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Member's DOB:<span>*</span></label>
                            <input type="text" name="memberdob" id="datepicker1" onchange="date_cal()" required>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="offername">Member's Age:<span>*</span></label>
                            <input type="text" id="memberage"  name="memberage" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Member's Class:<span>*</span></label>
                            <input type="text" id="memberclass" name="memberclass" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Member's School:<span>*</span></label>
                            <input type="text" id="memberschool" name="memberschool" required/>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="priceafterdiscount">Member's school address:</label>
                            <input id="pac-input" name="map_location" class="controls" type="text" placeholder="Search Box">
                            <div id="map-canvas" style="width:450px; height:300px;"></div>
                        </div> <!--form-group-->						
                        <div class="right">
                            <a href="users.php" id="btn-cancel" class="btn btn-primary btn-main">Cancel</a>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-main">submit</button>
                        </div><br />
						<?php //if(isset($error)){echo "<P>".$error."</p>";}?>
						<input type="hidden" name="id" id="id" value="0" /> 
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
                <h1 class="clearfix section-title"><span class="fa fa-edit title-ic"></span>Edit Member's Detail</h1>
            </div> <!--section-header-->            
            <div class="section-data">
            	<div class="data-block set-width">
                    <form method="post" enctype="multipart/form-data" class="add-padding">
                    <?php if(isset($error)){echo "<P>".$error."</p>";}?>
                        <div class="form-group">
                            <label for="offername">Member's Name:<span>*</span></label>
                            <input type="text" id="membername" name="membername" value="<?php echo $member_name;?>" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Father's Name:<span>*</span></label>
                            <input type="text" id="fathername" name="fathername" value="<?php echo $father_name;?>" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Mother's Name:<span>*</span></label>
                            <input type="text" id="mothername" name="mothername" value="<?php echo $mother_name;?>" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Father's Phone:<span>*</span></label>
                            <input type="text" id="fatherphone" name="fatherphone" value="<?php echo $father_phone;?>" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Mother's Phone:<span>*</span></label>
                            <input type="text" id="motherphone" name="motherphone" value="<?php echo $mother_phone;?>" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Member's DOB:<span>*</span></label>
                            <input type="text" name="memberdob" id="datepicker1" value="<?php echo $member_dob;?>" required>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="offername">Member's Age:<span>*</span></label>
                            <input type="text" id="memberage" name="memberage" value="<?php echo $member_age;?>" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Member's Class:<span>*</span></label>
                            <input type="text" id="memberclass" name="memberclass" value="<?php echo $member_class;?>" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Member's School:<span>*</span></label>
                            <input type="text" id="memberschool" name="memberschool" value="<?php echo $member_school;?>" required/>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="priceafterdiscount">Member's school address:</label>
                            <input id="pac-input" name="map_location" class="controls" value="<?php echo $location;?>" type="text" placeholder="Search Box">
                            <div id="map-canvas" style="width:450px; height:300px;"></div>
                        </div> <!--form-group-->
                        <div class="right">
                            <a href="users.php" id="btn-cancel" class="btn btn-primary btn-main">Cancel</a>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-main">submit</button>
                        </div>
                        <br />
						<?php //if(isset($error)){echo "<P>".$error."</p>";}?>
						<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" /> 			
                        <input type="hidden" name="lat" id="lat" value="<?php echo $latitude; ?>" />
                        <input type="hidden" name="lng" id="lng" value="<?php echo $longitude; ?>" />
                        <input type="hidden" name="address" id="address" value="<?php echo $location; ?>" />
                    </form>
                </div>
            </div>
        </div> <!--content-left-->
        
    </div> <!--container--> 
<?php }?>	
<?php include('in_footer.php'); ?>