<?php
include("logcheck.php");
include("dbcon.php");
date_default_timezone_set("Asia/Kolkata");

if(isset($_POST) && !empty($_POST))
{
  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";
  // $yr = date('Y');
  // $mont = date('m');
  if(isset($_POST['mon']) && !empty($_POST['mon']))
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
  if(isset($_POST['chart']) && !empty($_POST['chart']))
  {
    $chart_ch = $_POST['chart'];
  }
  else
  {
    $chart_ch = "pie";
  }
}
else
{
  $yr = date('Y');
  $mont = date('m');
  $chart_ch = "pie";
}
$areas = array();
$count = 0;
$q1 = "SELECT DISTINCT area FROM wsage";
$res = $con ->query($q1);
while($rows = $res -> fetch_assoc())
{
  array_push($areas, $rows['area']);
  $count++;
}
$totalUsed = 0;
$maxUsed = 0;
$maxUsedId = 0;
$avgcounter = 0;
$avarage = 0;
$totalUsage = array();
for($x = 0; $x < $count; $x++)
{
  $sum = 0;
  $sql = "SELECT * FROM wsage WHERE area='$areas[$x]' AND month=$mont AND year=$yr";
  $result = $con -> query($sql);
  while($row = $result->fetch_assoc())
  {
    if($row['wusage']>$maxUsed)
    {
      $maxUsed = $row['wusage'];
      $maxUsedId = $row['sid'];
    }
    $sum += ($row['wusage']/1000);
    $avgcounter++;
  }
  array_push($totalUsage, $sum);
  $totalUsed += $sum;
}
try
{
  $avarage = $totalUsed/$avgcounter;
}
catch(Exception $e)
{
  $avarage = 0;
  $msg = $e->getMessage();
}

//echo $areas[0];
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
<title>Water usage table</title>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
  // window.onload = setupRefresh;
  //   function setupRefresh()
  //   {
  //       setInterval("refreshBlock();",5000);
  //   }
    

  //   function refreshBlock()
  //   {
  //      $('#show').load("displaydata1.php");
  //   }
</script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([

        ['Area','Water usage'],
        <?php 
          //$sql = "SELECT * FROM wsage WHERE sid=$sidd AND month=$mont AND year=$yr";
          //$sql = "SELECT * FROM wsage WHERE sid=$sidd";
          //$exec = mysqli_query($con,$query);
          //$exec = $con->query($sql);
          $i = 0;
          while($i<$count){
            echo "['".$areas[$i]."',".$totalUsage[$i]."],";
            $i++; //date usage
          }
        ?> 
      ]);

      var options = {
      title: 'Water usage according to Area per month'
        /*pieHole: 0.5,
          PieSliceTextStyle: {
            color: 'black',
          }*/
          //legend: 'none',
          //is3D : true
      };
      <?php
      if($chart_ch == "pie")
      {?>
        var chart = new google.visualization.PieChart(document.getElementById("show"));
        chart.draw(data,options);
        <?php
      }
      else if($chart_ch == "column")
      {?>
        var chart = new google.visualization.ColumnChart(document.getElementById("show"));
        chart.draw(data,options);
        <?php
      }
      ?>
      
    }
  </script>

<body>
  <div class="row w3-padding justify-content-end w3-light-blue">
    <div class="p-2">
      <p class="w3-bar-item w3-xlarge w3-text-red">This is Admin Panel**</p>
    </div>
      <div class="p-2">
        <p class="w3-bar-item btn btn-success">Welcome <?php echo $_SESSION['user']['name']; ?></p>
      </div>
      <div class="p-2">
        <p class="w3-bar-item btn btn-warning">Your email ID = <?php echo $_SESSION['user']['email']; ?></p>
      </div>
      <div class="p-2">
        <p class="w3-bar-item btn btn-danger"><a href="logout.php">Log out&nbsp;<i class="fa fa-sign-out"></i></a></p>
      </div>
  </div>
  <div class="logo">
    <img src="photos/save-water-drop.jpg" alt="logo" height="70" width="70">
  </div>
  <div class="row">
    <div class="col-sm-2 w3-padding">
      <h4 class="w3-padding w3-padding-left w3-blue">Vizualization Parameter</h4>
      <div class="user_form w3-light-gray w3-leftbar w3-border-green">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="w3-padding">
          <label for="month">Enter month to Show usage</label>
          <br>
          <input type="month" name="mon" class="form-control" style="font-size: 10px;padding: 0 0 0 5px;">
          <br>
          <label for="graphtype">Graph Type</label>
          <br>
          <input type="radio" name="chart" value="pie"> Pie Chart <br>
          <input type="radio" name="chart" value="column"> Column Chart <br><br>
          <div class="row justify-content-center">
            <input class="btn btn-primary" type="submit" value="Generate">
          </div>
        </form>
      </div>
      <h4 class="w3-text-red" style="padding-left: 10px;">
        <strong>
          <u>
          Showing usage of
          <?php
            echo $mont."/".$yr;
            echo "<br>";
            //print_r($areas);
            //echo "<br>";
            //echo $areas[0];
            //echo $count;
            //echo "<br>";
            //print_r($totalUsage);
          ?>
          </u>
        </strong>
      </h4>
    </div>
    <div class="col-sm-8">
      <div id="show" style="width: 100%; height: 540px; overflow: auto;">
 
      </div>
    </div>
    <div class="col-sm-2" style="overflow: auto; height: 540px;">
      <h4 class="w3-text-red"><u><strong>Notifications</strong></u></h4>
      <div>
        <button class="btn btn-danger" data-toggle="modal" data-target="#myModal4">Public Complain</button>
        <br><br>
        <button class="btn btn-dark" data-toggle="modal" data-target="#myModal3">Show Statistics</button>
        <br><br>
        <button class="btn btn-secondary" data-toggle="modal" data-target="#myModal2">User statistics</button>
        <br><br>
      </div>
      <div>
        <h4 class="w3-text-blue"><strong><u>Admin tools</u></strong></h4>
        <br>
        <button class="btn btn-info" data-toggle="modal" data-target="#myModal1">Generate Notice</button>
        <br>
        <br>
        <button class="btn btn-warning" data-toggle="modal" data-target="#myModal5">All Notices</button>
        <br>
        <br>
        <a href="executeML.php"><button class="btn btn-primary">Start ML</button></a>
        <br>
        <br>
        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal7">Penalty table</button>
        <br><br>
        <button class="btn btn-success" data-toggle="modal" data-target="#myModal6">Send Message</button>
        <br><br>
      </div>
    </div>
  </div>
  <!-- The Modal -->
<div class="modal fade" id="myModal1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title w3-text-blue">Generate Notice</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body w3-leftbar w3-border-blue w3-light-gray">
        <form action="admin_notice.php" method="post" id="myfrm1">
          <label for="scope">Scope</label>
          <select class="form-control" name="scope">
            <?php
            $j = 0;
            for($j=0;$j<$count;$j++)
            {
              ?>
              <option value="<?php echo $areas[$j];?>"><?php echo $areas[$j];?></option>
              <?php
            }
            ?>
            <option value="Global" selected="">Global</option>
          </select>
          <br>
          <br>
          <label for="notice">Notice</label><br>
          <textarea class="form-control" name="note" id="" form="myfrm1" cols="80" rows="5" required=""></textarea>
          <br>
          <div class="row justify-content-center">
            <input type="submit" class="btn btn-warning" value="Submit">
          </div>
          <br>
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
<div class="modal fade" id="myModal2">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title w3-text-green">User Statistics</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body w3-pale-green w3-leftbar w3-border-green">
        <?php
        $totalSubscriber = 0;
        //$k = 0;
        for($k=0;$k<$count;$k++)
        {
          $w = 1;
          $query = "SELECT * FROM users WHERE area='$areas[$k]'";
          $r = $con -> query($query);
          ?>
          <br>
          <table class="table table-striped text-center" width="100%">
            <thead>
              <tr>
                <th>Sl. no</th>
                <th>Area</th>
                <th>Owner name</th>
                <th>Owner email</th>
                <th>Contact number</th>
                <th>Sensor ID</th>
              </tr>
            </thead>
          <tbody>
          <?php
          while ($rv=$r->fetch_assoc())
          {
            ?>
            <tr>
              <td><?php echo $w;?></td>
              <td><?php echo $rv['area']?></td>
              <td><?php echo $rv['name'];?></td>
              <td><?php echo $rv['email'];?></td>
              <td><?php echo $rv['phoneNo'];?></td>
              <td><?php echo $rv['sensorId'];?></td>
            </tr>
            <?php
            $w++;
          }?>
          <h4 class="w3-text-red"><strong><u>
            <?php 
              echo "Total sensor installed in ".$areas[$k]." is "." : ".($w-1);
              $totalSubscriber += ($w-1);
            ?></u></strong>
          </h4>
        </tbody>
        <?php
        }
        ?>
      </table>
      <h3 class="w3-text-blue">Total Subscriber = <?php echo $totalSubscriber; ?></h3>
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
        <h4 class="modal-title w3-text-red">This month's statistics</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body w3-pale-green w3-leftbar w3-border-green">
        <h4><strong>Total usage in this month : </strong><?php echo $totalUsed; ?> KiloLetres</h4>
        <h4><strong>Maximum usage in this month : </strong><?php echo $maxUsed; ?> Letres</h4>
        <h4><strong>Mximum usage consumer Id for this month : </strong><?php echo $maxUsedId; ?>(Sensor ID)</h4>
        <h4><strong>Avarage usage in this month : </strong><?php echo round(($avarage*1000),2); ?> Letres</h4>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- The Modal -->
<div class="modal fade" id="myModal4">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">User Complain</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <?php
          $rep = "SELECT * FROM `report` WHERE `createdAt` >= DATE_SUB(CURDATE(), INTERVAL 10 DAY)";
          $reqa=$con->query($rep);
          while($rowss = $reqa -> fetch_assoc())
          {
            ?>
            <br>
            <div class="w3-leftbar w3-pale-yellow w3-border-red w3-padding">
            <h6>Name : <?php echo $rowss['name'];?></h6>
            <h6>Area :<strong> <?php echo $rowss['area'];?></strong></h6>
            <h6>Sensor Id : <?php echo $rowss['senid'];?></h6>
            <h6>Complain:</h6>
            <p>
              <strong>
              <?php
              //print_r($rowss);
                echo $rowss['descript'];
              ?>
            </strong>
            </p>
            </div>
          <?php
          }
        ?>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- The Modal -->
<div class="modal fade" id="myModal5">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">All notices</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="container">
              <table class="table table-striped text-center" width="100%">
                <thead>
                  <tr>
                    <th>Sl. no</th>
                    <th>Scope</th>
                    <th>Notice</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $query = "SELECT * FROM `notice`";
                  $res = $con->query($query);
                  $x=1;
                  while($note = $res->fetch_assoc())
                  {
                    ?>
                      <tr>
                        <th><?php echo $x?></th>
                        <th><?php echo $note['area'];?></th>
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

<div class="modal fade" id="myModal6">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title w3-text-blue">Send SMS</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body w3-leftbar w3-border-blue w3-light-gray">
        <form action="sms1.php" method="POST">
                <label>PHONE NO:</label>
                <input class="form-control" type="text" name="number" placeholder="Enter number" required=""><br>
                <label>MESSAGE:</label>
                <textarea class="form-control" type="text" name="text" rows="5" cols="10" placeholder="Enter message" required=""></textarea><br>
                <div class="row justify-content-center">
                  <input type="submit" class="btn btn-primary" value="Send">
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

<div class="modal fade" id="myModal7">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Penalty Table</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body w3-pale-red w3-border-red w3-leftbar">
        <?php
          $penalty = "SELECT * FROM `penalty`";
          $penaltyRes = $con->query($penalty);
        ?>
          <table class="table table-striped text-center" width="100%">
            <thead>
              <tr>
                <th>Sl. no</th>
                <th>Area</th>
                <th>Owner name</th>
                <th>Owner email</th>
                <th>Contact number</th>
                <th>Sensor ID</th>
                <th>Water usage</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $itt = 1;
              while($penaltyRow = $penaltyRes->fetch_assoc())
              {
                $sensorid = $penaltyRow['sid'];
                $puq = "SELECT * FROM `users` WHERE sensorId=$sensorid";
                $puqr = $con->query($puq);
                while($puqrow = $puqr->fetch_assoc())
                {
                  ?>
                  <tr>
                    <th><?php echo $itt;?></th>
                    <th><?php echo $penaltyRow['area'];?></th>
                    <th><?php echo $puqrow['name'];?></th>
                    <th><?php echo $puqrow['email'];?></th>
                    <th><?php echo $puqrow['phoneNo'];?></th>
                    <th><?php echo $puqrow['sensorId'];?></th>
                    <th><?php echo $penaltyRow['wusage'];?></th>
                    <th><?php echo $penaltyRow['day']."/".$penaltyRow['month']."/".$penaltyRow['year'];?></th>
                  </tr>
                  <?php
                }
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

</body>
</html>