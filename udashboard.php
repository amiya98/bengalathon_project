<?php
include("logcheck.php");
include("dbcon.php");
date_default_timezone_set("Asia/Kolkata");

$sidd = $_SESSION['user']['sensorId'];
if(isset($_POST) && !empty($_POST))
{
  $dat = strtotime($_POST['mon']);
  $mont = date('m',$dat);
  $yr = date('Y',$dat);
}
else
{
  $mont = date('m');
  $yr = date('Y');  
}
?>
<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
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
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <!-- <script type="text/javascript" src="charts/loader.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([

        ['Day','Water usage'],
        <?php 
          $sql = "SELECT * FROM wsage WHERE sid=$sidd AND month=$mont AND year=$yr";
          //$sql = "SELECT * FROM wsage WHERE sid=$sidd";
          //$exec = mysqli_query($con,$query);
          $exec = $con->query($sql);
          while($row = $exec->fetch_assoc()){

            echo "['".$row['day']."',".$row['wusage']."],"; //date usage
          }
        ?> 
      ]);

      var options = {
      title: 'Water usage according to Day'
        //pieHole: 0.5,
          /*PieSliceTextStyle: {
            color: 'black',
          }*/
          //legend: 'none',
          //is3D : true
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("show"));
      chart.draw(data,options);
    }
  </script>
  <style>
    .logo {
      position: absolute;
      height: 90px;
      width: 90px;
      background-color: #ffffff;
      top: 0;
      padding-left: 10px;
      padding-top: 5px;
      border-radius: 50px;
      overflow: hidden;
    }
    .user_form{
      border: 2px solid;
      border-radius: 10px;
    }
  </style>
</head>
<title>Water usage table</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
<body>
  <div class="row w3-padding justify-content-end w3-light-blue">
      <div class="p-2">
        <p class="w3-bar-item btn btn-success">Welcome <?php echo $_SESSION['user']['name']; ?></p>
      </div>
      <div class="p-2">
        <p class="w3-bar-item btn btn-warning">Your sensor ID = <?php echo $_SESSION['user']['sensorId']; ?></p>
      </div>
      <div class="p-2">
        <p class="w3-bar-item btn btn-danger"><a href="logout.php">Log out&nbsp;<i class="fa fa-sign-out"></i></a></p>
      </div>
  </div>
  <div class="logo">
    <img src="photos/save-water-drop.jpg" alt="logo" height="70" width="70">
  </div>
  <div class="row">
    <div class="col-sm-2 w3-padding-large">
      <h4 class="w3-padding w3-padding-left w3-blue">Vizualization Parameter</h4>
        <div class="user_form w3-light-gray w3-leftbar w3-border-green">
          <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="w3-padding">
            <label for="month">Enter month to Show usage</label>
            <br>
            <input type="month" name="mon" class="form-control" style="font-size: 10px;padding: 0 0 0 5px;">
            <br>
            <br>
            <div class="row justify-content-center">
              <input class="btn btn-primary" type="submit" value="Generate">
            </div>
          </form>
        </div>
        <h4>
          Showing usage of
          <?php
            echo $mont."/".$yr;
          ?>
        </h4>
        <div>
          <button class="btn btn-warning" onclick="myFunction()" data-toggle="modal" data-target="#myModal1">Report Authority</button>
          <br><br>
          <button class="btn btn-info" data-toggle="modal" data-target="#myModal2">Update my Info</button>
        </div>
    </div>
    <div class="col-sm-8" style="max-height: 540px;overflow: auto;">
      <div id="show" style="width: 100%; height: 540px; overflow: auto;">
 
      </div>
    </div>
    <div class="col-sm-2">
      <h4 class="w3-text-red"><u><strong>Notifications</strong></u></h4>
      <div>
        <button class="btn btn-dark" data-toggle="modal" data-target="#myModal3">General Notices</button>
        <br>
        <br>
        <button class="btn btn-secondary" data-toggle="modal" data-target="#myModal4">Personalised notices</button>
        <br>
        <br>
        <button class="btn btn-danger" data-toggle="modal" data-target="#myModal5">My Penalties</button>
      </div>
      <div class="w3-padding">
        <h4 class="w3-text-blue" style="padding-left: 10px;"><u><strong>This months <br> usage statistics</strong></u></h4>
      <div class="w3-light-gray">
          <?php 
            $usageQuery = "SELECT wusage FROM wsage WHERE sid=$sidd AND month=$mont AND year=$yr";
            $count = 0;
            $maxUsage = 0;
            $minUsage = 0;
            $avgUsage = 0;
            $total = 0;
            $result = $con->query($usageQuery);
            while($resultRow = $result->fetch_assoc())
            {
              if($count == 0)
              {
                $maxUsage = $resultRow['wusage'];
                $minUsage = $resultRow['wusage'];
                $count++;
                $total += $resultRow['wusage'];
                continue;
              }
              if($resultRow['wusage']>$maxUsage)
              {
                $maxUsage = $resultRow['wusage'];
              }
              if($resultRow['wusage']<$minUsage)
              {
                $minUsage = $resultRow['wusage'];
              }
              $total += $resultRow['wusage'];
              $count++;
            }
            // try{
            //   $avgUsage = $total/$count;
            // }
            // catch(Exception $ex)
            // {
            //   $msg = $ex->getMessage();
            //   $avgUsage = 0;
            // }
            if($count != 0)
            {
              $avgUsage = $total/$count;
            }
            else
            {
              $avgUsage = 0;
            }
            
          ?>
          <ul>
            <li style="color: red;">Total Usage : <?php echo $total; ?></li>
            <li style="color: #f77506;">Maximum Usage : <?php echo $maxUsage; ?></li>
            <li style="color: blue;">Minimum Usage : <?php echo $minUsage; ?></li>
            <li style="color: green;">Avarage Usage : <?php echo round($avgUsage,2); ?></li>
          </ul>
          <p style="padding-left: 15px;"><strong>All usages are in Litres.</strong></p>
        </div>
      </div>
    </div>
  </div>
  <div>
    <div class="modal fade" id="myModal1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title w3-text-red">Report Authority</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body w3-pale-yellow w3-leftbar w3-border-red">
              <form action="report.php" method="post" id="form_id1">
                <label for="name">Name</label><br>
                <input type="text" class="form-control" name="name" value="<?php echo $_SESSION['user']['name'];?>" readonly><br>
                <label for="email">Email</label><br>
                <input class="form-control" type="text" name="email" value="<?php echo $_SESSION['user']['email'];?>" readonly>
                <br>
                <label for="">Sensor Id</label><br>
                <input type="text" class="form-control" name="senid" value="<?php echo $_SESSION['user']['sensorId'];?>" readonly>
                <br>
                <label for="area">Area</label><br>
                <input type="text" class="form-control" name="area" value="<?php echo $_SESSION['user']['area'];?>" readonly><br>
                <label for="report">Description of problem</label><br>
                <textarea name="report" class="form-control" id="myTextarea" form="form_id1" cols="80" rows="10" required></textarea>
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
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title w3-text-blue">Update  My Information</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body w3-pale-green w3-leftbar w3-border-green">
              <form action="update_user.php" method="post" id="form_id2">
                <label for="name">Name</label><br>
                <input type="text" class="form-control" name="name" value="<?php echo $_SESSION['user']['name'];?>" required><br>
                <label for="email">Email</label><br>
                <input class="form-control" type="text" name="email" value="<?php echo $_SESSION['user']['email'];?>" required>
                <br>
                <label for="phoneNo">Enter your phone number</label><br>
                <input type="number" class="form-control" name="phone" maxlength="10" value="<?php echo $_SESSION['user']['phoneNo'];?>">
                <br>
                <label for="">Sensor Id</label><br>
                <input type="text" class="form-control" name="senid" value="<?php echo $_SESSION['user']['sensorId'];?>" readonly>
                <br>
                <label for="area">Area</label><br>
                <input type="text" class="form-control" name="area" value="<?php echo $_SESSION['user']['area'];?>" readonly><br>
                <label for="oldpassword">Old password</label><br>
                <input type="password" name="opsw" class="form-control" id="mypass1" required=""><br>
                <input type="checkbox" onclick="myFunction(1)">Show Password <br><br>
                <label for="newpassword">New password</label><br>
                <input type="password" name="npsw" class="form-control" id="mypass2" required=""><br>
                <input type="checkbox" onclick="myFunction(2)">Show Password <br><br>
                <label for="repeat_password">Repeat new password</label><br>
                <input type="password" name="rpsw" class="form-control" id="mypass3" required=""><br>
                <input type="checkbox" onclick="myFunction(3)">Show Password <br><br>
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
    <!-- The Modal -->
    <div class="modal fade" id="myModal3">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title w3-text-blue">Global Notices</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="container">
              <table class="table table-striped text-center" width="100%">
                <thead>
                  <tr>
                    <th>Sl. no</th>
                    <th>Notice</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $query = "SELECT * FROM notice WHERE area='Global'";
                  $res = $con->query($query);
                  $x=1;
                  while($note = $res->fetch_assoc())
                  {
                    ?>
                      <tr>
                        <th><?php echo $x?></th>
                        <th><?php echo $note['note'];?></th>
                        <th><?php echo $note['dat'];?></th>
                      </tr>
                    <?php
                    $x++;
                  }
                ?>
                </tbody>             
              </table>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="myModal4">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title w3-text-red">My Notices</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="container">
              <table class="table table-striped text-center" width="100%">
                <thead>
                  <tr>
                    <th>Sl. no</th>
                    <th>Notice</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $x=1;
                    $condition = $_SESSION['user']['area'];
                    $mynote = "SELECT * FROM notice WHERE area='$condition'";
                    $bans = $con->query($mynote);
                    while($brow = $bans->fetch_assoc())
                    {
                      ?>
                      <tr>
                        <td><?php echo $x; ?></td>
                        <td><?php echo $brow['note'];?></td>
                        <td><?php echo $brow['dat'];?></td>
                      </tr>
                      <?php
                      $x++;
                    }
                  ?>
                  <!--- TO BE MODIFIED -->
                </tbody>
              </table>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

  <!-- </div> -->
  <div class="modal fade" id="myModal5">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">My Penalties</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body w3-pale-red w3-leftbar w3-border-red">
        <?php
          $penaltyQuery = "SELECT * FROM `penalty` WHERE sid=$sidd";
          $pqr = $con->query($penaltyQuery);
          $itt = 1;
        ?>
        <table class="table table-striped text-center" width="100%">
          <thead>
            <tr>
              <th>Sl no.</th>
              <th>Water Usage</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
          <?php
          while($pqrow = $pqr->fetch_assoc())
          {
            ?>
            <tr>
              <th><?php echo $itt;?></th>
              <th><?php echo $pqrow['wusage'];?></th>
              <th><?php echo $pqrow['day']."/".$pqrow['month']."/".$pqrow['year'];?></th>
            </tr>
            <?php
            $itt++;
          }
          ?>
        </tbody>
        </table>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
  <script>
    function myFunction() {
    document.getElementById("myTextarea").required = true;
    }
  </script>
  <script>
    function myFunction(ch) {
      if(ch == 1)
      {
        var y = document.getElementById("mypass1");
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
          var x = document.getElementById("mypass2");
          if (x.type === "password") {
            x.type = "text";
          } else {
            x.type = "password";
          }
        }
        else if(ch == 3)
        {
          var z = document.getElementById("mypass3");
          if (z.type === "password") {
            z.type = "text";
          } else {
            z.type = "password";
          }
        }
    }
  </script>
</body>
</html>