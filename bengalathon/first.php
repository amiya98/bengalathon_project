<?php
// open the file "demosaved.csv" for writing
//$file = fopen('dataframe/sensordata.csv', 'w');
$file = fopen('dataframe/nodedata.csv', 'w');
 
// save the column headers
fputcsv($file, array('sensorId', 'W_usage', 'Area', 'Day', 'Month','Year'));
 
// Close the file
fclose($file);

echo "Success. <br>";
echo "OK <br>";
?>