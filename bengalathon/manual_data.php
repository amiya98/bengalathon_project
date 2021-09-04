<?php
include("dbcon.php");
if(isset($_POST) && !empty($_POST))
{
	$sensorId = $_POST['senid'];
	$waterUsage = $_POST['water'];
	$area = $_POST['area'];
	$dat = strtotime($_POST['date']);
	$day = date('d',$dat);
	$mont = date('m',$dat);
	$yr = date('Y',$dat);
	// echo $sensorId."<br>";
	// echo $waterUsage."<br>";
	// echo $area."<br>";
	// echo $day."<br>";
	// echo $mont."<br>";
	// echo $yr."<br>";
	$sql = "INSERT INTO wsage(sid,wusage,area,day,month,year) VALUES('$sensorId','$waterUsage','$area','$day','$mont','$yr')";

	$file = fopen('dataframe/sensordata.csv', 'a');
	$row = array($sensorId,$waterUsage,$area,$day,$mont,$yr);
	fputcsv($file, $row);

	fclose($file);

	if ($con -> query($sql)) {
		echo "success. <br> OK <br>";
		header("Refresh: 1;url=manual_entry.php");
	}
	else
	{
		echo "unable to upload. <br>";
		header("Refresh: 1;url=manual_entry.php");
	}
}
else
{
	echo "Failed <br>";
	header("Refresh: 1;url=manual_entry.php");
}
?>