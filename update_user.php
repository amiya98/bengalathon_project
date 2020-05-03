<?php
include("logcheck.php");
include("dbcon.php");
if(isset($_POST) && !empty($_POST))
{
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$sensor = $_POST['senid'];
	$area = $_POST['area'];
	$oldPassword = md5($_POST['opsw']);
	$newPassword = md5($_POST['npsw']);
	$repPassword = md5($_POST['rpsw']);
	$id = $_SESSION['user']['id'];
	// $sql1 = "SELECT * FROM users WHERE sensorId='$sensor'";
	// $result = $con->query($sql1);
	// $row = $result->fetch_assoc();
	// echo "<pre>";
	// print_r($row);
	// echo "</pre>";
	// echo $_SESSION['user']['password'];
	// echo "<br>";
	// echo $oldPassword;
	if($phone == "")
	{
		$phone = null;
	}
	if($oldPassword == $_SESSION['user']['password'])
	{
		if($newPassword == $repPassword)
		{
			$sql="UPDATE users SET name='$name',email='$email',phoneNo='$phone',password='$newPassword' WHERE id='$id'";
			//echo "All ok u r ready to go.";
			if($result = $con -> query($sql))
			{
				$q = "SELECT * FROM users WHERE id='$id'";
				$res = $con->query($q);
				$row = $res -> fetch_assoc();
				$_SESSION['user']=$row;
				echo "success.";
				header("Refresh:3;url=udashboard.php");
			}
			else
			{
				echo "Unable to execute query.";
				header("Refresh:3;url=udashboard.php");
			}
		}
		else
		{
			echo "We received two new different password.";
			echo "<br>"."Try again.";
			header("Refresh:5;url=udashboard.php");
		}
	}
	else
	{
		echo "Entered old password is wrong.";
		header("Refresh:3;url=udashboard.php");
	}
}
?>