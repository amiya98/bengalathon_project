<?php
session_start();
include("dbcon.php");
if(isset($_POST['email']) && !empty($_POST['password']))
{
    $email=$_POST['email'];
    $password=md5($_POST['password']);
    $sql="SELECT * FROM users WHERE email='$email' AND password='$password'";
    if($result=$con->query($sql))
    {
        $row=$result->fetch_assoc();
        if(!empty($row))
        {
            $var = 'true';
            //echo"WELCOME".$row['name'];exit;
            $_SESSION['user'] = $row;
            header("Refresh: 2; url=udashboard.php");
        }
        else
        {
            $var = 'false';
            header("Refresh: 5; url=index.php");
            //echo"Email/Password is wrong";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login status</title>
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
    <div class="col-sm-12 w3-hide w3-center w3-text-green" id="success">
        <h2>You have succesfully logged in.</h2>
        <h2>You will be redirected to dashboard page.</h2>
        <h3>Want to redirect now-</h3>
        <a href="udashboard.php">click here</a>
        <div class="spinner-border text-success"></div>
    </div>
    <div class="col-sm-12 w3-center w3-hide w3-text-red" id="failed">
        <h2>Registration failed.</h2>
        <h2><u>Username or Password is wrong.</u></h2> 
        <h2>You will be redirected to log in page.</h2>
        <h3>Want to redirect now-</h3>
        <a href="index.php">click here</a>
        <div class="spinner-border text-warning"></div>
    </div>
    <script type="text/javascript">
        var val = '<?php echo $var; ?>';
        if(val == 'true')
        {
            var x = document.getElementById("success");
            if(x.className.indexOf("w3-show") == -1)
            {
                x.className = x.className.replace("w3-hide","w3-show");
            }
        }
        else if(val == 'false')
        {
            var y = document.getElementById("failed");
            if(y.className.indexOf("w3-show") == -1)
            {
                y.className = y.className.replace("w3-hide","w3-show");
            }
        }
    </script>
</body>
</html>