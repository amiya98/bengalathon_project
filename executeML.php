<?php 
include("logcheck.php");
//echo exec("pyScript/hello.py");
$python = `python pyScript/sensor_test_db.py`;
//echo $python;
exec($python);
?>
<script type="text/javascript">
	window.alert("Penalty table updated.");
	// function myFunction(){
	// 	//var txt = "Penalty table updated.";
	// 	if(confirm("Penalty table updated.")){
	// 		<?php //header("Location:adashboard.php"); ?>
	// 	}
	// }
</script>
<?php
header("Refresh:1;url=adashboard.php");
//header("Location:adashboard.php");
?>