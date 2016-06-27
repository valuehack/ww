<?php 

require_once('../config/config.php');
require_once('../translations/de.php');

require_once('../classes/General.php');
require_once('../classes/Login.php');
require_once('../classes/Registration.php');


// ini_set("display_errors" , "1");
$general = new General();
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

$next_salon = $general->getProducts($type=array('salon'), $status = 2, $show_passed = false, $show_soldout = false);
$next_seminar = $general->getProducts($type=array('seminar'), $status = 2, $show_passed = false, $show_soldout = false);
#create a template 
#display info based on 
?>

<div class="content">
	<div class="content-area">
		<div class="row-group">
			<div class="row row__body">
				<div class="col-8 salon_content">
					<div class="centered">
						<h2>Zahlung erfolgreich</h2>
					</div>
					<div>
						<p>Sehr <?=$anrede?> <?=$name?>,<br>
						<br>
						<b>Vielen Dank f&uuml;r Ihre Spende.</b><br>
						<br>
						Die Zahlung wurde erfolgreich durchgef&uuml;hrt. In K&uuml;rze erhalten Sie eine Nachricht als Best&auml;tigung.</p>
					</div>
<?php
						if (count($next_salon) > 0 || count($next_seminar) > 0) { 
?>						
							<div>
								<p>In der Zwischenzeit m&ouml;chten wir Sie gerne auf einige unserer <a href="../veranstaltungen/">n&auml;chsten Veranstaltung</a> hinweisen.</p>
							</div>
							<div>
<?php
								if (count($next_salon) > 5) {$j = 5;}
								else {$j = count($next_salon);}
					
								for ($i = 0; $i < $j; $i++ ) {
?>
								<div class="basket_body_type">
									<span><?=ucfirst($next_salon[$i]['type'])?></span>
									<em><?=$general->getDate($next_salon[$i]['start'], $next_salon[$i]['end'])?></em>
								</div>
							</div>
<?php
							}
						}
?>															
			</div>
		</div>
	</div>
</div>

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
