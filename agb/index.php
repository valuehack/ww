<?php

// check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
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

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();
$title="AGB";

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    include("../views/_header_in.php");

} else {
    // the user is not logged in. you can do whatever you want here.
    include("../views/_header_not_in.php");
    
}
?>

<!--Content-->
<div class="content">
        <div class="agb">

          <h1>Allgemeine Gesch&auml;ftsbedingungen</h1>
          
	  	  	<h2>1. Anmeldung, Zahlungskonditionen</h2>

          	<p>Die Anmeldung zu den Seminaren kann online &uuml;ber wertewirtschaft.org, per e-Mail, per Fax, telefonisch oder pers&ouml;nlich erfolgen und konstituiert einen Vertragsabschlu&szlig;. Falls nicht anders angegeben, sind Kostenbeitr&auml;ge sp&auml;testens bei der Veranstaltung bar zu begleichen.</p>

			<h2>2. Stornobedingungen, Umbuchung</h2>

          	<p>Die kostenlose Stornierung der Teilnahme ist bei Eintreffen der Stornierung (schriftlich, per Post, per eMail) bis mindestens 14 Tage vor dem Veranstaltungstermin m&ouml;glich. Bei Storno innerhalb von 14 Tagen vor dem Veranstaltungstermin wird eine Stornogeb&uuml;hr von 30% des Seminarpreises verrechnet. Bei Storno innerhalb von 7 Tagen vor dem Veranstaltungsbeginn wird eine Stornogeb&uuml;hr von 50% des Seminarpreises verrechnet. Bei Stornierung am Vortag des Kursbeginns oder bei Nichterscheinen betr&auml;gt die Stornogeb&uuml;hr 100%. Bei Nominierung eines Ersatzteilnehmers entf&auml;llt die Stornogeb&uuml;hr zur G&auml;nze.</p>

          	<h2>3. Veranstaltungsabsage</h2>

          	<p>Das Institut f&uuml;r Wertewirtschaft beh&auml;lt sich vor, Veranstaltungen aus organisatorischen Gr&uuml;nden abzusagen oder auf einen anderen Termin zu verschieben. Im Fall einer Absage erfolgt keine Verrechnung des Seminarpreises bzw. es erfolgt die R&uuml;ckerstattung bereits bezahlter Seminargeb&uuml;hren. Dar&uuml;ber hinaus gehende Schadenersatzanspr&uuml;che sind ausgeschlossen. Bei Ausfall einer Veranstaltung durch Krankheit des Vortragenden oder wegen unvorhersehbarer Ereignisse besteht kein Anspruch auf Durchf&uuml;hrung der Veranstaltung.</p>

          	<h2>4. Ihre Daten</h2>

          	<p>F&uuml;r die interne Bearbeitung werden Ihre Daten elektronisch gespeichert und k&ouml;nnen in weiterer Folge zur Information &uuml;ber Angebote des Instituts f&uuml;r Wertewirtschaft verwendet werden. Das Institut f&uuml;r Wertewirtschaft verpflichtet sich, Ihre Daten mit gr&ouml;&szlig;ter Sorgfalt zu behandeln und keinesfalls an Dritte weiterzugeben.</p>

        </div>
<? include "../views/_footer.php"; ?>