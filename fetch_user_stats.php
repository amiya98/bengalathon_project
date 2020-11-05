<?php
include "logcheck.php";
include "dbcon.php";
if(isset($_POST['admin']) && !empty($_POST['admin']) && $_POST['admin']=="bg_admin"){
	$response = array();
	$area = array();
	$sql = "SELECT `users`.`area`, COUNT(*) AS `sensorCount` FROM `users` GROUP BY `users`.`area`;";
	if($result = $con->query($sql)){
		if(mysqli_num_rows($result)>0){
			while($row = $result->fetch_assoc()){
				$area[$row['area']] = $row['sensorCount'];
			}
			$response['sensorToarea'] = $area;
		}
	}
	foreach ($area as $key => $value) {
		$sql = "SELECT * FROM `users` WHERE `users`.`area`='$key';";
		$result = $con->query($sql);
		$i = 1;
		while($row = $result->fetch_assoc()){
			$user = array('name' => $row['name'], 'email' => $row['email'], 'phone'=> $row['phoneNo'], 'senID' => $row['sensorId'], 'createdAt' => $row['createdAt']);
			$response['userToarea'][strval($key)][strval($i)] = $user;
			$i++;
		}
	}
	echo json_encode($response, JSON_NUMERIC_CHECK);
}
?>