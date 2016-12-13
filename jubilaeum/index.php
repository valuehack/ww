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
require_once('../translations/de.php');

// include the PHPMailer library
require_once('../libraries/PHPMailer.php');

// load the login class
require_once('../classes/General.php');
require_once('../classes/Login.php');
require_once('../classes/Registration.php');

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$general = new General();
$login = new Login();
$registration = new Registration();

require_once('../classes/Login.php');
$title="10 Jahre scholarium: Geschichte und Zukunft Europas";



if ($login->isUserLoggedIn() == true)
{
    switch ($_SESSION['Mitgliedschaft']) {
        case 0:
            include("../views/jubilaeum_not_in.php");
            break;
        case ($_SESSION['Mitgliedschaft'] >= 1):
            include("../views/jubilaeum_in.php");
            break;
        default:
            include("../views/jubilaeum_not_in.php");
            break;
    }


}
else {
    include("../views/jubilaeum_not_in.php");

}
