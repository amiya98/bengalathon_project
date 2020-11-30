<?php
include "logcheck.php";
include "dbcon.php";
if(isset($_POST['senid']) && !empty(['senid']) && $_POST['user']=="bg_user"){
	$sensor = $_POST['senid'];
	$sql = "SELECT * FROM `penalty` WHERE `penalty`.`sid` = '$sensor';";
	if($result = $con->query($sql)){
		if(mysqli_num_rows($result)>0){
			$response = array();
			$i=0;
			while($row = $result->fetch_assoc()){
				$i++;
				array_push($response, array($i,$row['wusage'], $row['day']."-".$row['month']."-".$row['year']));
			}
			echo json_encode($response, JSON_NUMERIC_CHECK);
		}
		else{
			echo "No data found.";
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