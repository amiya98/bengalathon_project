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

    #alert-area{
      position: absolute;
      top: 50%;
      z-index: 100;
      width: 700px;
      height: 450px;
      margin-top: -225px;
      left: 50%;
      margin-left: -350px;
      display: none;
    }
  </style>
</head>

<body>
  <!-- Alert area -->
  <div id="alert-area" class="text-center w3-pale-red w3-padding">
    <br><br><br><br><br><br><br>
    <div class="alert bg-warning">
      <!--<button type="button" class="close" data-dismiss="alert">&times;</button>-->
      <strong>Warning!</strong> Server is executing a resource intensive script. Please wait. 
    </div>
    <div class="spinner-border text-muted"></div>
    <div class="spinner-border text-primary"></div>
    <div class="spinner-border text-success"></div>
    <div class="spinner-border text-info"></div>
    <div class="spinner-border text-warning"></div>
    <div class="spinner-border text-danger"></div>
    <div class="spinner-border text-secondary"></div>
    <div class="spinner-border text-dark"></div>
    <div class="spinner-border text-light"></div>
  </div>

  <!-- Top bar -->
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

  <!-- The logo -->
  <div class="logo">
    <img src="photos/save-water-drop.jpg" alt="logo" height="70" width="70">
  </div>

  <!-- Content body -->
  <div class="row">
    <!-- Content left part named Vizualization parameters -->
    <div class="col-sm-2 w3-padding">
      <h4 class="w3-padding w3-padding-left w3-blue">Vizualization Parameter</h4>
      <div class="user_form w3-light-gray w3-leftbar w3-border-green">
        <form id="viz-param-form" action="" method="post" class="w3-padding">
          <label for="month">Enter month to Show usage</label>
          <br>
          <input type="month" name="mon" class="form-control" style="font-size: 10px;padding: 0 0 0 5px;">
          <br>
          <label for="graphtype">Graph Type</label>
          <br>
          <input type="radio" name="chart" value="pie" checked=""> Pie Chart <br>
          <input type="radio" name="chart" value="column"> Column Chart <br><br>
          <div class="row justify-content-center">
            <input class="btn btn-primary" type="submit" value="Generate">
          </div>
        </form>
      </div>
      <h4 id="date-usage" class="w3-text-red" style="padding-left: 10px;">
        <strong><u>Showing usage of <?php echo date('m')."-".date('Y'); ?></u></strong>
      </h4>
    </div>

    <!-- This is the area where chart will be displayed -->
    <div class="col-sm-8" id="chart-area">
      <div id="show" style="width: 100%; height: 540px; overflow: auto;">
        
      </div>
    </div>

    <!-- Content right part containing Notifications and Admin tools -->
    <div class="col-sm-2" style="overflow: auto; height: 540px;padding-right: 22px;">
      <h4 class="w3-text-red"><u><strong>Notifications</strong></u></h4>

      <!-- DIV for notifications -->
      <div>
        <button style="width: 100%;" class="btn btn-danger" data-toggle="modal" data-target="#myModal4" onclick="fetch_report();">Public Complain</button>
        <br><br>
        <button style="width: 100%;" class="btn btn-dark" data-toggle="modal" data-target="#myModal3">Show Statistics</button>
        <br><br>
        <button style="width: 100%;" class="btn btn-secondary" data-toggle="modal" data-target="#myModal2">User statistics</button>
        <br><br>
      </div>

      <!-- DIV for admin tools -->
      <div>
        <h4 class="w3-text-blue"><strong><u>Admin tools</u></strong></h4><br>
        <button style="width: 100%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal8" id="check_meter">Check Meter</button>
        <br><br>
        <button style="width: 100%;" class="btn btn-info" data-toggle="modal" data-target="#myModal1">Generate Notice</button>
        <br><br>
        <button style="width: 100%;" class="btn btn-warning" data-toggle="modal" data-target="#myModal5" onclick="fetch_notices();">All Notices</button>
        <br><br>
        <button style="width: 100%;" class="btn btn-primary" onclick="execute_ml();">Start ML</button>
        <br><br>
        <button style="width: 100%;" class="btn btn-primary" data-toggle="modal" data-target="#myModal7" onclick="fetch_penalty();">Penalty table</button>
        <br><br>
        <button style="width: 100%;" class="btn btn-success" data-toggle="modal" data-target="#myModal6">Send Message</button>
        <br><br>
      </div>
    </div>

  </div>

<!-- Modal for generating notice -->
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
          <select id="notice-scope" class="form-control" name="scope">
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

<!-- Modal for user statistics -->
<div class="modal fade" id="myModal2">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title w3-text-green">User Statistics</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body w3-pale-green w3-leftbar w3-border-green">
        <div id="tbl-usr-subs">
          
        </div>
        <h3 class="w3-text-blue" id="t-subs"></h3>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal for usage statistics -->
<div class="modal fade" id="myModal3">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title w3-text-red">This month's statistics</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div id="usage-stats" class="modal-body w3-pale-green w3-leftbar w3-border-green">
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal for public report -->
<div class="modal fade" id="myModal4">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">User Complain</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div id="public-report" class="modal-body">
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<!-- Notice archieve -->
<div class="modal fade" id="myModal5">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">All notices</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="container" id="notice-archieve"></div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- Send sms feature -->
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
        <form id="sms-form1" action="sms1.php" method="post">
          <label>PHONE NO:</label>
          <input class="form-control" type="text" name="number" placeholder="Enter number" required=""><br>
          <label>MESSAGE:</label>
          <textarea class="form-control" type="text" name="text" id="" form="sms-form1" rows="5" cols="10" placeholder="Enter message" required="">
          </textarea>
          <br>
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

<!-- Modal for penalty table -->
<div class="modal fade" id="myModal7">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Penalty Table</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div id="penalty-tbl-container" class="modal-body w3-pale-red w3-border-red w3-leftbar">
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal for meter checking -->
<div class="modal fade" id="myModal8">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Meter Satus</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body w3-pale-blue w3-border-blue w3-leftbar" id="res-area">
        <table class="table table-hover" width="100%">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone No.</th>
              <th>Area</th>
              <th>Sensor ID</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="tbl-bdy"></tbody>
        </table>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- Script for sending sms -->
<script>
  $(document).on("submit","#sms-form1", (e)=>{
    e.preventDefault();
    $.ajax({
      url: $('#sms-form1').attr('action'),
      method: "POST",
      data: $('#sms-form1 :input').serializeArray(),
      dataType: "text",
      success: function(data){
        alert(data);
        document.getElementById('sms-form1').reset();
      }
    });
  });
</script>

<!-- Script to fetch penalty table -->
<script>
  function fetch_penalty(){
    var elem0 = document.getElementById("penalty-tbl-container");
    elem0.innerHTML =`<table class="table table-striped table-hover" width="100%">
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
                        <tbody id="pnalty-tbl-bdy">
                        </tbody>
                      </table>`;
    $.ajax({
      url: "fetch_penalty_table.php",
      method: "post",
      data: {admin: "bg_admin"},
      dataType: "text",
      success: function(data){
        try{
          var elem = document.getElementById('pnalty-tbl-bdy');
          elem.innerHTML="";
          var list = JSON.parse(data);
          var i = 0;
          list.forEach((item)=>{
            i++;
            elem.innerHTML +=`<tr>
                                <td>`+i+`</td>
                                <td>`+item[0]+`</td>
                                <td>`+item[1]+`</td>
                                <td>`+item[2]+`</td>
                                <td>`+item[3]+`</td>
                                <td>`+item[4]+`</td>
                                <td>`+item[5]+`</td>
                                <td>`+item[6]+`</td>
                              </tr>`;
          });
        }catch(e){
          elem0.innerHTML = "<h2>"+data+"</h2>";
        }
      }
    });
  }
</script>

<!-- Script to execute ML -->
<script>
  function execute_ml(){
    var elem = document.getElementById("alert-area");
    elem.style.display = "block";
    $.ajax({
      url: "executeML.php",
      method: "post",
      data: {admin: "bg_admin"},
      dataType: "text",
      success: function(data){
        elem.style.display = "none";
        window.alert(data);
      }
    });
  }
</script>

<!-- Script to fetch notices -->
<script>
  function fetch_notices(){
    $.ajax({
      url: "fetch_notices_admin.php",
      method: "post",
      data: {admin: "bg_admin"},
      dataType: "text",
      success: function(data){
        var elem = document.getElementById('notice-archieve');
        elem.innerHTML = `<table class="table table-striped table-hover" width="100%">
                            <thead>
                              <tr>
                                <th>Sl. no</th>
                                <th>Scope</th>
                                <th>Notice</th>
                                <th>Date</th>
                              </tr>
                            </thead>
                            <tbody id="notice-archieve-tbl-bdy">
                              
                            </tbody>             
                          </table>`;
        try{
          var notices = JSON.parse(data);
          var tblbdy = document.getElementById('notice-archieve-tbl-bdy');
          tblbdy.innerHTML = "";
          var id = 0;
          notices.forEach((item)=>{
            // console.log(item);
            id++;
            tblbdy.innerHTML += `<tr>
                                  <td>`+id+`</td>
                                  <td>`+item[0]+`</td>
                                  <td>`+item[1]+`</td>
                                  <td>`+item[2]+`</td>
                                </tr>`;
          });
        }catch(e){
          elem.innerHTML = "<h2>"+data+"</h2>";
        }
      }
    });
  }
</script>

<!-- Script to publish notice -->
<script>
  $(document).on("submit","#myfrm1",(e)=>{
    e.preventDefault();
    $.ajax({
      url: $('#myfrm1').attr('action'),
      method: "post",
      data: $('#myfrm1 :input').serializeArray(),
      dataType: "text",
      success: function(data){
        alert(data);
        document.getElementById("myfrm1").reset();
      }
    });
  });
</script>

<!-- Script to fetch subscriber stats -->
<script>
	function fetch_subscriber(){
		$.ajax({
			url: "fetch_user_stats.php",
			method: "post",
			data: {admin: "bg_admin"},
			dataType: "text",
			success: function(data){
        var elem0 = document.getElementById('notice-scope');
        elem0.innerHTML=`<option value="Global" selected="">Global</option>`;
        var elem = document.getElementById("tbl-usr-subs");
        elem.innerHTML="";
				var subs = JSON.parse(data);
        var sta = subs['sensorToarea'];
        var uta = subs['userToarea'];
        var total = 0;
        var tempid = 0;
        for(var key1 in sta){
          elem0.innerHTML += `<option value="`+key1+`">`+key1+`</option>`;
          // console.log(key1);
          total += parseInt(sta[key1]);
          var uinarea = uta[key1];
          tempid++;
          elem.innerHTML +=`<br><table class="table table-striped table-hover" width="100%">
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
                              <tbody id="sub-tbl-bdy`+tempid+`">    
                              </tbody>
                            </table>`;
          for(var key2 in uinarea){
            var elem1 = document.getElementById("sub-tbl-bdy"+tempid);
            elem1.innerHTML +=`<tr>
                                <td>`+key2+`</td>
                                <td>`+key1+`</td>
                                <td>`+uinarea[key2]['name']+`</td>
                                <td>`+uinarea[key2]['email']+`</td>
                                <td>`+uinarea[key2]['phone']+`</td>
                                <td>`+uinarea[key2]['senID']+`</td>
                              </tr>`;
          }
          elem.innerHTML +=`<h4 class="w3-text-red">
                              <strong><u>Total sensor installed in `+key1+` is : `+sta[key1]+`</u></strong>
                            </h4>`;
        }
        document.getElementById("t-subs").innerHTML = `Total Subscriber = `+total;
			}
		});
	}
  window.onload = fetch_subscriber;
</script>

<!-- Script to fetch public complain -->
<script>
  function fetch_report(){
    $.ajax({
      url: "fetch_public_complain.php",
      method: "POST",
      data: {admin: "admin_bengalathon"},
      dataType: "text",
      success: function(data){
        var section = document.getElementById("public-report");
        section.innerHTML = "";
        try{
          var complains = JSON.parse(data);
          complains.forEach((item)=>{
            section.innerHTML += `<div class="w3-leftbar w3-pale-yellow w3-border-red w3-padding">
                                    <h6>Name : `+item[0]+`</h6>
                                    <h6>Area :<strong> `+item[1]+`</strong></h6>
                                    <h6>Sensor Id : `+item[2]+`</h6>
                                    <h6>Complain:</h6>
                                    <p><strong>`+item[3]+`</strong></p>
                                  </div><br>`;
          });
        }catch(e){
          section.innerHTML = "<h2>No data found.</h2>";
        }
      }
    });
  }
</script>

<!-- Script to generate the chart from visualization parameter -->
<script>
  $(document).on('submit','#viz-param-form',(e)=>{
    e.preventDefault();
    var data = $('#viz-param-form :input').serializeArray();
    // document.getElementById('viz-param-form').reset();
    // console.log(JSON.stringify($('#viz-param-form :input').serializeArray()));
    var date = data[0].value;
    var type = data[1].value;
    var month = parseInt(date.split("-")[1]);
    var year = parseInt(date.split("-")[0]);
    // console.log(month,year,type);
    document.getElementById('date-usage').innerHTML = `<strong><u>Showing usage of `+date+`</u></strong>`;
    drawChart(month, year, type);
  });
</script>

<!-- script for fetch stats -->
<script>
  function get_statistics(mon, yr){
    $.ajax({
      url: "get_statistics.php",
      method: "POST",
      data: {month: mon, year: yr, admin: "bg_admin"},
      dataType: "text",
      success: function(data){
        var elem = document.getElementById('usage-stats');
        try{
          var stats = JSON.parse(data);
          // console.log(stats);
          elem.innerHTML = `<h4><strong>Total usage in this month : </strong>`+stats[2]+` KiloLetres</h4>
                            <h4><strong>Maximum usage in this month : </strong>`+stats[0]+` Letres</h4>
                            <h4><strong>Avarage usage in this month : </strong>`+stats[1]+` Letres</h4>`;
        }catch(e){
          elem.innerHTML = `<h2>`+data+`</h2>`;
        }
      }
    });
  }
</script>

<!-- Script for plotting the chart -->
<script>
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart(mon="", yr="", type="pie") {
    $.ajax({
      url: "fetch_chart_data.php",
      method: "POST",
      data: {month: mon,year: yr,admin: "bg_admin"},
      dataType: "text",
      success: function(data){
        try{
          var chart_data = JSON.parse(data);
          // console.log(chart_data);
          var plotting_data = google.visualization.arrayToDataTable(chart_data);
          var options = {
            title: 'Water consumption according to Area per month'
          };
          if(type == "pie"){
            var chart = new google.visualization.PieChart(document.getElementById("show"));
            chart.draw(plotting_data,options);
          }
          if(type == "column"){
            var chart = new google.visualization.ColumnChart(document.getElementById("show"));
            chart.draw(plotting_data,options);
          }
        }catch(e){
          document.getElementById("show").innerHTML = `<div style="text-align: center;padding-top: 50px;"><h1 style="color: red;"> `+data+`</h1></div>`;
        }
      }
    });
    get_statistics(mon, yr);
  }
</script>

<!-- Script for checking meter status (online/offline) -->
<script>
  $(document).on('click','#check_meter',function(){
    $.ajax({
      url: "check_meter.php",
      success: function(data, status){
        var area = document.getElementById("res-area");
        try{
          area.innerHTML = "";
          area.innerHTML += `<table class="table table-hover" width="100%">
                             <thead>
                              <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone No.</th>
                                <th>Area</th>
                                <th>Sensor ID</th>
                                <th>Status</th>
                              </tr>
                             </thead>
                             <tbody id="tbl-bdy"></tbody></table>`;
          var users = JSON.parse(data);
          var tbdy = document.getElementById('tbl-bdy');
          users.forEach(function(item){
            var splited = item[5].split(':');
            // console.log("Hour : "+splited[0]+" Minute : "+splited[1]+" Second : "+splited[2]);
            var second = parseInt(splited[0])*3600 + parseInt(splited[1])*60 + parseInt(splited[2]);
            var mintue = second / 60;
            var str = `<i class="fa fa-circle" style="color: #00ff00;"></i> Online`;
            if(mintue>10){
              str = `<i class="fa fa-circle" style="color: #ff0000;"></i> Offline`;
            }
            tbdy.innerHTML += `<tr>
                                  <td>`+item[0]+`</td>
                                  <td>`+item[1]+`</td>
                                  <td>`+item[2]+`</td>
                                  <td>`+item[3]+`</td>
                                  <td>`+item[4]+`</td>
                                  <td>`+str+`</td>
                               </tr>`
          });
        }
        catch(e){
          area.innerHTML = "<h1> No Data Found</h1>";
        }
      }
    });
  });
</script>
</body>
</html>