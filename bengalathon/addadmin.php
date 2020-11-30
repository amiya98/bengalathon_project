<?php

 if(isset($_GET["auth"]) && !empty($_GET["auth"]))
 {
 	$aut = $_GET["auth"];
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  	<meta name="description" content="">
  	<meta name="author" content="">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  	<style>
  		body{
  			background-image: url(photos/water-saving-technology.jpg);
  			background-repeat: no-repeat;
  			background-size: auto;
  		}
  		.frm{
  			top: 20px;
  			right: 80px;
  			border-radius: 20px;
  			opacity: 0.75;
  		}
  		.frm:hover{
  			opacity: 0.9;
  		}
  	</style>
</head>
<body>
	<div class="row">
		<div class="col-sm-4 w3-padding-large">
			<img src="photos/Emblem_of_West_Bengal.png" alt="logo" height="300" width="230">
		</div>
		<div class="col-sm-8 justify-content-center w3-padding-large w3-black frm">
			<h3>Adminstration Registration</h3><br>
			<form action="admin-register.php" method="post">
				<label for="name"> Enter name</label><br>
				<input type="text" name="name" class="form-control" required=""><br>
				<label for="email"> Enter email</label><br>
				<input type="email" name="email" class="form-control" required=""><br>
				<label for="password"> Create your password</label><br>
				<input type="password" name="password" class="form-control" id="myPass1" required="">
				<input type="checkbox" onclick="myFunction(1)">Show Password <br><br>
				<label for="reTypepass"> Re-Type your password</label><br>
				<input type="password" name="re-password" class="form-control" id="myPass2" required="">
				<input type="checkbox" onclick="myFunction(2)">Show Password <br><br>
				<label for="aut"> Enter Authentication Code</label><br>
				<input type="text" name="aut" value="<?php echo $aut;?>" class="form-control" readonly><br>
				<div class="row justify-content-center">
					<input type="submit" class="btn btn-info" value="Register">
				</div>
			</form>
		</div>
	</div>
	<script>
		function myFunction(ch) {
			if(ch == 1)
			{
				var y = document.getElementById("myPass1");
				if(y.type === "password") {
					y.type = "text";
				}
				else
				{
					y.type = "password";
				}
			}
  			else if(ch == 2)
  			{
  				var x = document.getElementById("myPass2");
  				if (x.type === "password") {
    				x.type = "text";
  				} else {
    				x.type = "password";
  				}
  			}
		}
	</script>
</body>
</html>