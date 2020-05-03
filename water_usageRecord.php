<?php
include("dbcon.php");
$sql = "SELECT * FROM `wsage`";
// open the file "demosaved.csv" for writing
$file = fopen('dataframe/nodedata.csv', 'w');
 
// save the column headers
fputcsv($file, array('sensorId', 'wusage','area', 'day', 'month','year'));

fclose($file);
$file = fopen('dataframe/nodedata.csv', 'a');
 
if($result = $con -> query($sql))
{
	while($row = $result->fetch_assoc())
	{
		fputcsv($file, array($row['sid'], $row['wusage'], $row['area'], $row['day'], $row['month'], $row['year']));
	}
	fclose($file);
}
echo "Success. <br>";
echo "OK <br>";
?>