<?php
    function checkRequired($fieldName) {
        $login_click = isset($_POST['login']);
        if($login_click == true) {
            $Username = $_POST['Username'];
            if(empty($Username) == true) {
                echo "<span style='color:red'>Required.</span>";
            }
        }
    }
    $login_click = isset($_POST['submit']);
    $allFieldsFilled = false;
    if($login_click == true) {
        if(empty($_POST['Username'] == false) &&
           empty($_POST['Password'] == false)
            ) {
            $allFieldsFilled = true;
        }
        if($allFieldsFilled == true) {
            echo 'Welcome ' ;
            echo $_POST['Username'] . ', ';
            echo 'Your password is ' . $_POST['Password'];
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
<form action="logcall.php" method="post" id="pess_login">
Username: <input name="Username" type="text" id="Username" required>
<?php checkRequired('Username');?>
Password: <input type="password" name="Password" id="Password" required></input>
<?php checkRequired('Password');?>
<input name="login" type="submit" id="login" value="login"></form>
<input type="checkbox" name="RememberMe" id="RememberMe" value="No">Remember Me
</div>
</body>
</html>
