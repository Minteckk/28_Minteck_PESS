<?php
require_once 'db.php';

$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `incident_type` WHERE 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        /* create an associative array of $incidentType {incident_type_id, incident_type_desc] */
        $incidentType[$row['incident_type_id']] = $row['incident_type_desc'];
    }
}

$conn->close();
?>

<?php
require_once 'db.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
$sql = "SELECT * FROM incident_type";
$result = $conn->query($sql);
$incidentTypes = [];
while ($row = $result->fetch_assoc()) {
    $id = $row['incident_type_id'];
    $type = $row['incident_type_desc'];
    $incidentType = [
        "id" => $id,
        "type" => $type
    ];
    array_push($incidentTypes, $incidentType);
}
$conn->close();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Log Call</title>
<link href="css/bootstrap-4.3.1.css" rel="stylesheet" type="text/css">
<style type="text/css">
</style>
</head>
<body>
	<div class="container" style="width: 930px">
		<header>
			<img src="images/banner.jpg" width="900" height="200" alt="" />
		</header>
      <?php
    require_once 'nav.php';
    ?>
        <?php
        $_SESSION['SESS_DISPLAYNAME'] = 'Michael';
        $rememberMeChecked = isset($_POST['RememberMe']);
        if ($rememberMeChecked == true) {
            $expiryTime = time() + 60 * 60 * 24 * 30;
            setcookie("COOKIE_DISPLAYNAME", "", $expiryTime);
        }
            if (isset($_SESSION) == false) {
                session_start();
            }

            $has_Session_DisplayName = isset($_SESSION['SESS_DISPLAYNAME']);
            if ($has_Session_DisplayName == true) {
                $session_DisplayName = $_POST['Username'];
                echo "Welcome <strong>" . $session_DisplayName . " ! </strong> [<a href='PESS_logout.php'>logout</a>]";
            } else {
                echo "<a href='PESS_login.php'>Logout</a>";
            }
        ?>
      <section style="margin-top: 20px">
			<form action="dispatch.php" method="post" name="frmLogCall"
				onSubmit="return validateForm()">
				<div class="form-group row">
					<label for="callerName" class="col-sm-4 col-form-label">Caller's
						Name </label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="callerName"
							name="callerName">
					</div>
				</div>
				<div class="form-group row">
					<label for="contactNo" class="col-sm-4 col-form-label">Contact
						Number (Required) </label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="contactNo"
							name="contactNo">
					</div>
				</div>
				<div class="form-group row">
					<label for="locationOfIncident" class="col-sm-4 col-form-label">
						Location of Incident (Required) </label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="locationOfIncident"
							name="locationOfIncident">
					</div>
				</div>
				<div class="form-group row">
					<label for="typeOfIncident" class="col-sm-4 col-form-label"> Type
						of Incident (Required) </label>
					<div class="col-sm-8">
						<select id="typeOfIncident" class="form-control"
							name="typeOfIncident">
							<option value="">Select</option>
                <?php
                for ($i = 0; $i < count($incidentTypes); $i ++) {
                    $incidentType = $incidentTypes[$i];
                    echo '<option value="' . $incidentType['id'] . '">' . $incidentType['type'] . '</option>';
                }
                ?>
              </select>
					</div>
				</div>
				<div class="form-group row">
					<label for="descriptionOfIncident" class="col-sm-4 col-form-label">
						Description of Incident </label>
					<div class="col-sm-8">
						<textarea name="descriptionOfIncident" class="form-control"
							rows="5" id="descriptionOfIncident">
              </textarea>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-4"></div>
					<div class="col-sm-8">
						<input class="btn btn-primary" name="btnProcessCall" type="submit"
							value="Process Call">
					</div>
				</div>
			</form>
		</section>
		<footer
			class="page-footer font-small blue pt-4
                     footer-copyright text-center py-3">
			� 2020 Copyright: <a href="https://www.ite.edu.sg"> ITE </a>
		</footer>
	</div>
	<script type="text/javascript" src="js/jquery-3.3.1.min.js">
    </script>
	<script type="text/javascript" src="js/popper.min.js">
    </script>
	<script type="text/javascript" src="js/bootstrap-4.3.1.js">
    </script>
	<script type="text/javascript">
function validateForm()
{
	var x=document.forms["frmLogCall"]["callerName"] .value;
	if (x==null || x=="")
  	{
  		alert("Caller Name is required.");
  		return false;
  	}
}
</script>
</body>
</html>




