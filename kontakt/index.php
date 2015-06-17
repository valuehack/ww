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
require_once('../classes/Registration.php');

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();
$registration = new Registration();
$title="Impressum";

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    include("../views/_header_in.php");

} else {
    // the user is not logged in. you can do whatever you want here.
    include("../views/_header_not_in.php");
    
}
?>

<div class="content">
	<div class="agb">
		<h1>Impressum</h1>
	</div>
	<div class="medien_seperator">
		<h1>Disclaimer</h1>
	</div>
	<div class="agb">
		<p>Disclaimer</p>
	</div>
	<div class="medien_seperator">	
		<h1>Kontakt</h1>
	</div>
	<div class="location_box">  
   		<table>
   			<tr>
   				<td>
   					<p>Wertewirtschaft<br>
					   Schl&ouml;sselgasse 19/2/18<br>
					   A-1080 Wien, &Ouml;sterreich</p>
				</td>
				<td>
    				<p>Fax: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+43 1 2533033 4733<br>
    					E-Mail: &nbsp;<a href="mailto:&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;">&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;</a></p>
   				</td> 
   			</tr>
   		</table>
   		<div>
   			<iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.de/maps?f=q&amp;source=s_q&amp;hl=de&amp;geocode=&amp;q=Schl%C3%B6sselgasse+19%2F18+1080+Wien,+%C3%96sterreich&amp;aq=0&amp;oq=Schl%C3%B6sselgasse+19%2F18,+1080+Wien&amp;sll=51.175806,10.454119&amp;sspn=7.082438,21.643066&amp;ie=UTF8&amp;hq=&amp;hnear=Schl%C3%B6sselgasse+19,+Josefstadt+1080+Wien,+%C3%96sterreich&amp;t=m&amp;z=14&amp;ll=48.213954,16.353095&amp;output=embed"></iframe><br /><small><a href="https://maps.google.de/maps?f=q&amp;source=embed&amp;hl=de&amp;geocode=&amp;q=Schl%C3%B6sselgasse+19%2F18+1080+Wien,+%C3%96sterreich&amp;aq=0&amp;oq=Schl%C3%B6sselgasse+19%2F18,+1080+Wien&amp;sll=51.175806,10.454119&amp;sspn=7.082438,21.643066&amp;ie=UTF8&amp;hq=&amp;hnear=Schl%C3%B6sselgasse+19,+Josefstadt+1080+Wien,+%C3%96sterreich&amp;t=m&amp;z=14&amp;ll=48.213954,16.353095"></iframe>
		</div>
   </div>
</div>

<? include "../views/_footer.php"; ?>