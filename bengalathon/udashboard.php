<?php
include("logcheck.php");
?>
<!DOCTYPE html>
<html lang="en">
 
<head>
  <title>Water usage table</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Bootstrap 4 stylesheet cdn -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- W3 CSS cdn -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- Font-awesome icon library for web icon cdn -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- cdn for jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- cdn for popper.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <!-- Bootstrap 4 compiled js cdn -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- cdn for google chart library -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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

<body>

  <!-- Top bar -->
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

  <!-- Main content area -->
  <div class="row">

    <!-- Content column 1 leftBar -->
    <div class="col-sm-2 w3-padding-large">
      <h4 class="w3-padding w3-padding-left w3-blue">Vizualization Parameter</h4>
        <div class="user_form w3-light-gray w3-leftbar w3-border-green">
          <form id="form-viz-param" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="w3-padding">
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
        <h4 id="date-usage" class="w3-text-red" style="padding-left: 10px;">
          <strong><u>Showing usage of <?php echo date('Y')."-".date('m'); ?></u></strong>
        </h4>
        <div>
          <button style="width: 100%;" class="btn btn-warning" onclick="myFunction()" data-toggle="modal" data-target="#myModal1">Report Authority</button>
          <br><br>
          <button style="width: 100%;" class="btn btn-info" data-toggle="modal" data-target="#myModal2">Update my Info</button>
        </div>
    </div>

    <!-- Content column 2 Chart Area -->
    <div class="col-sm-8" style="max-height: 540px;overflow: auto;">
      <div id="show" style="width: 100%; height: 540px; overflow: auto;">
      </div>
    </div>

    <!-- Content column 3 rightBar --> 
    <div style="padding-left: 0px;padding-right: 22px;" class="col-sm-2">
      <h4 class="w3-text-red"><u><strong>Notifications</strong></u></h4>
      <div>
        <button style="width: 100%;" class="btn btn-dark" data-toggle="modal" data-target="#myModal3" onclick="fetch_global_notice();">General Notices</button>
        <br><br>
        <button style="width: 100%;" class="btn btn-secondary" data-toggle="modal" data-target="#myModal4" onclick="fetch_local_notice();">Personalised notices</button>
        <br><br>
        <button style="width: 100%;" class="btn btn-danger" data-toggle="modal" data-target="#myModal5" onclick="fetch_my_penalty();">My Penalties</button>
      </div>
      <div style="padding: 2px;">
        <h4 class="w3-text-blue" style="padding-left: 5px;"><u><strong>This months <br> usage statistics</strong></u></h4>
        <div id="my-stats" class="w3-light-gray">
        </div>
      </div>
    </div>
  </div>

  <!-- This is Report authority Modal -->
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

  <!-- This is Update info Modal -->
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

  <!-- This is Global Notices Modal -->
  <div class="modal fade" id="myModal3">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title w3-text-blue">Global Notices</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div id="gnotice-container" class="container">
            
          </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- This is My Notices Modal -->
  <div class="modal fade" id="myModal4">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title w3-text-red">My Notices</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <div id="lnotice-container" class="container">
            
          </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- This is My Penalties Moddal -->
  <div class="modal fade" id="myModal5">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">My Penalties</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div id="penalty-tbl-container" class="modal-body w3-pale-red w3-leftbar w3-border-red">
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
       </div>
    </div>
  </div>

  <!-- Script to fetch my penalties -->
  <script>
    function fetch_my_penalty(){
      var sensor = `<?php echo $_SESSION['user']['sensorId']; ?>`;
      $.ajax({
        url: "fetch_my_penalty.php",
        method: "post",
        data: {senid: sensor,user: "bg_user"},
        dataType: "text",
        success: function(data){
          var elem2 = document.getElementById("penalty-tbl-container");
          elem2.innerHTML =`<table class="table table-striped table-hover" width="100%">
                              <thead>
                                <tr>
                                  <th>Sl no.</th>
                                  <th>Water Usage</th>
                                  <th>Date</th>
                                </tr>
                              </thead>
                              <tbody id="pnalty-tbl-bdy">
                              </tbody>
                            </table>`;
          try{
            var elem1 = document.getElementById("pnalty-tbl-bdy");
            elem1.innerHTML="";
            var penalties = JSON.parse(data);
            penalties.forEach((item)=>{
              // console.log(item);
              elem1.innerHTML += `<tr>
                                    <td>`+item[0]+`</td>
                                    <td>`+item[1]+`</td>
                                    <td>`+item[2]+`</td>
                                  </tr>`;
            });
          }catch(e){
            elem2.innerHTML = "<h2>"+data+"</h2>";
          }
        }
      });
    }
  </script>

  <!-- Script to fetch local notice -->
  <script>
    function fetch_local_notice(){
      var locality = "<?php echo $_SESSION['user']['area']; ?>";
      $.ajax({
        url: "fetch_notices_user.php",
        method: "post",
        data: {area: locality, user: "bg_user"},
        dataType: "text",
        success: function(data){
          var elem2 = document.getElementById("lnotice-container");
          elem2.innerHTML =`<table class="table table-striped table-hover" width="100%">
                              <thead>
                                <tr>
                                  <th>Sl. no</th>
                                  <th>Notice</th>
                                  <th>Date</th>
                                </tr>
                              </thead>
                              <tbody id="lnotice-tbl-bdy">
                              </tbody>
                              </table>`;
          try{
            var elem1 = document.getElementById("lnotice-tbl-bdy");
            elem1.innerHTML="";
            var notices = JSON.parse(data);
            notices.forEach((item)=>{
              elem1.innerHTML += `<tr>
                                    <td>`+item[0]+`</td>
                                    <td>`+item[1]+`</td>
                                    <td>`+item[2]+`</td>
                                  </tr>`;
            });
          }catch(e){
            elem2.innerHTML=`<h2>`+data+`</h2>`;
          }
        }
      });
    }
  </script>

  <!-- Script to fetch global notices -->
  <script>
    function fetch_global_notice(){
      $.ajax({
        url: "fetch_notices_user.php",
        method: "post",
        data: {area: "Global", user: "bg_user"},
        dataType: "text",
        success: function(data){
          var elem2 = document.getElementById("gnotice-container");
          elem2.innerHTML =`<table class="table table-striped table-hover" width="100%">
                              <thead>
                                <tr>
                                  <th>Sl. no</th>
                                  <th>Notice</th>
                                  <th>Date</th>
                                </tr>
                              </thead>
                              <tbody id="gbl-notice-tbdy">
                              </tbody>             
                            </table>`
          
          try{
            var elem1 = document.getElementById("gbl-notice-tbdy");
            elem1.innerHTML="";
            var notices = JSON.parse(data);
            notices.forEach((item)=>{
              elem1.innerHTML += `<tr>
                                    <td>`+item[0]+`</td>
                                    <td>`+item[1]+`</td>
                                    <td>`+item[2]+`</td>
                                  </tr>`;
            });
          }catch(e){
            elem2.innerHTML=`<h2>`+data+`</h2>`;
          }
        }
      });
    }
  </script>

  <!-- Script to report authority -->
  <script>
    $(document).on('submit','#form_id1',(e)=>{
      e.preventDefault();
      $.ajax({
        url: $('#form_id1').attr('action'),
        method: "post",
        data: $('#form_id1 :input').serializeArray(),
        dataType: "text",
        success: function(data){
          alert(data);
          document.getElementById('form_id1').reset();
        }
      });
    });
  </script>

  <!-- Script to fetch usage stats -->
  <script>
    function fetch_usage_stats(mon="", yr=""){
      var sensor = <?php echo $_SESSION['user']['sensorId']; ?>;
      $.ajax({
        url: "fetch_my_usage.php",
        method: "post",
        data: {month: mon, year: yr, sid: sensor},
        dataType: "text",
        success: function(data){
          try{
            var item = JSON.parse(data);
            document.getElementById('my-stats').innerHTML = `<ul style="padding-inline-start: 30px;">
                                  <li style="color: red;"><strong>Total Usage : `+item[0]+`</strong></li>
                                  <li style="color: #f77506;"><strong>Maximum Usage : `+item[1]+`</strong></li>
                                  <li style="color: blue;"><strong>Minimum Usage : `+item[2]+`</strong></li>
                                  <li style="color: green;"><strong>Avarage Usage : `+item[3]+`</strong></li>
                                </ul>
                                <p style="padding-left: 15px;"><strong>All usages are in Litres.</strong></p>`;
          }catch(e){
            document.getElementById('my-stats').innerHTML = `<ul style="padding-inline-start: 30px;">
                                  <li style="color: red;"><strong>Total Usage : 0</strong></li>
                                  <li style="color: #f77506;"><strong>Maximum Usage : 0</strong></li>
                                  <li style="color: blue;"><strong>Minimum Usage : 0</strong></li>
                                  <li style="color: green;"><strong>Avarage Usage : 0</strong></li>
                                </ul>
                                <p style="padding-left: 15px;"><strong>All usages are in Litres.</strong></p>`;
          }
          
        },
        error: function(err){
          console.log(err);
        }
      });
    }
  </script>

  <!-- Script to handle user input for vizualization parameter -->
  <script>
    $(document).on('submit','#form-viz-param',(e)=>{
      e.preventDefault();
      var data = $('#form-viz-param :input').serializeArray();
      var date = data[0].value;
      var year = parseInt(date.split('-')[0]);
      var month = parseInt(date.split('-')[1]);
      document.getElementById('date-usage').innerHTML = `<strong><u>Showing usage of `+date+`</u></strong>`;
      drawChart(month, year);
    });
  </script>

  <!-- Script to plot chart -->
  <script>
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);

    function drawChart(mon="", yr="") {
      var senid = <?php echo $_SESSION['user']['sensorId']; ?>;

      $.ajax({
        url: "fetch_chart_data_user.php",
        method: "post",
        data: {month: mon, year: yr, sensorId: senid},
        dataType: "text",
        success: function(data){
          try{
            var dataPoints = JSON.parse(data);
            var plotData = google.visualization.arrayToDataTable(dataPoints);
            var options = {
              title: 'Water usage according to Day'
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("show"));
            chart.draw(plotData,options);
          }catch(e){
            document.getElementById("show").innerHTML = `<div style="text-align: center;padding-top: 50px;"><h1 style="color: red;"> No data found.</h1></div>`;
          }
          fetch_usage_stats(mon, yr);
        }
      });
    }
  </script>

  <!-- Script to make textarea as a required fiels to submit the form -->
  <script>
    function myFunction() {
    document.getElementById("myTextarea").required = true;
    }
  </script>

  <!-- Script to toggle password show and hide -->
  <script>
    function myFunction(ch) {
      if(ch == 1){
        var y = document.getElementById("mypass1");
        if(y.type === "password") {
          y.type = "text";
        }
        else{
          y.type = "password";
        }
      }
      else if(ch == 2){
        var x = document.getElementById("mypass2");
        if (x.type === "password") {
          x.type = "text";
        }else {
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