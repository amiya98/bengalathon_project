<?php
include("logcheck.php");
include("dbcon.php");
if(isset($_POST['name']) && !empty($_POST['senid'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$sensor = $_POST['senid'];
	$area = $_POST['area'];
	$oldPassword = md5($_POST['opsw']);
	$newPassword = md5($_POST['npsw']);
	$repPassword = md5($_POST['rpsw']);
	$id = $_SESSION['user']['id'];
	if($phone == ""){
		$phone = null;
	}
	if($oldPassword == $_SESSION['user']['password']){
		if($newPassword == $repPassword){
			$sql="UPDATE users SET name='$name',email='$email',phoneNo='$phone',password='$newPassword' WHERE id='$id'";
			if($result = $con -> query($sql)){
				$q = "SELECT * FROM users WHERE id='$id'";
				$res = $con->query($q);
				$row = $res -> fetch_assoc();
				$_SESSION['user']=$row;
				echo "Success. Info updated successfully.";
				header("Refresh:3;url=udashboard.php");
			}
			else{
				echo "Server error.";
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
		header("Refresh:5;url=udashboard.php");
	}
}
?>