<?php
include "logcheck.php";
include "dbcon.php";
if(isset($_POST['admin']) && !empty($_POST['admin']) && $_POST['admin']=="bg_admin"){
	$sql = "SELECT `users`.`area`,`users`.`name`,`users`.`email`,`users`.`phoneNo`,`penalty`.`sid`,`penalty`.`wusage`,`penalty`.`day`,`penalty`.`month`,`penalty`.`year` FROM `users`,`penalty` WHERE `penalty`.`sid` = `users`.`sensorId`;";
	if($result = $con->query($sql)){
		if(mysqli_num_rows($result)>0){
			$response = array();
			while($row = $result->fetch_assoc()){
				$date = $row['day']."-".$row['month']."-".$row['year'];
				array_push($response, array($row['area'], $row['name'], $row['email'], $row['phoneNo'], $row['sid'], $row['wusage'], $date));
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