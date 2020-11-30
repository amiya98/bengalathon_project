<?php
include("dbcon.php");
//date_default_timezone_set("Asia/Kolkata");
if(isset($_POST) && !empty($_POST))
{
 	$name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $repass = md5($_POST['re-password']);
    $a = $_POST['aut'];
}
$sql = "INSERT INTO admins(name,email,password) VALUES('$name','$email','$password')";
if(($a == "wb_Admins2019") && ($password==$repass))
{
	if($con->query($sql))
	{
 		echo "Success";
 		header("Refresh: 3;url=index.php");
	}
	else if($con->connect_error)
	{
 		echo "Error in register process.";
 		header("Refresh: 3;url=index.php");
	}
}
else
{
	echo "Authentication problem.(Ask your authority for Auth_code)";
	header("Refresh: 3;url=index.php");
}
?>