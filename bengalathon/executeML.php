<?php 
include("logcheck.php");
if(isset($_POST['admin']) && !empty($_POST['admin']) && $_POST['admin']=="bg_admin"){
	$output = "";
	$python = "python pyScript/sensor_test_db.py";
	$output = exec($python);
	echo $output;
}
else{
	echo "Invalid request.";
}
?>