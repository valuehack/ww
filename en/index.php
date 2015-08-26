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
    
    	<link rel="shortcut icon" href="http://www.scholarium.at/favicon.ico">
    	<link rel="stylesheet" type="text/css" href="http://www.scholarium.at/style/style.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="http://www.scholarium.at/tools/bootstrap.js"></script>

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
              		<div class="anmelden"><i><a href="http://www.scholarium.at/">Deutsch</a></i></div>
                               	 
            </div>
            <div class="logo">
                <a href="/"><img class="logo_img" src="http://www.scholarium.at/style/gfx/scholarium_logo_w.png" alt="scholarium" name="Home"></a>              	
  			</div>
            <div class="nav">
                <div class="navi"></div>
           </div>
        </header>
        <div class="content">
	<div class="blog">
		<div class="blog_text">
			
			<?php
				$sql = "SELECT * from static_content WHERE (page LIKE 'landing')";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				$entry = mysql_fetch_array($result);
				
				echo $entry[info_en];			
			?>
		
			<div class="centered">
				<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
  					<input class="inputfield" id="user_email" type="email" placeholder=" e-Mail Address" name="user_email" required>
  					<!-- make sure that value is changed in here if form is copied/ captures the place of first reg -->
  					<input type="hidden" name="first_reg" value="landing">
  					<input class="inputbutton" type="submit" name="eintragen_submit" value="Sign In">
				</form>
			</div>
		</div>		
	</div>
</div>

        <footer class="footer">
        	<div class="footer_section">
        		<div class="footer_info">
        			<?php
						$sql = "SELECT * from static_content WHERE (page LIKE 'footer')";
						$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
						$entry = mysql_fetch_array($result);
				
						echo $entry[info];			
					?>
        		</div>
        		<div class="footer_contact">
        			<img src="http://www.scholarium.at/style/gfx/footer_logo.png" alt="Scholarium Logo">
        			<ul>
        				<li>Schl&ouml;sselgasse 19/2/18</li>
        				<li>1080 Wien</li>
        				<li>&Ouml;sterreich</li>
        				<li>&nbsp;</li>
        				<li>E-Mail:&nbsp;<a href="mailto:&#105;nf&#111;&#064;&#115;&#99;ho&#108;&#97;ri&#117;&#109;.&#97;&#116;">&#105;nf&#111;&#064;&#115;&#99;ho&#108;&#97;ri&#117;&#109;.&#97;&#116;</a></li>
					</ul>
					<p><a href="http://www.scholarium.at/agb/">AGB</a></p> 
        		</div>
        	</div>
        	<div class="footer_section">
        		<div class="footer_tm">
        			<p>&copy; scholarium&trade;</p>
        		</div>
        		<div class="footer_social">
        			<ul>
        				<li><a class="footer_social_facebook" href="https://www.facebook.com/wertewirtschaft" target="_blank" title="Besuchen Sie uns auf Facebook"></a></li>
        				<li><a class="footer_social_twitter" href="https://www.twitter.com/wertewirtschaft" target="_blank" title="Folgen Sie uns auf Twitter"></a></li>
        				<li><a class="footer_social_xing" href="https://www.xing.com/companies/institutf%C3%BCrwertewirtschaft" target="_blank" title="Scholarium bei Xing"></a></li>
        				<li><a class="footer_social_youtube" href="https://www.youtube.com/user/Wertewirtschaft" target="_blank" title="Schauen Sie unsere Videos auf YouTube"></a></li>
        			</ul>
        		</div>
        	</div>
        </footer>
    </body>
</html>
<?
}
?>