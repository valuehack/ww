<?php

// check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once('libraries/password_compatibility_library.php');
}
// include the config
require_once('config/config.php');

// include the to-be-used language, english by default. feel free to translate your project and include something else
require_once('translations/de.php');

// include the PHPMailer library
require_once('libraries/PHPMailer.php');

// load the login class
require_once('classes/Login.php');
require_once('classes/Registration.php');

include("views/_db.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();
$registration = new Registration();
$title="Mitwirkende";

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    include("views/_header_in.php");

} else {
    // the user is not logged in. you can do whatever you want here.
    include("views/_header_not_in.php");
    
}

	$get_crew = $pdocon->db_connection->prepare("SELECT * from crew order by level asc");
	$get_crew->execute();
	$crew_result = $get_crew->fetchAll();	

?>

<div class="content">
	<div class="blog">
		<header>
			<h1>Mitwirkende</h1>
		</header>
		<div class="blog_text">
<?php			
		$check_lvl1 = 0;
		$check_lvl2 = 0;
		$check_lvl3 = 0;
		$check_lvl4 = 0;
		$check_lvl5 = 0;
		$check_lvl6 = 0;
		$check_lvl7 = 0;
		$check_lvl8 = 0;
		
		for ($i=0; $i < count($crew_result); $i++) {
				
			$level = $crew_result[$i]['level'];
			$id = $crew_result[$i]['id'];
			$link = $crew_result[$i]['link'];
			$name = $crew_result[$i]['name'];
			$text_de = $crew_result[$i]['text_de'];
			
			if ($level == 1){
				if ($check_lvl1 == 0){
					$check_lvl1 = 1;
					echo '<p class="crew_levels">Rektor</p>'; 
				}
			}
			if ($level == 2){
				if ($check_lvl2 == 0){
					$check_lvl2 = 1;
					echo '<p class="crew_levels">Gr&uuml;nder</p>'; 
				}
			}
			if ($level == 3){
				if ($check_lvl3 == 0){
					$check_lvl3 = 1;
					echo '<p class="crew_levels">Mitarbeiter</p>'; 
				}
			}
			if ($level == 4){
				if ($check_lvl4 == 0){
					$check_lvl4 = 1;
					echo '<p class="crew_levels">Mentoren</p>'; 
				}
			}
			if ($level == 5){
				if ($check_lvl5 == 0){
					$check_lvl5 = 1;
					echo '<p class="crew_levels">Ehrenpr&auml;sidenten</p>'; 
				}
			}
			if ($level == 6){
				if ($check_lvl6 == 0){
					$check_lvl6 = 1;
					echo '<p class="crew_levels">Beir&auml;te</p>'; 
				}
			}
			if ($level == 7){
				if ($check_lvl7 == 0){
					$check_lvl7 = 1;
					echo '<p class="crew_levels">Partner</p>'; 
				}
			}
			if ($level == 8){
				if ($check_lvl8 == 0){
					$check_lvl8 = 1;
					echo '<p class="crew_levels">Studenten</p>'; 
				}
			}
?>			
			<div class="crew">
				<div class="crew__col-1">
					<img src="http://craftprobe.com/img/<?=$id?>.jpg">
					<a href="http://<?=$link?>"><?=$link?></a>
				</div>
				<div class="crew__col-4">
					<h1><?=$name?></h1>
					<p><?=$text_de?></p>
				</div>
			</div>
<?php
		}
?>				
			<div class="centered">
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform">
  					<input class="inputfield" id="user_email" type="email" placeholder=" E-Mail Adresse" name="user_email" required>
  					<input type=hidden name="first_reg" value="faq">
  					<input class="inputbutton" type="submit" name="eintragen_submit" value="Eintragen">
				</form>
			</div> 
		</div>		
	</div>
</div>

<?php include('views/_footer.php'); ?>