<?php
include "logcheck.php";
include "dbcon.php";
if(isset($_POST['admin']) && !empty($_POST['admin']) && $_POST['admin']=="admin_bengalathon"){
	$sql = "SELECT * FROM `report` ORDER BY `report`.`createdAt` DESC;";
	if($result = $con->query($sql)){
		if(mysqli_num_rows($result)>0){
			$response = array();
			while($row = $result->fetch_assoc()){
				array_push($response, array($row['name'], $row['area'], $row['senid'], $row['descript'], $row['createdAt']));
			}
			echo json_encode($response, JSON_NUMERIC_CHECK);
		}
		else{
			echo "No report found.";
		}
	}
}
else{
	echo "Invalid request.";
}
?>