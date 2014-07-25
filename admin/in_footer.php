<script type="text/javascript" src="Ajaxscript.js"></script>
<SCRIPT language="javascript">
function DoLogin()
{
   var status=true;
   var email = document.getElementById("email").value;
   var pwd = document.getElementById("password").value;
   
   if(email == "")
   {      
	  document.getElementById("spanerror").innerHTML = 'Please enter Email.';
      status= false;
	  return false;
   }
   if(pwd == "")
   {
     document.getElementById("spanerror").innerHTML = 'Please enter Password.';
     status= false;
	 return false;
    }	

	var url="checkLogin.php?email="+ email + "&pwd=" + pwd;
   	login(url,'users.php');
}


function check_responseinfo()
{
   var status=true;
   var response= document.getElementById("response").value;     
   if(response == "")
   {
      alert('Please enter Response field.');
      status= false;
   }  
  return status;	
}

function suspend_user(id,status)
{
  var msg = '';
  if(status == 0)
  {
	  msg = "Are you sure? You want to suspend this user. This user will be temporarily unavailable.";	 
  }
  else if(status == 10)
  {
	  msg = "Are you sure? You want to unsuspend this user. This user will be available.";
  }
  var check = confirm(msg);
  if(check==true)
  {
   	var url="suspend_user.php?id="+id + "&status=" + status;
   	fetchdata(url,'users.php');
  } 
}
function advisor(id,status)
{
	
  var msg = '';
  if(status == 0)
  {
	  msg = "Are you sure? You want to suspend this user. This user will be temporarily unavailable.";	 
  }
  else if(status == 10)
  {
	  msg = "Are you sure? You want to unsuspend this user. This user will be available.";
  }
  var check = confirm(msg);
  if(check==true)
  {
	
   	var url="advisor_user.php?id="+id + "&status=" + status;
	//alert(url);
   	fetchdata(url,'advicer.php');
  } 
}
</SCRIPT>
</body>
</html>