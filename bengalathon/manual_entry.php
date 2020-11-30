<?php
echo "welcome. <br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Manual sensor data entry</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="row justify-content-center w3-light-gray w3-leftbar w3-border-blue" style="border-radius: 10px;">
			<form action="manual_data.php" method="post" class="w3-padding-large">
				<label for="sensorId">Enter sensor Id</label><br>
				<input type="number" name="senid" class="form-control" required=""><br>
				<label for="Wusage">Water usage per day</label><br>
				<input type="number" name="water" step="0.01" class="form-control" required=""><br>
				<label for="area">Enter area</label><br>
				<input type="text" name="area" class="form-control" required=""><br>
				<label for="date">Enter date</label><br>
				<input type="date" name="date" class="form-control" required=""><br>
				<div class="row justify-content-center">
					<input type="submit" class="btn btn-info" value="Submit">
				</div>
			</form>
		</div>
	</div>
</body>
</html>