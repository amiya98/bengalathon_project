<?php
include("logcheck.php");
include ("dbcon.php");
if(isset($_POST['name']) && !empty($_POST['senid'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$sensor = $_POST['senid'];
	$area = $_POST['area'];
	$problem = $con->real_escape_string($_POST['report']);
	$sql = "INSERT INTO report(name,email,senid,area,descript) VALUES('$name','$email','$sensor','$area','$problem')";
	if($con->query($sql)){
		echo "Report has been filed successfully.";
	}
	else{
		echo "Server error. Try after some time.";
	}
}
else{
	echo "error 404.";
}
?>