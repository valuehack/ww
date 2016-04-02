<?php

#display all errors while developing
ini_set('display_errors',1);
error_reporting(E_ALL);

/**
* Process successful sofort payment
* by Dainius
*/

# set UTF at all times to keep those umlauts happy
header('Content-Type: text/html; charset=UTF-8');
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

require_once('../classes/Login.php');
require_once('../classes/Registration.php');

$registration = new Registration();
$login = new Login();



$registration->processSuccesfulPayment();

// if ($_SESSION['profile']['payment_option'] === "sofort")
// {
// 	$registration->processSofortSuccess();
// }
// elseif ($_SESSION['profile']['payment_option'] === "paypal")
// {

// 	$registration->processPaypalSuccess();

// }




# this line takes care of registration of a member who has successfuly paid


// print_r($_SESSION['payment_profile']);
// $_SESSION['payment_profile'] = array();
// print_r($_SESSION['payment_profile']);

?>
<br>
#display the rest of the success page... with header etc<br>
#setup a random get variable so that people could not reuse success url<br>
<br>
Success!!!<br>
thank you for your payment page<br>
display session var that will be used to update the db on the page load<br>

