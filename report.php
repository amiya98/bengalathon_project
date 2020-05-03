<?php
include("logcheck.php");
include ("dbcon.php");
if(isset($_POST) && !empty($_POST))
{
	$name = $_POST['name'];
	$email = $_POST['email'];
	$sensor = $_POST['senid'];
	$area = $_POST['area'];
	$problem = $_POST['report'];
	//echo $name."<br>";
	//echo $email."<br>";
	//echo $sensor."<br>";
	//echo $area."<br>";
	//echo $problem."<br>";
	$sql = "INSERT INTO report(name,email,senid,area,descript) VALUES('$name','$email','$sensor','$area','$problem')";
	if($con->query($sql))
	{
		header("Location:udashboard.php");
	}
	else
	{
		echo "Error.";
		header("Refresh: 5; url=udashboard.php");
	}
}
else
{
	echo "error 404.";
}
?>