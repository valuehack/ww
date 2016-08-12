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
			<h1>Projekt Test</h1>
		</header>
	</div>
	<div>
		<form method="post" action="/zahlung/?g=ihredaten">
			
			<input type="hidden" name="product[what]" value="projekt_666671">
			<input type="hidden" name="product[id]" value="666671">
			<input type="hidden" name="product[type]" value="projekt">
			
    		<div class="projekte_investment">
              <input type="radio" class="projekte_investment_radio" name="product[price]" value="150" required>150&euro;: Sie erhalten Zugriff auf die Scholien und andere Inhalte.<br><br>
              <input type="radio" class="projekte_investment_radio" name="product[price]" value="300">300&euro;: Ab diesem Beitrag haben Sie als Scholar vollen Zugang zu allen unseren Inhalten und Veranstaltungen.<br><br>
              <input type="radio" class="projekte_investment_radio" name="product[price]" value="600">600&euro;: Ab diesem Beitrag werden Sie Partner, wir f&uuml;hren Sie (au&szlig;er anders gew&uuml;nscht) pers&ouml;nlich mit Link auf unserer Seite an und laden Sie zu einem exklusiven Abendessen ein (oder Sie erhalten einen Geschenkkorb)<br><br>
              <input type="radio" class="projekte_investment_radio" name="product[price]" value="1200">1200&euro;: Ab diesem Beitrag nehmen wir Sie als Beirat auf und laden Sie zu unserer Strategieklausur ein.<br><br>
              <input type="radio" class="projekte_investment_radio" name="product[price]" value="2400">2400&euro;: Ab diesem Beitrag werden Sie Patron und bestimmen bis zu zweimal im Jahr ein Thema f&uuml;r das <i>scholarium</i>.<br>  
      		</div>
        	<input type="submit" class="profil_inputbutton" name="submit_event_selection" value="Investieren">
		</form>
	</div>
</div>
<?php include('../views/_footer.php'); ?>