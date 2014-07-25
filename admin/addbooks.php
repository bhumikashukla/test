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

	$error = AddEditBookDetails();
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

$str="SELECT * FROM book_list WHERE id = $id";
$result=mysql_query($str);
$rn = mysql_num_rows($result);
if($rn!="0")
{
	$row = mysql_fetch_assoc($result);
	$id = $row["id"];
	$book_isbn = $row["book_isbn"];
	$book_name = $row["book_name"];
	$series = $row["series"];
    $publisher = $row["publisher"];
	$author = $row["author"];
	$book_condition	 = $row["book_condition"];
	$owned_by = $row["owned_by"];
	$current_with = $row["current_with"];
	$level = $row["level"];
	$word_count = $row["word_count"];
	$book_preview = $row["book_preview"];
	$book_status = $row["book_status"];
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
                <h1 class="clearfix section-title"><span class="fa fa-edit title-ic"></span>Add book <a id="btn-add" href="book_list.php" class="btn btn-primary btn-main">View book List</a></h1>
            </div> <!--section-header-->            
            <div class="section-data">
            	<div class="data-block set-width">
                    <form method="post" enctype="multipart/form-data" class="add-padding">
                    <?php if(isset($error)){echo "<P>".$error."</p>";}?>
                    
                        <div class="form-group">
                            <label for="offername">Book ISBN:<span>*</span></label>
                            <input type="text" id="bookisbn" name="bookisbn" required/>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="offername">Book Name:<span>*</span></label>
                            <input type="text" id="bookname" name="bookname" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Series:<span>*</span></label>
                            <input type="text" id="series" name="series" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Publisher:<span>*</span></label>
                            <input type="text" id="publisher" name="publisher" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Author:<span>*</span></label>
                            <input type="text" id="author" name="author" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Book Condition:<span>*</span></label>
                            <input type="text" id="bookcondition" name="bookcondition" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Owner:<span>*</span></label>
                            <input type="text" name="owner" id="owner" required>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="offername">Level:<span>*</span></label>
                            <input type="text" id="level" name="level" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Word Count:<span>*</span></label>
                            <input type="text" id="wordcount" name="wordcount" required/>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="priceafterdiscount">book_preview:<span>*</span></label>
                            <input name="photo" id="photo" type="file" multiple required/>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="priceafterdiscount">Book Status:</label>
                            <input type="text" id="bookstatus" name="bookstatus" required />
                        </div> <!--form-group-->						
                        <div class="right">
                            <a href="book_list.php" id="btn-cancel" class="btn btn-primary btn-main">Cancel</a>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-main">submit</button>
                        </div><br />
						<?php //if(isset($error)){echo "<P>".$error."</p>";}?>
						<input type="hidden" name="id" id="id" value="0" /> 
                        <input type="hidden" name="lat" id="lat" value="" />
                        <input type="hidden" name="lng" id="lng" value="" />
                        <input type="hidden" name="address" id="address" value="" />
                        <input type="hidden" name="oldphotopath" id="oldphotopath" value="" />
                    </form>
                </div>
            </div>
        </div> <!--content-left-->
    </div> <!--container-->
<?php }else{?>	
	<div class="container content-wrapper">
		<div class="clearfix content-left">
            <div class="section-header">
                <h1 class="clearfix section-title"><span class="fa fa-edit title-ic"></span>Edit book</h1>
            </div> <!--section-header-->            
            <div class="section-data">
            	<div class="data-block set-width">
                    <form method="post" enctype="multipart/form-data" class="add-padding">
                    <?php if(isset($error)){echo "<P>".$error."</p>";}?>
                        <div class="form-group">
                            <label for="offername">Book ISBN:<span>*</span></label>
                            <input type="text" id="bookisbn" name="bookisbn" value="<?php echo $book_isbn; ?>" required/>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="offername">Book Name:<span>*</span></label>
                            <input type="text" id="bookname" name="bookname" value="<?php echo $book_name; ?>" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Series:<span>*</span></label>
                            <input type="text" id="series" name="series" value="<?php echo $series; ?>" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Publisher:<span>*</span></label>
                            <input type="text" id="publisher" name="publisher" value="<?php echo $publisher; ?>" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Author:<span>*</span></label>
                            <input type="text" id="author" name="author" value="<?php echo $author; ?>" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Book Condition:<span>*</span></label>
                            <input type="text" id="bookcondition" name="bookcondition" value="<?php echo $book_condition; ?>" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Owner:<span>*</span></label>
                            <input type="text" name="owner" id="owner" value="<?php echo $owned_by; ?>" required>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="offername">Level:<span>*</span></label>
                            <input type="text" id="level" name="level" value="<?php echo $level; ?>" required/>
                        </div> <!--form-group-->
                         <div class="form-group">
                            <label for="offername">Word Count:<span>*</span></label>
                            <input type="text" id="wordcount" name="wordcount" value="<?php echo $word_count; ?>" required/>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="priceafterdiscount">book_preview:<span>*</span></label>
                            <input name="photo" id="photo" type="file"/>
                        </div> <!--form-group-->
                        <div class="form-group">
                            <label for="priceafterdiscount">Book Status:</label>
                            <input type="text" id="bookstatus" name="bookstatus" value="<?php echo $book_status; ?>" required />
                        </div> <!--form-group-->
                        <div class="right">
                            <a href="book_list.php" id="btn-cancel" class="btn btn-primary btn-main">Cancel</a>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-main">submit</button>
                        </div>
                        <br />
						<?php //if(isset($error)){echo "<P>".$error."</p>";}?>
						<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" /> 			
						<input type="hidden" name="oldphotopath" id="oldphotopath" value="<?php echo $book_preview; ?>" />
                         <input type="hidden" name="startdate" id="startdate" value="" />
                        <input type="hidden" name="enddate" id="enddate" value="" />
                    </form>
                </div>
            </div>
        </div> <!--content-left-->
        
    </div> <!--container--> 
<?php }?>	
<script>
function get_book_details(){	
	var isbn = $('#isbn').val();
	//$('.loader').fadeIn(2000);
	$.ajax({
		type: "POST",
		url: "getbookdetails.php",
		data: "&isbn="+isbn,
		success: function(html){
			if(html == 'success'  || html == 'update'){
				$('#promocode').show();
				$('.generated-contnt').show();
				$('.generate-btn').fadeOut('slow');
				$('.generated-contnt').delay(600).fadeIn('slow');
				$('.tier-message').delay(800).animate({bottom: '-5px'}, 'easein');
				$('.tier-block').delay(800).css('display', 'block');
				$('.sharing-button').show();
				//$('.loader').fadeOut(2000);
				}
			
		}
		});
	}
</script>
<?php include('in_footer.php'); ?>