<?php 
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
require_once('../classes/Email.php');
// require_once('../classes/Transaction.php');

$general = new General();

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();
//TODO Login and Email don't work together because of header send issues. It might be better to generate the email object wihtin he other functions to avoid this
$email = new Email();
$registration = new Registration();

$title="Unterst&uuml;tzen";
include('../views/_header_not_in.php'); 


?>

<div class="content">
	<div class="blog">
		<header>
			<h1>Seminar Test</h1>
		</header>
	</div>
	<div>
		<form method="post" action="/zahlung/?g=ihredaten">
			<input type="hidden" name="product[what]" value="seminar_666670">
			<input type="hidden" name="product[id]" value="666670">
			<input type="hidden" name="product[type]" value="seminar">
			<input type="hidden" name="product[price]" value="175">
			
			<select name="product[quantity]">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
			
			<input type="submit" class="profil_inputbutton" name="submit_event_selection" value="Anmelden">
		</form>
	</div>
</div>
<?php include('../views/_footer.php'); ?>