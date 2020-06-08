<?php
if(isset($_SESSION) == false) {
        session_start();
    
$isloginClicked = isset($_POST['login']);
 if($isloginClicked == true) {
 $Username = $_POST['Username'];
 $Password = $_POST['Password'];
    
    if($Username == 'Username' && $Password=='Password')
     {
     $RememberMeChecked = isset($_POST['RememberMe']);
     if($RememberMeChecked == true) {
       $expiryTime = time() + 60 * 60 * 24 * 30;
        setcookie("COOKIE_DISPLAYNAME", "Michael" , $expiryTime);
        }
        header('Location: logcall.php');
        }
   else {
      echo "<span style='color:red'>Wrong Username / password </span>";
        }
    }
}
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PESS_login</title>
 <link href="css/bootstrap-4.3.1.css" rel="stylesheet" type="text/css">
   <style type="text/css">
   form {
   color: #2F2FA2;
   }
   input {
   color: #fc4445;
   }
   p {
   color: #afd275;
   }
    </style>
</head>
<body>
 <div class="container" style="width: 930px">
      <header>
        <img src="images/banner.jpg" width="900" height="200" alt="" />
      </header>
<h3>Login to Access PESS services</h3>
		<p>Please enter your username and password
		to login into the website. 
		</p>
<form action="logcall.php" method="post" name="PESS_login" onSubmit="return validateForm()">
Username: <input name="Username" type="text" id="Username">
Password: <input type="password" name="Password" id="Password" required></input>
<input name="login" type="submit" id="login" value="Login"></form>
<input type="checkbox" name="RememberMe" id="RememberMe" value="No">Remember Me
</div>
<script type="text/javascript">
function validateForm()
{
	var x=document.forms["PESS_login"]["Username"] .value;
	if (x==null || x=="")
  	{
  		alert("User Name is required.");
  		return false;
  	}
}
</script>
</body>
</html>

