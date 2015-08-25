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
require_once('../classes/Login.php');
require_once('../classes/Registration.php');

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.

$registration = new Registration();
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) 
{
	#temporarly differentiation between normal users and testers/developers
	$user_id = $_SESSION['user_id'];
	$user_email = $_SESSION['user_email'];
	
	$query = "SELECT * from mitgliederExt WHERE `user_id` LIKE '%$user_id%' AND `user_email` LIKE '%$user_email%' ";
	$result = mysql_query($query) or die("Failed Query of " . $query. mysql_error());
	$entry = mysql_fetch_array($result);
	
	$test = $entry[test];
	
	if ($test == ''){
		include("../views/upgrade_in_temp.php");
	}
	elseif ($test == 1){
    	include("../views/index_in.php");
	}
} 
else 
{
?>

<!DOCTYPE html>
<html lang="en">
	<head>  
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Welcome | Scholarium</title>
    
    	<link rel="shortcut icon" href="/favicon.ico">
    	<link rel="stylesheet" type="text/css" href="../style/style.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="../tools/bootstrap.js"></script>

    	<!-- this is used for this fancy login form -->
    	<script language="javascript" src="/js/jquery.js"></script>
    	<script language="javascript" src="/js/script.js"></script>

		<!-- Google Analytics Code -->
		<script type="text/javascript">
  			var _gaq = _gaq || [];
  			_gaq.push(['_setAccount', 'UA-39285642-1']);
  			_gaq.push(['_trackPageview']);

  			(function() {
    			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  			})();
		</script>
		
		<!-- Social Links PopUp -->
		<script type="text/javascript">
			function openpopup (url) {
   			popup = window.open(url, "popup1", "width=640,height=480,status=yes,scrollbars=yes,resizable=yes");
   			popup.focus();
			}
		</script>
	</head>
		
<?php
//set timezone
mysql_query("SET time_zone = 'Europe/Vienna'");

?>

<?php

    $ok2 = $_POST['ok2'];
?>	
	
	<body>
        <header class="header">
        	<div class="login">

                  <?php

                  // show potential errors / feedback (from login object)
              if (isset($login)) {
                  if ($login->errors) {
                      foreach ($login->errors as $error) {
                          #add some html to make it look nicer
                          
                        ?><p class='error'> <?php echo $error; ?> </p> <?php
                      }
                  }
                  if ($login->messages) {
                      foreach ($login->messages as $message) {
                          #echo $message;
                          ?><p class='message'> <?php echo $message; ?> </p> <?php
                      }
                  }
              }
              // show potential errors / feedback (from registration object)
              if (isset($registration)) {
                  if ($registration->errors) {
                      foreach ($registration->errors as $error) {
                          #echo $error;
                      ?><p class='error'> <?php echo $error; ?> </p> <?php
                      }
                  }
                  if ($registration->messages) {
                      foreach ($registration->messages as $message) {
                          #echo $message;
                          ?><p class='message'> <?php echo $message; ?> </p> <?php
                      }
                  }
              }
              ?>
              		<div class="anmelden"><i><a href="http://www..scholarium.at/">Deutsch</a></i></div>
                	<div class="anmelden"><button class="login_button" type="button" data-toggle="modal" data-target="#signup" value="Anmelden">Sign In</button></div>
                	<div class="anmelden"><button class="login_button" type="button" data-toggle="modal" data-target="#login" value="Anmelden">Log In</button></div>
                	 
            </div>
            <div class="logo">
                <a href="/"><img class="logo_img" src="../style/gfx/scholarium_logo_w.png" alt="scholarium" name="Home"></a>
                	
<!-- Login Modal -->
  <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog-login">
      <div class="modal-content-login">
      	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-header">

          <h2 class="modal-title" id="myModalLabel">Log In</h2>
        </div>
        <div class="modal-body">
          <p>
          	<form method="post" action="index.php" name="registerform">
          		<input class="inputfield_login" id="keyword" type="email" placeholder=" e-Mail Address" name="user_email" autocomplete="on" autofocus required><br>
          		<input class="inputfield_login" id="user_password" type="password" name="user_password" placeholder=" Password" required><br>
          		<input class="inputbutton_login" id="inputbutton" name="anmelden_submit" type="submit" value="Log In">
          	</form>     
          	<p class="password_login"><a href="/password_reset.php">Forgott your password?</a></p>  	
          </p>
        </div>
      </div>
    </div>
  </div>
<!-- Sign Up Modal -->  
  <div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog-login">
      <div class="modal-content-login">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-header">

          <h2 class="modal-title" id="myModalLabel">Sign In</h2>
        </div>
        <div class="modal-body">
          <p>
            <form method="post" action="index.php" name="registerform">
                <input class="inputfield_login" id="keyword" type="email" placeholder=" e-Mail Address" name="user_email" required><br>
                <input class="inputbutton_login" id="inputbutton" name="eintragen_submit" type="submit" value="Sign In">
            </form>         
          </p>
        </div>
      </div>
    </div>
  </div>           	
  				</div>
            <div class="nav">
                <div class="navi"></div>
           </div>
        </header>
        <div class="content">
	<div class="blog">
		<div class="blog_text">
			
			<?php
				$sql = "SELECT * from static_content WHERE (page LIKE 'buerger')";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				$entry = mysql_fetch_array($result);
				
				echo $entry[info_en];			
			?>
		
			<div class="centered">
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform">
  					<input class="inputfield" id="user_email" type="email" placeholder=" e-Mail Address" name="user_email" required>
  					<!-- make sure that value is changed in here if form is copied/ captures the place of first reg -->
  					<input type="hidden" name="first_reg" value="landing">
  					<input class="inputbutton" type="submit" name="eintragen_submit" value="Sign In">
				</form>
			</div>
		</div>		
	</div>
</div>

<?php include('views/_footer.php'); ?>
<?
}
?>