<?php
include "logcheck.php";
include "dbcon.php";
if(isset($_POST['month']) && !empty($_POST['year']) || $_POST['admin']=="bg_admin"){

	$month = empty($_POST['month'])?date('m'):$_POST['month'];
	$year = empty($_POST['year'])?date('Y'):$_POST['year'];

	$total_usage = 0;
	$max_usage = 0;
	$avg_usage = 0;

	$response = array();

	$sql = "SELECT MAX(`wsage`.`wusage`) AS `max_consumption` FROM `wsage` WHERE `wsage`.`month`=$month AND `wsage`.`year`=$year;";
	if($result = $con->query($sql)){
		if(mysqli_num_rows($result)>0){
			$row = $result->fetch_assoc();
			$max_usage = empty($row['max_consumption'])?0:$row['max_consumption'];
			array_push($response, round($max_usage,2));
		}
		else{
			echo "No result found.";
		}
	}
	else{
		echo "Server error.";
	}


	$sql = "SELECT AVG(`wsage`.`wusage`) AS `avg_consumption` FROM `wsage` WHERE `wsage`.`month`=$month AND `wsage`.`year`=$year;";
	if($result = $con->query($sql)){
		if(mysqli_num_rows($result)>0){
			$row = $result->fetch_assoc();
			$avg_usage = empty($row['avg_consumption'])?0:$row['avg_consumption'];
			array_push($response, round($avg_usage,2));
		}
		else{
			echo "No result found.";
		}
	}
	else{
		echo "Server error.";
	}

	$sql = "SELECT SUM(`wsage`.`wusage`) AS `total_consumption` FROM `wsage` WHERE `wsage`.`month`=$month AND `wsage`.`year`=$year;";
	if($result = $con->query($sql)){
		if(mysqli_num_rows($result)>0){
			$row = $result->fetch_assoc();
			$total_usage = empty($row['total_consumption'])?0:$row['total_consumption'];
			array_push($response, round($total_usage/1000,2));
			echo json_encode($response, JSON_NUMERIC_CHECK);
		}
		else{
			echo "No result found.";
		}
	}
	else{
		echo "Server error.";
	}
}
else{
	echo "Invalid request.";
}
?>