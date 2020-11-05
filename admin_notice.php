<?php
include("logcheck.php");
include("dbcon.php");
date_default_timezone_set("Asia/Kolkata");
if(isset($_POST['scope']) && !empty($_POST['note']))
{
	$scope = $_POST['scope'];
	$note = $con->real_escape_string($_POST['note']);
	$date = date('Y-m-d');
	$sql = "INSERT INTO notice(dat,area,note) VALUES('$date','$scope','$note')";
	if($con -> query($sql))
	{
		echo "Notice has been generated successfully.";
	}
	else
	{
		echo "Unable to Insert. Try again later.";
	}
}
else
{
	echo "Invalid request.";
}
?>