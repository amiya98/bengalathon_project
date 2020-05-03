<?php
include("logcheck.php");
include("dbcon.php");
date_default_timezone_set("Asia/Kolkata");
if(isset($_POST) && !empty($_POST))
{
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	$scope = $_POST['scope'];
	$note = $_POST['note'];
	$date = date('Y-m-d');
	//echo $date;
	$sql = "INSERT INTO notice(dat,area,note) VALUES('$date','$scope','$note')";
	if($con -> query($sql))
	{
		echo "OK. <br> Success.";
		header("Refresh:1;url = adashboard.php");
	}
	else
	{
		echo "Unable to Insert. <br>Try again later.";
		header("Refresh:1;url = adashboard.php");
	}
}
else
{
	echo "No data found.";
	header("Refresh:1;url = adashboard.php");
}
?>