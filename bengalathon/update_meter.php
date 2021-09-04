<?php
include "dbcon.php";
$sql = "UPDATE `meter_status` SET `meter_status`.`updatedAt` = CURRENT_TIMESTAMP;";
if($con->query($sql)){
	echo "Success";
}
else{
	echo "Failed";
}
?>