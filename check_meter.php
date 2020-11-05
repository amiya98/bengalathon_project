<?php
include "logcheck.php";
include "dbcon.php";
$response = array();
$sql = "SELECT `users`.`name`,`users`.`email`,`users`.`phoneNo`,`users`.`area`,`meter_status`.`sensorID`, TIMEDIFF(CURRENT_TIMESTAMP,`meter_status`.`updatedAt`) AS `diff` FROM `users`,`meter_status` WHERE `users`.`sensorId` = `meter_status`.`sensorID` ORDER BY `users`.`area`;";
if($res = $con->query($sql)){
	if(mysqli_num_rows($res)>0){
		while($row = $res->fetch_assoc()){
			array_push($response, array($row['name'],$row['email'],$row['phoneNo'],$row['area'],$row['sensorID'],$row['diff']));
		}
		echo json_encode($response, JSON_NUMERIC_CHECK);
	}
	else{
		echo "No result found.";
	}
}
?>