<?php
////DO NOT PUT ANY OUTPUT (html or java script) BEFORE include('_header_in.php');
///NOR LEAVE ANY UNNECESSARY SPACES IN THE PHP CODE
////DOING SO WILL CAUSE THE PDF TICKET GENERATION TO FAIL
include_once("../down_secure/functions.php");
dbconnect();
require_once('../classes/Login.php');

include('../views/_header_in.php');

$check_price_query = "SELECT quantity from registration WHERE `event_id` LIKE '130' AND `user_id`=44";
$check_price_result = mysql_query($check_price_query) or die("Failed Query of " . $check_price_query. mysql_error());
$checkPriceArray = mysql_fetch_array($check_price_result);

$time = "2015-09-14 14:31:12";
$type = $checkPriceArray[type];

echo "Zeit: ".$time;
echo "Typ: ".$type;

?>