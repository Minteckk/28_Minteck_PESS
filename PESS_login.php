<?php
if(isset($_SESSION) == false) {
    session_start();
}
$has_Cookie_DisplayName = isset($_COOKIE["COOKIE_DISPLAYNAME"]);
if($has_Cookie_DisplayName == true)
{
    $_SESSION['SESS_DISPLAYNAME'] = $_COOKIE['COOKIE_DISPLAYNAME'];
}

if(isset($_SESSION['SESS_DISPLAYNAME']) == true ) {
    header('Location: logcall.php');
}

$isLoginButtonClicked = isset($_POST['login']);
if($isLoginButtonClicked == true) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if($username == 'Michael' && $password=='Password')
    {
        $_SESSION['SESS_DISPLAYNAME'] = 'Michael';
        
        $rememberMeChecked = isset($_POST['RememberMe']);
        if($rememberMeChecked == true) {
            $expiryTime = time() + 60 * 60 * 24 * 30;
            setcookie("COOKIE_DISPLAYNAME", "Michael" , $expiryTime);
        }
        header('Location: logcall.php');
    }
    else {
        echo "<span style='color:red'>Wrong Username / password </span>";
    }
}
$has_Cookie_DisplayName = isset($_COOKIE['COOKIE_DISPLAYNAME']);
if($has_Cookie_DisplayName == true)
{
    $_cookie_DisplayName = $_COOKIE["COOKIE_DISPLAYNAME"];
    echo "Welcome <strong>" . $_cookie_DisplayName . " ! </strong> [<a href='PESS_logout.php'>logout</a>]";
}
else {
    if(isset($_SESSION) == false) {
        session_start();
    }
    $has_Session_DisplayName = isset($_SESSION['SESS_DISPLAYNAME']);
    if($has_Session_DisplayName == true)
    {
        $session_DisplayName = $_SESSION['SESS_DISPLAYNAME'];
        echo "Welcome <strong>" . $session_DisplayName . " ! </strong> [<a href='PESS_logout.php'>logout</a>]";
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
<input name="login" type="submit" id="login" value="login"></form>
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

