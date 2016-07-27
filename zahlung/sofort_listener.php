<?php

#error log settings
ini_set("log_errors" , "1");
ini_set("error_log" , "../classes/error.log");
ini_set("display_errors" , "0");

#if session does not exist, start a session
if(session_id() == '') session_start();

# check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    echo PHP_VERSION;
    exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once('../libraries/password_compatibility_library.php');
}

require_once('../config/config.php');
require_once('../translations/de.php');
require_once('../classes/Login.php');
require_once('../classes/Registration.php');

$registration = new Registration();
$login = new Login();

$profile = $_SESSION['profile'];
$product = $_SESSION['product'];

error_log("User email in sofort listener ".$profile['user_email']);

$registration->processPayment($profile, $product);

// #TESTING ONLY
// #var output block
// echo "<br>POST<br>";
// print_r($_POST);
// echo "<br>";
// echo "<br>GET<br>";
// print_r($_GET);
// echo "<br><br><br>";
// #formats print_r for readability 
// $test = print_r($_SESSION, true);
// $test = str_replace("(", "<br>(", $test);
// $test = str_replace("[", "<br>[", $test);
// $test = str_replace(")", ")<br>", $test);
// echo $test;