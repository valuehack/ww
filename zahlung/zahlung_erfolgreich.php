<?php 

#error log settings
ini_set("log_errors" , "1");
ini_set("error_log" , "../classes/login.log");
ini_set('display_errors', "0");

error_reporting(E_ALL);

require_once('../config/config.php');
require_once('../translations/de.php');

require_once('../classes/General.php');
require_once('../classes/Login.php');
require_once('../classes/Registration.php');

// ini_set("display_errors" , "1");
$general = new General();
$registration = new Registration();
$login = new Login();

$title = 'Zahlung erfolgreich';

if ($login->isUserLoggedIn() == true) 
{
	include('../views/_header_in.php');
}
else
{
  	include('../views/_header_not_in.php');
}

print_r($_COOKIE);

print_r($_SESSION);

?>

<div class="content body_nd">
	<div class="content-area">
		<div class="row">
			<div class="col-8">
				<div class="centered">
					<h2 class="h2__nd">Zahlung erfolgreich</h2>
				</div>
				<div>
					<b>Vielen Dank f&uuml;r Ihre Spende!</b><br>
					<br>
					Die Zahlung wurde erfolgreich durchgef&uuml;hrt. In K&uuml;rze erhalten Sie eine Best&auml;tigung-E-Mail.</p>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 

include('../views/_footer.php'); 

#TESTING ONLY
// #var output block
// echo "<br>POST<br>";
// print_r($_POST);
// echo "<br>";
// echo "<br>GET<br>";
// print_r($_GET);
// echo "<br><br><br>";
// #formats print_r for readability 
// $test = print_r($_SESSION, true);
// $test = str_replace("(", "<br>(", $test);
// $test = str_replace("[", "<br>[", $test);
// $test = str_replace(")", ")<br>", $test);
// echo $test;

?>