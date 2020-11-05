<?php
include "logcheck.php";
include "dbcon.php";
if((isset($_POST['month']) && !empty($_POST['year']) && !empty($_POST['sid'])) || (!empty($_POST['sid']) && $_POST['user'] == "bg_user")){
	$month = empty($_POST['month'])?date('m'):$_POST['month'];
	$year = empty($_POST['year'])?date('Y'):$_POST['year'];
	$sensor = $_POST['sid'];

	$total_consumption = 0;
	$max_consumption = 0;
	$min_consumption = 0;
	$avg_consumption = 0;

	$response = array();


	$sql = "SELECT SUM(`wsage`.`wusage`) AS `total_consumption` FROM `wsage` WHERE `wsage`.`sid`='$sensor' AND `wsage`.`month`='$month' AND `wsage`.`year`='$year';";
	$result = ($con->query($sql))->fetch_assoc();
	$total_consumption = empty($result['total_consumption'])?0:$result['total_consumption'];
	array_push($response, round($total_consumption,2));

	$sql = "SELECT MAX(`wsage`.`wusage`) AS `max_consumption` FROM `wsage` WHERE `wsage`.`sid`='$sensor' AND `wsage`.`month`='$month' AND `wsage`.`year`='$year';";
	$result = ($con->query($sql))->fetch_assoc();
	$max_consumption = empty($result['max_consumption'])?0:$result['max_consumption'];
	array_push($response, round($max_consumption,2));

	$sql = "SELECT MIN(`wsage`.`wusage`) AS `min_consumption` FROM `wsage` WHERE `wsage`.`sid`='$sensor' AND `wsage`.`month`='$month' AND `wsage`.`year`='$year';";
	$result = ($con->query($sql))->fetch_assoc();
	$min_consumption = empty($result['min_consumption'])?0:$result['min_consumption'];
	array_push($response, round($min_consumption,2));

	$sql = "SELECT AVG(`wsage`.`wusage`) AS `avg_consumption` FROM `wsage` WHERE `wsage`.`sid`='$sensor' AND `wsage`.`month`='$month' AND `wsage`.`year`='$year';";
	$result = ($con->query($sql))->fetch_assoc();
	$avg_consumption = empty($result['avg_consumption'])?0:$result['avg_consumption'];
	array_push($response, round($avg_consumption,2));

	echo json_encode($response, JSON_NUMERIC_CHECK);
}
else{
	echo "Invalid request.";
}
?>