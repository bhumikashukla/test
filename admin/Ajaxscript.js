///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function GetXmlHttpObject()
{
 var xmlHttp=null;
  try
    { xmlHttp=new XMLHttpRequest();  }
  catch (e)
    { // Internet Explorer
     try
      {   xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");  }
    catch (e)
     {    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");  }
     }
  return xmlHttp;
}

function getRequestBody(oForm)
{   var aParams = new Array();
    for (var i=0 ; i < oForm.elements.length; i++) {
        var sParam = encodeURIComponent(oForm.elements[i].name);
        sParam += "=";
        sParam += encodeURIComponent(oForm.elements[i].value);
        aParams.push(sParam);
    }
    return aParams.join("&");
}

function fetchdata(str,ru)
{
 var obj=GetXmlHttpObject();
 obj.open("GET",str,true);
 obj.onreadystatechange=function()
  {   	
    if(obj.readyState==4)
    {		
   	    obj=null;
		window.location.href=ru;
  	}
  }
 obj.send(null);
}

function login(str,ru)
{
 var obj=GetXmlHttpObject();
 obj.open("GET",str,true);
 obj.onreadystatechange=function()
  {   	
    if(obj.readyState==4)
    {	
		var indS = obj.responseText.indexOf("<span>");
		var indE = obj.responseText.lastIndexOf("</span>");
		var data = obj.responseText.substring(indS + 6,indE);		
		obj=null;
		
		if(data == 10)
		{
			window.location.href="offers.php";
		}
		else if(data == 20)
		{
			window.location.href="users.php";
		}
		else if(data == 0)
		{
			document.getElementById("spanerror").innerHTML = "Invalid Username Or Password.";
		}
  	}
  }
 obj.send(null);
}
/////////////////////////////////////ajax code ends here///////////////////////////////////////////////////////
