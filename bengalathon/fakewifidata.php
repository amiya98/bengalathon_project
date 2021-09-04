<?php
 include("dbcon.php");
 date_default_timezone_set("Asia/Kolkata");
 if(isset($_GET) && !empty($_GET))
 {
 	$sensorId = $_GET["id"];
    $wamount = $_GET["temp"];
    $area = $_GET["area"];
    $day = date("d");
    $month = date("m");
    $year = date("Y");
 }
 $sql = "INSERT INTO dummy_sensor(sid,waterused,area,day,month,year) VALUES('$sensorId','$wamount','$area','$day','$month','$year')";
 if($con->query($sql))
 {
 	echo "OK";
 }
 else if($con->connect_error)
 {
 	die($con->connect_error);
 }
?>
