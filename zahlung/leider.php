<?php 

require_once('../config/config.php');
require_once('../translations/de.php');

require_once('../classes/General.php');
require_once('../classes/Login.php');
require_once('../classes/Registration.php');


ini_set("display_errors" , "1");
$general = new General();
$registration = new Registration();
$login = new Login();

$title = 'Leider';

if ($login->isUserLoggedIn() == true) 
{
	include('../views/_header_in_utf8.php');
}
else
{
  	include('../views/_header_not_in_utf8.php');

}

echo "Leider es gibts problem mit anmeldung. Haben Sie bitte geduld when we fix it und schreibe nach info@scholarium.at";

// // include('../views/_footer.php'); 

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