<?php

/**
 * A simple PHP Login Script / ADVANCED VERSION
 * For more versions (one-file, minimal, framework-like) visit http://www.php-login.net
 *
 * @author Panique
 * @link http://www.php-login.net
 * @link https://github.com/panique/php-login-advanced/
 * @license http://opensource.org/licenses/MIT MIT License
 */

// check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    echo PHP_VERSION;
    exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once('libraries/password_compatibility_library.php');
}

// include the config
require_once('config/config.php');

// include the to-be-used language, english by default. feel free to translate your project and include something else
require_once('translations/de.php');

// include the PHPMailer library
require_once('libraries/PHPMailer.php');

// load the login class
require_once('classes/Login.php');
require_once('classes/Registration.php');

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.

// load the login class
require_once('classes/General.php');
require_once('classes/Login.php');
require_once('classes/Registration.php');
require_once('classes/Email.php');

$general = new General();

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();
//TODO Login and Email don't work together because of header send issues. It might be better to generate the email object wihtin he other functions to avoid this
$email = new Email();
$registration = new Registration();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) 
{
	include("views/index_in.php");
	#temporarly differentiation between normal users and testers/developers
	#$user_id = $_SESSION['user_id'];
	#$user_email = $_SESSION['user_email'];
	
	#$query = "SELECT * from mitgliederExt WHERE `user_id` LIKE '%$user_id%' AND `user_email` LIKE '%$user_email%' ";
	#$result = mysql_query($query) or die("Failed Query of " . $query. mysql_error());
	#$entry = mysql_fetch_array($result);
	
	#$test = $entry[test];
	
	#if ($test == ''){
	#	include("views/upgrade_in_temp.php");
	#}
	#elseif ($test == 1){
    #	include("views/index_in.php");
	#}
} 
else 
{
    include("views/index_not_in.php");
}

?>