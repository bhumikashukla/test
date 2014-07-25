<?php include('in_header.php'); ?>
<div class="container">
    	<div class="login-box">
        	<div class="center header">
            	<span class="brand"></span>
            </div> <!--login-header-->			
            <div class="login-form">
				<span id="spanerror"></span>
            	<form id="frmLogin">					
                	<div class="form-group">
                    	<label for="email">Email Address:<span>*</span></label>
                        <input type="email" required id="email" name="email">
                    </div> <!--form-group-->
                    <div class="form-group">
                    	<label for="password">Password:<span>*</span></label>
                        <input type="password" required id="password" name="password">
                    </div> <!--form-group-->
                    <div class="clearfix form-group">
                        <span id="checkbox" class="checkbox-element">
                        	<input type="checkbox" name="remember">
                        </span> <!--select-element-->
                        <label for="chkbx-elmnt">Keep me signed in</label>
                    </div> <!--form-group-->
                    <div class="center">
                    	<button type="submit" name="submit" class="btn btn-primary btn-main" id="btnLogin" >Get Me In</button>
                    </div> <!--form-button-->
                    <div class="center text-link"><a href="#">Forgot Password?</a></div>
                </form>
            </div> <!--login-form-->
        </div> <!--login-box-->

    </div> <!-- /container -->
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>   
<script type="text/javascript" src="Ajaxscript.js"></script> 
<script>
	$(document).ready(function(){
		<!--checkbox select/deselect-->
		$('#checkbox').click(function(){
			$('#checkbox').toggleClass('enable-chkbx');		
		});
	});
	$('#btnLogin').click( function(){	
		$('#frmLogin').submit(function (e) {
			var status=true;
			var email = $("#email").val();
			var pwd = $("#password").val();
		   
			if(email == "")
			{      
			  $("#spanerror").html('Please enter Email.');
			  status= false;
			  return false;
			}
			if(pwd == "")
			{
				$("#spanerror").html('Please enter Password.');
				status= false;
				return false;
			}	

			var url="checkLogin.php?email="+email + "&pwd=" + pwd;					
			login(url,'users.php');	
			return false;
		});
	});
</script>
<?php include('in_footer.php'); ?>