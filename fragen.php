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

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();
$registration = new Registration();
$title="Haeufige Fragen";

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    include("views/_header_in.php");

} else {
    // the user is not logged in. you can do whatever you want here.
    include("views/_header_not_in.php");
    
}

?>

<div class="content">
	<div class="blog">
		<header>
			<h1>H&auml;ufige Fragen</h1>
		</header>
		<div class="blog_text">
			
			<?php
				$sql = "SELECT * from static_content WHERE (page LIKE 'faq')";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				$entry = mysql_fetch_array($result);
				
				echo $entry[info];			
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