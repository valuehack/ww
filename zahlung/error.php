<?php 

require_once('../config/config.php');
require_once('../translations/de.php');

require_once('../classes/General.php');
require_once('../classes/Login.php');
require_once('../classes/Registration.php');


ini_set("display_errors" , "0");
$general = new General();
$registration = new Registration();
$login = new Login();

$title = 'Fehler';

if ($login->isUserLoggedIn() == true) 
{
	include('../views/_header_in_utf8.php');
}
else
{
  	include('../views/_header_not_in_utf8.php');

}
?>

<div class="content body_nd">
	<div class="content-area">
		<div class="row">
			<div class="col-8">
				<div class="centered">
					<h2 class="h2__nd">Ein Fehler ist aufgetreten</h2>
				</div>
				<div>
					<p>Leider gibt es ein Problem mit Ihrer Anmeldung. Bitte wenden Sie sich an info@scholarium.at.</p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
// include('../views/_footer.php'); 

// #TESTING ONLY
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