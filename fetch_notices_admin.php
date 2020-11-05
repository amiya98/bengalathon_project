<?php
include "logcheck.php";
include "dbcon.php";
if(isset($_POST['admin']) && !empty($_POST['admin']) && $_POST['admin']=="bg_admin"){
	$sql = "SELECT * FROM `notice` ORDER BY `notice`.`id` DESC;";
	if($result = $con->query($sql)){
		if(mysqli_num_rows($result)>0){
			$response = array();
			while($row = $result->fetch_assoc()){
				array_push($response, array($row['area'], $row['note'], $row['dat']));
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