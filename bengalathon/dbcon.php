<?php
$host = "localhost";
$user ="root";
$password = "";
$database ="bengalathon";

$con = new mysqli($host,$user,$password,$database);

if($con->connect_error)
  die($con->connect_error);
?>