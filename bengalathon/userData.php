<?php
include("dbcon.php");
$sql = "SELECT * FROM `users`";
// open the file "demosaved.csv" for writing
$file = fopen('dataframe/user_record.csv', 'w');
 
// save the column headers
fputcsv($file, array('Name', 'E-mail', 'Sensor_ID', 'Area'));

fclose($file);
$file = fopen('dataframe/user_record.csv', 'a');
 
if($result = $con -> query($sql))
{
	while($row = $result->fetch_assoc())
	{
		fputcsv($file, array($row['name'], $row['email'], $row['sensorId'], $row['area']));
	}
	fclose($file);
}
echo "Success. <br>";
echo "OK <br>";
?>