<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Smart water monitoring</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  	<style>
  		body {
  			font-family: Arial;
  			font-size: 20px;
  			background-image: url(photos/water-saving-technology.jpg);
		}
		.pledge{
			opacity: 0.6;
		}
		.pledge:hover{
			opacity: 0.9;
		}
    	/* width */
    	::-webkit-scrollbar {
      		width: 5px;
      		height: 5px;
      		border-radius: 10px;
    	}

    	/* Track */
    	::-webkit-scrollbar-track {
      	background: #f1f1f1; 
    	}
 
    	/* Handle */
    	::-webkit-scrollbar-thumb {
      		/*background: #888;*/
      		background: #ff9999;
    	}

    	/* Handle on hover */
    	::-webkit-scrollbar-thumb:hover {
      		background: #555; 
    	}
  	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row w3-padding justify-content-end w3-black w3-opacity-min">
			<div class="p-2">
				<button class="btn btn-primary w3-opacity-off" data-toggle="modal" data-target="#myModal1">User Signup</button>
			</div>
			<div class="p-2">
				<button class="btn btn-info w3-opacity-off" data-toggle="modal" data-target="#myModal2">User Login</button>
			</div>
			<div class="p-2">
				<button class="btn btn-success w3-opacity-off" data-toggle="modal" data-target="#myModal3">Admin Login</button>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-sm w3-padding-large">
				<img src="photos/save_water.jpg" alt="image" height="240" width="210" style="border-radius: 140px;">
			</div>
			<div style="border-radius: 25px;" class="col-sm-6 w3-black w3-text-white w3-padding pledge">
					<p>
						<h4>PLEDGE TO CONSERVE WATER AND SUSTAIN SANITATION AND HYGIENE</h4>
						<ul>
							<li>I pledge to save water.</li>
							<li>I will never waste water.</li>
							<li>I will not contaminate our drinking water.</li>
							<li>I will not pollute our precious water resources.</li>
							<li>I won't hesitate to tell my neighbors and others the sad state of water in our holy rivers, lakes, tanks, wells, and streams, and request them not to pollute them.</li>
							<li>I pledge to conserve every drop of water that I can every day of the week.</li>
							<li>I pledge to tell people not to clutter our drains with garbage and sweepings.</li>
							<li>I pledge that I am against open fouling of our environment, and I will practice good sanitation and hygiene. </li>
							<li>I pledge to celebrate World Water Day on Match 22nd every year and let people know about the importance of conserving water and not polluting our precious waterbodies.</li>
						</ul>
					</p>
			</div>
			<div class="col-sm">
			</div>
		</div>
		<div class="row justify-content-center">
			
		</div>
		<br>
	</div>
	<div class="modal fade" id="myModal1">
  		<div class="modal-dialog">
    		<div class="modal-content">

      		<!-- Modal Header -->
      			<div class="modal-header">
        			<h4 class="modal-title w3-text-blue">User Signup or Create Account</h4>
        			<button type="button" class="close" data-dismiss="modal">&times;</button>
      			</div>

      			<!-- Modal body -->
      			<div class="modal-body w3-light-grey w3-leftbar w3-border-blue">
        			<form action="user_register.php" method="post">
        				<label for="name">Enter Name</label><br>
        				<input class="form-control" type="text" name="name" placeholder="Enter Name" required="">
        				<br>
        				<label for="email">Enter Email</label><br>
        				<input class="form-control" type="text" name="email" placeholder="example@email.com" required="">
        				<br>
        				<label for="sensorId">Enter your sensor Id</label><br>
						    <input class="form-control" type="number" name="sensorId" required="">
						    <br>
						    <label for="area">Enter your area</label><br>
						    <input class="form-control" type="text" name="area" placeholder="Enter your area" required="">
						    <br>
						    <label for="password">Create a password</label><br>
						    <input class="form-control" type="password" name="password" required="">
						    <br>
						    <div class="row justify-content-center">
							     <input type="submit" class="btn btn-warning" value="Submit">
						    </div>
        			</form>
      			</div>

      			<!-- Modal footer -->
      			<div class="modal-footer">
        			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      			</div>
			</div>
  		</div>
	</div>
	<div class="modal fade" id="myModal2">
  		<div class="modal-dialog">
    		<div class="modal-content">

      		<!-- Modal Header -->
      			<div class="modal-header">
        			<h4 class="modal-title w3-text-green">User Login</h4>
        			<button type="button" class="close" data-dismiss="modal">&times;</button>
      			</div>

      			<!-- Modal body -->
      			<div class="modal-body w3-pale-green w3-leftbar w3-border-green">
        			<form action="ulogin.php" method="post">
        				<label for="email">Enter Email</label><br>
        				<input class="form-control" type="text" name="email" placeholder="example@email.com" required="">
        				<br>
						<label for="password">Enter password</label><br>
						<input class="form-control" name="password" type="password" required="">
						<br>
						<div class="row justify-content-center">
							<input type="submit" class="btn btn-warning" value="Submit">
						</div>
        			</form>
      			</div>

      			<!-- Modal footer -->
      			<div class="modal-footer">
        			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      			</div>
			</div>
  		</div>
	</div>
	<div class="modal fade" id="myModal3">
  		<div class="modal-dialog">
    		<div class="modal-content">

      		<!-- Modal Header -->
      			<div class="modal-header">
        			<h4 class="modal-title w3-text-red">Admin Login</h4>
        			<button type="button" class="close" data-dismiss="modal">&times;</button>
      			</div>

      			<!-- Modal body -->
      			<div class="modal-body w3-pale-yellow w3-leftbar w3-border-red">
        			<form action="alogin.php" method="post">
        				<label for="email">Enter Email</label><br>
        				<input class="form-control" type="text" name="email" placeholder="example@email.com" required="">
        				<br>
						<label for="password">Enter password</label><br>
						<input class="form-control" name="password" type="password" required="">
						<br>
						<div class="row justify-content-center">
							<input type="submit" class="btn btn-warning" value="Submit">
						</div>
        			</form>
      			</div>

      			<!-- Modal footer -->
      			<div class="modal-footer">
        			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      			</div>
			</div>
  		</div>
	</div>
</body>
</html>