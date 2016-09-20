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
include "../views/_header_not_in_jubilaeum.php"; 
?>

	<div class="content">
	
		<div class="jubilaeum_head">
		<p>Programm</p>
		</div>
		
		<div class="blog">
			<div class="jubilaeum_body">
			<q>Samstag, 3.12.2016</q>
			<q>Ab 10:00 Uhr Jubil&auml;umskonferenz “Die Zukunft Europas”</q>
			<q><p>Vortragende (u.a.):</p></q>
			<p>Rahim Taghizadegan</p>
			<p>J&ouml;rg Guido H&uuml;lsmann</p>
			<p>Hans-Hermann Hoppe</p>
			<p>Robert Nef</p>
			<p>Daniel Model</p>
			<q>Ab 17:00 Uhr Jubil&auml;umsfeier</q>
			<p>Er&ouml;ffnung im Prunksaal</p>
			<p>Festessen im Augustinerlesesaal</p>
			<p>Kulturprogramm im Oratorium</p>
			<p>Bar im Foyer und Engelraum</p>
			<q>Optionales Zusatzprogramm am Freitag und Sonntag.</q>
			</div>
		</div>

		<div class="blog">
			<div class="jubilaeum_body2">
			<p>Konferenz und Festessen finden in den Räumlichkeiten der berühmten Österreichischen Nationalbibliothek statt, einer der umfangreichsten Universalbibliotheken der Welt.</p>
			</div>
		</div>
		
		<div class="prunksaal">
    	<a href="/"><img class="prunksaal" src="../style/gfx/prunksaal.jpg" alt="scholarium" name="Home"></a>                 
        </div>
		
		<div class="jubilaeum_head2">
		<p>Anmeldung</p>
		</div>
	</div>
	
		<div class="centered">
    <script type="text/javascript" src="https://ZLNVLYY-modules.xing-events.com/resources/js/amiandoExport.js"></script><iframe src="https://ZLNVLYY-modules.xing-events.com/ZLNVLYY.html?viewType=iframe&distributionChannel=CHANNEL_IFRAME&useDefaults=false&resizeIFrame=true" frameborder="0" width="650px" height="650px" id="_amiandoIFrame2907520"><p>Diese Seite benötigt die Unterstützung von Frames durch Ihren Browser. Bitte nutzen Sie einen Browser, der die Darstellung von Frames unterstützt, damit das Ticketvorverkaufs-Modul angezeigt werden kann.</p><p>Probieren Sie die XING Events <a href="https://www.xing-events.com">online Registrierung</a> noch heute aus.</p></iframe><p style="text-align: left; font-size:10px;"><a href="https://www.xing-events.com?viralRefId=ZLNVLYY&utm_campaign=ev-ZLNVLYY&utm_medium=viral&utm_source=EventWebsite&utm_content=TextLinkBottom&utm_term=text-link" target="_blank" alt="Konferenz - Online Event Management" title="Konferenz - Online Event Management" >Konferenz - Online Event Management</a> mit der Ticketing-Lösung von XING Events</p>
	</div></div>

	
<? include "../views/_footer.php"; ?>

