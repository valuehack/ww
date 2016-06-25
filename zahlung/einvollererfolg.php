<?php 

ini_set("display_errors" , "1");

require_once('../config/config.php');


// include('../views/_db.php'); 






require_once('../translations/de.php');

require_once('../classes/Login.php');
require_once('../classes/Registration.php');

$registration = new Registration();
$login = new Login();

if ($login->isUserLoggedIn() == true) 
{
	include('../views/_header_in.php'); 
}
else
{
  include('../views/_header_not_in.php'); 

}


#create a template 
#display info based on 
?>

<div class="content"><div class="content-area"><div class="row-group">

<div class="row row__body"><div class="col-8">
Vielen Dank f&uuml;r Ihre Unterst&uuml;tzung. Die Zahlung wurde erfolgreich durchgef&uuml;hrt.

In K&uuml;rze erhalten Sie eine Nachricht als Best&auml;tigung.
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</div></div>


</div></div></div>

<?php 

// include('../views/_footer.php'); 

#TESTING ONLY
#var output block
echo "<br>POST<br>";
print_r($_POST);
echo "<br>";
echo "<br>GET<br>";
print_r($_GET);
echo "<br><br><br>";
#formats print_r for readability 
$test = print_r($_SESSION, true);
$test = str_replace("(", "<br>(", $test);
$test = str_replace("[", "<br>[", $test);
$test = str_replace(")", ")<br>", $test);
echo $test;

?>
