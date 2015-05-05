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
    require_once('../libraries/password_compatibility_library.php');
}
// include the config
require_once('../config/config.php');

// include the to-be-used language, english by default. feel free to translate your project and include something else
require_once('../translations/en.php');

// include the PHPMailer library
require_once('../libraries/PHPMailer.php');

// load the login class
require_once('../classes/Login.php');
require_once('../classes/Registration.php');

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.



$login = new Login();
$registration = new Registration();


// Mitgliedschaft 
// and $_SESSION['Mitgliedschaft'] == 1

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) 
{
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.

    #display the members area according to membership level
    switch ($_SESSION['Mitgliedschaft']) {
        case 0:
            echo "Well, there are no such members...";
            break;
        case 1:
            include("../views/level1View.php");
            break;
        case 4:
            include("../views/mitglied_in.php");
            break;
        default: 
            include("../views/testView.php"); 
            break;
    }


    // include("../views/testView.php");
    // include("../views/mitglied_in.php");
    #include("views/header2.inc.php");



} 
else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    // include("../views/mitglied_not_in.php");
    // header("Location:http://www.wertewirtschaft.org/");
header("Location:http://localhost:4567/");


    #include("views/header2.inc.php"); 
}
