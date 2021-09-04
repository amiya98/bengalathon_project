<?php 
include "logcheck.php";
if(isset($_POST['number']) && !empty($_POST['text'])){
    $number=$_POST['number'];
    $text=$_POST['text'];
    // print_r($_POST);
    $url="www.way2sms.com/api/v1/sendCampaign";
    $message = urlencode($text);// urlencode your message
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);// set post data to true
    curl_setopt($curl, CURLOPT_POSTFIELDS, "apikey=K1ZHBGBV1WSGV14E9EULW9SMBDIL81B4 &Secret=B6D1MQ0F2S734OM6 &usetype=stage&phone=$number &senderid=amiyaghosh4700@gmail.com &message=$message");// post data
    // query parameter values must be given without squarebrackets.
    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    //echo($result);
    curl_close($curl);
    echo "Message has been sent successfully.";
}
else{
    echo "Invalid request.";
}
?>
