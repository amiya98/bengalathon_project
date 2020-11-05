<?php
include "logcheck.php";
include "dbcon.php";
if(isset($_POST['month']) && !empty($_POST['year']) || $_POST['admin']=="bg_admin"){
	$response = array();
	array_push($response, array("Area", "Water Consumption"));
	$month = empty($_POST['month'])?date('m'):$_POST['month'];
	$year = empty($_POST['year'])?date('Y'):$_POST['year'];
	$sql = "SELECT SUM(`temp`.`water_consumed`) AS `total`, `temp`.`area` FROM (SELECT `wsage`.`wusage` AS `water_consumed`,`wsage`.`area` FROM `wsage` WHERE `wsage`.`month` = '$month' AND `wsage`.`year` = '$year') AS `temp` GROUP BY `temp`.`area`;";
	if($result = $con->query($sql)){
		if(mysqli_num_rows($result)>0){
			while($row = $result->fetch_assoc()){
				array_push($response, array($row['area'],$row['total']/1000));
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