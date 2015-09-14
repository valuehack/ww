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
require_once('../translations/de.php');

// include the PHPMailer library
require_once('../libraries/PHPMailer.php');

// load the login class
require_once('../classes/Login.php');
require_once('../classes/Registration.php');

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();
$registration = new Registration();
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
          
	  	  	<h2>1. Geltung der AGB</h2>

          	<p>Die Leistung s&auml;mtlicher Unterst&uuml;tzungsbeitr&auml;ge und Spenden sowie die Bez&uuml;ge von Scholien, Schriften, digitalen Medien sowie die Teilnahme an Seminaren und Veranstaltungen erfolgt ausschlie&szlig;lich gem&auml;&szlig; den nachfolgenden Allgemeinen Gesch&auml;ftsbedingungen der scholarium GmbH. M&uuml;ndliche Nebenabreden wurden nicht getroffen. Die AGB k&ouml;nnen von Ihnen auf Ihrem Rechner abgespeichert und/oder ausgedruckt werden.</p>
          	
          	<p>Ihr Vertragspartner ist:</p>
          	
          	<ul>
          		<li>scholarium GmbH</li>
          		<li>Schl&ouml;sselgasse 19/2/18</li>
          		<li>A-1080 Wien</li>
          		<li>FN 437260 f</li>
          		<li>Gesch&auml;ftsf&uuml;hrer: DI Rahim Taghizadegan</li>
          		<li>Kontakt: info@scholarium.at</li>
          	</ul>

			<h2>2. Unterst&uuml;tzungsbeitr&auml;ge und Spenden</h2>

          	<p>Die Unterst&uuml;tzungsbeitr&auml;ge und Spenden an die scholarium GmbH (Gast, Teilnehmer, Scholar, Partner, Beirat, Ehrenpr&auml;sident) erm&ouml;glichen den Bezug von Scholien, Schriften, digitalen Medien sowie die Teilnahme an Veranstaltungen, stellen jedoch keinen unmittelbaren Anspruch auf Gegenleistung dar. Erst der Bezug der genannten Produkte/Dienstleistungen konstituiert einen Vertragsabschluss mit Lieferverpflichtung seitens der scholarium GmbH.</p>

          	<h2>3. Anmeldung, Zahlungskonditionen f&uuml;r Veranstaltungen</h2>

          	<p>Die Kostenbeitr&auml;ge f&uuml;r Produkte und Dienstleistungen der scholarium GmbH werden &uuml;ber das Online-Einkaufskonto des Kunden (auch Kundenkonto) auf unserer Homepage verrechnet. Die Anmeldung zu den Seminaren und Veranstaltungen erfolgt online &uuml;ber das Kundenkonto des Unterst&uuml;tzers. Die Zahlung der Beitr&auml;ge erfolgt im Voraus per Bank&uuml;berweisung, PayPal (Kreditkarten) oder in bar. </p>

          	<h2>4. Laufzeit der Unterst&uuml;tzungsbeitr&auml;ge</h2>

          	<p>Die gew&auml;hlten Unterst&uuml;tzungsbeitr&auml;ge (Gast, Teilnehmer, Scholar, Partner, Beirat, Ehrenpr&auml;sident) erm&ouml;glichen den Bezug von Produkten/Dienstleistungen der scholarium GmbH innerhalb eines Jahres (ab Zeitpunkt der erstmaligen Zahlung). Ein Upgrade der Unterst&uuml;tzungsbeitr&auml;ge ist jederzeit m&ouml;glich und verl&auml;ngert die Bezugslaufzeit wieder um ein Jahr. Ist &uuml;ber ein Jahr keine Einzahlung erfolgt, kann erst nach erneuter Einzahlung wieder auf das vorhandene Guthaben zugegriffen werden.</p>
          	
          	<h2>5. Stornobedingungen, Umbuchung</h2>
          	
          	<p>Die kostenlose Stornierung der Teilnahme an Seminaren und Veranstaltungen ist bei Eintreffen der Stornierung (schriftlich, per Post oder per eMail) bis mindestens 14 Tage vor dem Veranstaltungstermin m&ouml;glich. Bei Storno innerhalb von 14 Tagen vor dem Veranstaltungstermin wird eine Stornogeb&uuml;hr von 30% des Seminar-Veranstaltungspreises verrechnet. Bei Storno innerhalb von 7 Tagen vor dem Veranstaltungsbeginn wird eine Stornogeb&uuml;hr von 50% des Seminar-Veranstaltungspreises verrechnet. Bei Stornierung am Vortag des Kursbeginns oder bei Nichterscheinen betr&auml;gt die Stornogeb&uuml;hr 100%. Bei Nominierung eines Ersatzteilnehmers entf&auml;llt die Stornogeb&uuml;hr zur G&auml;nze.</p>
          	
          	<h2>6. Veranstaltungsabsage</h2>
          	
          	<p>Die scholarium GmbH beh&auml;lt sich vor, Veranstaltungen aus organisatorischen Gr&uuml;nden abzusagen oder auf einen anderen Termin zu verschieben. Im Fall einer Absage erfolgt keine Verrechnung des Seminar-Veranstaltungspreises bzw. es erfolgt die R&uuml;ckerstattung bereits bezahlter Geb&uuml;hren auf das Kundenkonto. Dar&uuml;ber hinaus gehende Schadenersatzanspr&uuml;che sind ausgeschlossen. Bei Ausfall einer Veranstaltung durch Krankheit des Vortragenden oder wegen unvorhersehbarer Ereignisse besteht kein Anspruch auf Durchf&uuml;hrung der Veranstaltung.</p>
          	
          	<h2>7. Ihre Daten</h2>
          	
          	<p>Alle personenbezogenen Daten werden mit gr&ouml;&szlig;ter Sorgfalt behandelt und grunds&auml;tzlich vertraulich behandelt und Ihre schutzw&uuml;rdigen Belange entsprechend den gesetzlichen Vorgaben streng ber&uuml;cksichtigt.</p>
			<p>F&uuml;r die interne Bearbeitung werden Ihre Daten elektronisch gespeichert und k&ouml;nnen in weiterer Folge zur Information &uuml;ber Angebote der scholarium GmbH verwendet werden sowie gegebenenfalls an und verbundene Unternehmen oder unsere Dienstleistungspartner weitergegeben. </p>

			<p><a href="scholarium_agb.pdf">Eine pdf Version unserer AGB finden Sie hier.</a></p>
        </div>
<? include "../views/_footer.php"; ?>