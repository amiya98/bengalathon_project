<?php
include "logcheck.php";
include "dbcon.php";
if((isset($_POST['month']) && !empty($_POST['year']) && !empty($_POST['sensorId'])) || ($_POST['user']=="bg_user" && !empty($_POST['sensorId']))){
	$response = array();
	array_push($response, array('Day','Water usage'));
	$month = empty($_POST['month'])?date('m'):$_POST['month'];
	$year = empty($_POST['year'])?date('Y'):$_POST['year'];
	$sensor = $_POST['sensorId'];
	$sql = "SELECT `wsage`.`day`,`wsage`.`wusage` FROM `wsage` WHERE `wsage`.`sid`='$sensor' AND `wsage`.`month`='$month' AND `wsage`.`year`='$year';";
	if($result = $con->query($sql)){
		if(mysqli_num_rows($result)>0){
			while($row = $result->fetch_assoc()){
				array_push($response, array($row['day'],$row['wusage']));
			}
			echo json_encode($response, JSON_NUMERIC_CHECK);
		}
		else{
			echo "No data found.";
		}
	}
	else{
		echo "Server error occured. Try again after some time.";
	}
}
else{
	echo "Invalid request.";
}
?>