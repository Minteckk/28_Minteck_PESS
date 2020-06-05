<?php
$callerName = $_POST['callerName'];
$contactNo = $_POST['contactNo'];
$locationOfIncident = $_POST['locationOfIncident'];
$typeOfIncident = $_POST['typeOfIncident'];
$descriptionOfIncident = $_POST['descriptionOfIncident'];

$sql = 'SELECT patrolcar_id,patrolcar_status_desc FROM patrolcar INNER JOIN patrolcar_status ON patrolcar_status.patrolcar_status_id = patrolcar.patrolcar_status_id';
$cars = [];
require_once 'db.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
$result = $conn->query($sql);
while($row = $result->fetch_assoc())
{
    $id = $row['patrolcar_id'];
    $status = $row['patrolcar_status_desc'];   
    
    $car = ['id' => $id,
        "status" => $status
    ];
    array_push($cars,$car);
}

$dispatchClicked = isset($_POST['dispatch']);

if ($dispatchClicked == true) {
    $isCarSelected = isset($_POST["CarSelection"]);
    $incident_status_id = 1;
    if ($isCarSelected == true) {
        $incident_status_id = 2;
    } else {
        $incident_status_id = 1;
    }
    $sql = " INSERT INTO incident
(caller_name,incident_desc,incident_location,incident_status_id,incident_type_id)
VALUES (
" . "'" . $callerName . "'" . "," . "'" . $descriptionOfIncident . "'" . "," . "'" . $locationOfIncident . "'" . "," . "'" . $incident_status_id . "'" . "," . "'" . $typeOfIncident . "'" . ")"; 
    echo 'sql :' . $sql;
    $result = $conn->query($sql);
    echo '<br>';
    $insertIncidentSuccess = false;
    if ($result == true) {
        $insertIncidentSuccess = true;
    } else {
        echo 'Error:' . $sql . "<br>" . $conn->error;
    }

    $incidentId = mysqli_insert_id($conn);

    $insertDispatchSuccess = false;
    $updateStatus = false;
    if ($isCarSelected == true) {
        $patrolCarDispatched = $_POST["CarSelection"];
        $numOfPatrolcarDispatched = count($patrolCarDispatched);

        for ($i = 0; $i < $numOfPatrolcarDispatched; $i ++) {
            $carId = $patrolCarDispatched[$i];
            $sql = "UPDATE patrolcar SET patrolcar_status_id=1 WHERE patrolcar_id='" . $carId . "'";
            // echo 'sql: ' . $sql;
            // echo '<br>';
            $updateStatus = $conn->query($sql);
            if ($updateStatus == false) {
                echo "Error:" . $sql . "<br>" . $conn->error;
                echo '<br>';
            } else {
                // echo 'Update on patrol car: ' . $carId . 'is success!';
                // echo '<br>';
            }

            $sql = "INSERT INTO dispatch(incident_id,patrolcar_id,time_dispatched) 
VALUES(" . $incidentId . ',' . "'" . $carId . "'" . ",NOW())";
            // echo 'sql: ' . $sql;
            $insertDispatchSuccess = $conn->query($sql);
            if ($insertDispatchSuccess == false) {
                echo "Error:" . $sql . "<br>" . $conn->error;
                echo '<br>';
            } else {
                echo 'Insert dispatch successfully';
                echo '<br>';
            }
        }
    }
    $conn->close();
    if ($insertIncidentSuccess == true && $updateStatus == true && $insertDispatchSuccess == true)
        header("Location: logcall.php");
}

if (isset($_POST["dispatch"])) {
    require_once 'db.php';

    $conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Dispatch</title>
<link href="css/bootstrap-4.3.1.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="container" style="width: 930px">
		<header>
			<img src="images/banner.jpg" width="900" height="200" alt="" />
		</header>
        <?php require_once 'nav.php'; ?>
        <section style="margin-top: 20px">
			<form action="dispatch.php" method="post">
				<h2>Dispatch Patrolcar Panel</h2>
				<div class="form-group row">
					<label for="callerName" class="col-sm-4 col-form-label">Caller's
						Name </label>
					<div class="col-sm-8">
						<span id="callerName">
                    <?php echo $callerName; ?>
                        <input type="hidden" id="callerName"
							value="<?php echo $callerName; ?>" name="callerName">
						</span>
					</div>
				</div>
				<div class="form-group row">
					<label for="contactNo" class="col-sm-4 col-form-label"> Contact
						Number (Required) </label>
					<div class="col-sm-8">
						<span id="contactNo">
                    <?php echo $contactNo; ?>
                        <input type="hidden" id="contactNo"
							value="<?php echo $contactNo; ?>" name="contactNo">
						</span>
					</div>
				</div>
				<div class="form-group row">
					<label for="LocationOfIncident" class="col-sm-4 col-form-label">
						Location of Incident (Required) </label>
					<div class="col-sm-8">
						<span id="locationOfIncident">
                    <?php echo $locationOfIncident; ?>
                        <input type="hidden" id="locationOfIncident"
							value="<?php echo $locationOfIncident; ?>"
							name="locationOfIncident">
						</span>
					</div>
				</div>
				<div class="form-group row">
					<label for="TypeOfIncident" class="col-sm-4 col-form-label"> Type
						of Incident (Required) </label>
					<div class="col-sm-8">
						<span id="typeOfIncident">
                        <?php echo $typeOfIncident; ?>
                        <input type="hidden" id="typeOfIncident"
							value="<?php echo $typeOfIncident; ?>" name="typeOfIncident">
						</span>
					</div>
				</div>
				<div class="form-group row">
					<label for="descriptionOfIncident" class="col-sm-4 col-form-label">
						Description of Incident </label>
					<div class="col-sm-8">
						<span id="descriptionOfIncident">
                    <?php echo $descriptionOfIncident; ?>
                        <input name="descriptionOfIncident"
							type="hidden" id="descriptionOfIncident"
							value="<?php echo $descriptionOfIncident; ?>">
						</span>
					</div>
				</div>

				<div class="form-group row">
					<label for="patrolCars" class="col-sm-4 col-form-label"> Choose
						Patrol Car(s) </label>
					<div class="col-sm-8">
						<table id="patrolCars" class="table table-striped">
							<tbody>
								<tr>
									<th scope="col">Car Number</th>
									<th scope="col">Car Status</th>
									<th scope="col"></th>
								</tr>
                                <?php
                                for ($i = 0; $i < count($cars); $i ++) {
                                    $car = $cars[$i];
                                    echo '<tr>';
                                    echo '<td>' . $car['id'] . '</td>';
                                    echo '<td>' . $car['status'] . '</td>';
                                    echo '<td>' . '<input name ="CarSelection[]" type="checkbox" 
                                        value="' . $car['id'] . '">';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
						</table>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-sm-4"></div>
					<div class="col-sm-8" style="text-align: center">
						<div>
							<input class="btn btn-primary" type="submit" value="Dispatch"
								name="dispatch" id="dispatch">
						</div>
					</div>
				</div>
			</form>
		</section>


        <?php // validate if request comes from logcall.php or post back if (! isset($_POST[ "btnProcessCall"]) && ! isset($_POST[ "dispatch"])) header( "Location: logcall.php"); ?>
        <footer
			class="page-footer font-small blue pt-4 footer-copyright text-center py-3">
			© 2020 Copyright: <a href="https://www.ite.edu.sg"> ITE</a>
		</footer>
	</div>
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/popper.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-4.3.1.js"></script>
</body>
</html>


