<?php
 include("dbcon.php");
 //date_default_timezone_set("Asia/Kolkata");
 if(isset($_GET) && !empty($_GET))
 {
 	$sensorId = $_GET["id"];
    $wamount = $_GET["temp"];
    $area = $_GET["area"];
    //echo $sensorId."<br>";
    //echo $temperature."<br>";
    //echo $area."<br>";
    //echo "CURRENT_TIMESTAMP";
    //echo date("Y/m/d")."<span>&nbsp;&nbsp;</span>".date("h:i:sa");
    //echo "Year = ".date("Y")."<br>";
    //echo "Month = ".date("m")."<br>";
    //echo "Day = ".date("d")."<br>";
    $day = $_GET["day"];
    $month = $_GET["month"];
    $year = $_GET["year"];
 }
 $sql = "INSERT INTO wsage(sid,wusage,area,day,month,year) VALUES('$sensorId','$wamount','$area','$day','$month','$year')";
 //$file = fopen('dataframe/nodedata.csv', 'a');
 //$row = array($sensorId,$wamount,$area,$day,$month,$year);
 //fputcsv($file, $row);

 //fclose($file);
 if($con->query($sql))
 {
 	echo "OK";
 }
 else if($con->connect_error)
 {
 	die($con->connect_error);
 }
?>