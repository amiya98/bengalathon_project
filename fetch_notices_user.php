<?php
include "logcheck.php";
include "dbcon.php";

if(isset($_POST['area']) && !empty($_POST['area']) && $_POST['user']=="bg_user"){
	$area = $_POST['area'];
	$sql = "SELECT * FROM `notice` WHERE `notice`.`area`='$area' ORDER BY `notice`.`id` DESC;";
	if($result = $con->query($sql)){
		if(mysqli_num_rows($result)>0){
			$response = array();
			$i=0;
			while($row = $result->fetch_assoc()){
				$i++;
				array_push($response, array($i,$row['note'],$row['dat']));
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