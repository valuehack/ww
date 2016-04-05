<?php

#error log settings
ini_set("log_errors" , "1");
#php_listener_errors is a filename where errors are logged
ini_set("error_log" , "./log/sofort_listener_errors");
ini_set("display_errors" , "0");

session_start();

# check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    echo PHP_VERSION;
    exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once('../libraries/password_compatibility_library.php');
}

require_once('../config/config.php');
require_once('../translations/de.php');

// require_once('../classes/Login.php');
require_once('../classes/Registration.php');

$registration = new Registration();
// $login = new Login();

$profile = $_SESSION['profile'];
$product = $_SESSION['product'];

$registration->processSuccessfulPayment($profile, $product);

