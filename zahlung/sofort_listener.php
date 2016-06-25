<?php

#error log settings
ini_set("log_errors" , "1");
#php_listener_errors is a filename where errors are logged
ini_set("error_log" , "./log/sofort_listener_errors");
ini_set("display_errors" , "1");

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

$profile = $_SESSION['profile'];
$product = $_SESSION['product'];

error_log( "----------------------logs are still working");



if ((isset($_SESSION['user_logged_in'])) and ($_SESSION['user_logged_in'] === 1))
{
	#in sofort session is still valid when listener is invoked
	#logged in user, do the upgrade

	#make sure that credits exists! 
	$registration->giveCredits($_SESSION['product']['credits'] , $_SESSION['user_email']);
	
	echo $registration->prolongMembership($_SESSION['user_email']);

	if ( !($registration->sendUpgradeEmailToUser($_SESSION['user_email'])) ) 
	{
		error_log( "Mail not sent " .$_SESSION['user_email']);
	}

	#TODO: mark as paid only when all above are successful
	$registration->markAsPaid($_SESSION['user_email'],$_SESSION['profile']['wrt_txn_id']);
	

}elseif ( empty($_SESSION['user_logged_in']) )
{
	#the user_logged_in is empty - new user

	$registration->createNewUser($profile, $product);

	$registration->addPersonalDataGeneric($profile);


	if ( !($registration->sendUpgradeEmailToUser($_SESSION['profile']['user_email'])) ) 
	{
		error_log( "Mail not sent " .$_SESSION['user_email']);
	}

	#TODO: mark as paid only when all above are successful
	$registration->markAsPaid($_SESSION['profile']['user_email'],$_SESSION['profile']['wrt_txn_id']);

	$login->newRememberMeCookie();

}else
{
	#some random shit just happened! 
	#log it and ivestigate
}




header('Location: einvollererfolg.php');


#TESTING ONLY
#var output block
echo "<br>POST<br>";
print_r($_POST);
echo "<br>";
echo "<br>GET<br>";
print_r($_GET);
echo "<br><br><br>";
#formats print_r for readability 
$test = print_r($_SESSION, true);
$test = str_replace("(", "<br>(", $test);
$test = str_replace("[", "<br>[", $test);
$test = str_replace(")", ")<br>", $test);
echo $test;