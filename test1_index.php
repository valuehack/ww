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

// handling for "reality check"-form which was previously done on craftprobe.com; it is all done here
// to avoid confusion with the normal registration/login process on scholarium.at

try {
	$db = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
} catch(PDOException $e) {
	echo 'Connection failed: '.$e->getMessage();
}

$ok = $_POST['ok'];
$email = $_POST['email'];
$sub_date = date('Y-m-d H:i:s');

if ($ok) {

$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
$in_query = $db->prepare(
	'INSERT INTO coaching_en_anmeldung (
		email,
		sub_date
		)
	VALUES (
		:email,
		:sub_date
		)'
);

$in_query->bindValue(':email', $email, PDO::PARAM_STR);
$in_query->bindValue(':sub_date', $sub_date, PDO::PARAM_STR);
$in_query->execute();

//Email an Interessenten

$to = $email;
$subject = "Thank you for joining!";
$message = "Hey,\n\n
We are glad that you are interested in joining our program and we will get back to you shortly.\n\n
Looking forward to seeing you in Vienna!\n
The scholarium team\n\n";

$headers = array();
$headers[] = "From: info@scholarium.at";
$headers[] = "Content-Type: text/plain; charset=iso-8859-1";
$headers[] = "Content-Transfer-Encoding: 8bit";
$headers[] = "X-Mailer: SimpleForm";

mail ($to, $subject, $message, implode("\r\n", $headers));

//Email an Uns

$to = "info@scholarium.at";
$subject = "Anmeldung Reality Check";
$message = "$email hat sich als Interessent fuer den Reality Check eingetragen";

$headers = array();
$headers[] = "From: info@scholarium.at";
$headers[] = "Content-Type: text/plain; charset=iso-8859-1";
$headers[] = "Content-Transfer-Encoding: 8bit";
$headers[] = "X-Mailer: SimpleForm";

mail ($to, $subject, $message, implode("\r\n", $headers));
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>  
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Welcome | scholarium</title>
    
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
		
		<!-- hide bot prevention field for normal users with jquery -->
		<script type="text/javascript">
			$(document).ready(function(){
			  $(".req").hide();
			})
		</script>
	</head>
		
<?php
//set timezone
mysql_query("SET time_zone = 'Europe/Vienna'");


//if-condition to distinguish different headers (in vs. not_in); copied from _header-files in views-folder
// here is the beginning of header_in
if ($login->isUserLoggedIn() == true) 
{
	$user_id = $_SESSION['user_id'];
	$user_email = $_SESSION['user_email'];
	
	$query = "SELECT * from mitgliederExt WHERE `user_id` LIKE '%$user_id%' AND `user_email` LIKE '%$user_email%' ";
	$result = mysql_query($query) or die("Failed Query of " . $query. mysql_error());
	$entry = mysql_fetch_array($result);

//getting the number of items in the basket
$total_quantity = 0;

if(isset($_SESSION['basket'])){
    $basket = $_SESSION['basket'];

    foreach ($basket as $code => $quantity) {
        $length = strlen($code) - 1;
        $key = substr($code,0,$length);

        $project_query = "SELECT * from produkte WHERE `n` LIKE '$key'";
        $project_result = mysql_query($project_query) or die("Failed Query of " . $project_query. mysql_error());
        $itemsPriceArray = mysql_fetch_array($project_result);

        if ($itemsPriceArray['type'] == 'projekt') {
            $total_quantity += 1;
        }
        else {
            $total_quantity += $quantity;
        }
    }
}

if(isset($_POST['add'])){
    $add_quantity = $_POST['quantity'];

    if(isset($_POST['projekt'])) {
        $total_quantity = $total_quantity + 1;
    }
    else {
        $total_quantity = $total_quantity + $add_quantity;
    }    
}

elseif(isset($_POST['delete'])) {
    $total_quantity = 0;
}

elseif(isset($_POST['checkout'])) {
    $total_quantity = 0;
}

elseif(isset($_POST['remove'])) {
    $remove_id = $_POST['remove'];
    $remove_quantity = $_SESSION['basket'][$remove_id];

    if(isset($_POST['projekt'])) {
        $total_quantity = $total_quantity - 1;
    }
    else {
         $total_quantity = $total_quantity - $remove_quantity;
    }  
}

    //$basket_quantity = count($basket);  

if (!isset($user_id)) echo "";
else
{
$query = "SELECT * from mitgliederExt WHERE `user_id` LIKE '%$user_id%' AND `user_email` LIKE '%$user_email%' ";

$result = mysql_query($query) or die("Failed Query of " . $query. mysql_error());

while ($entry = mysql_fetch_array($result))
{
    switch ($entry['Mitgliedschaft']) {
        case 1:
            $Mitgliedschaft = 'Interessent';
            break;
        case 2:
            $Mitgliedschaft = 'Gast';
            break;
        case 3:
            $Mitgliedschaft = 'Teilnehmer';
            break;
        case 4:
            $Mitgliedschaft = 'Scholar';
            break;
        case 5:
            $Mitgliedschaft = 'Partner';
            break;
        case 6:
            $Mitgliedschaft = 'Beirat';
            break;
        default: 
            $Mitgliedschaft = 'Patron';
            break;
        }
	$mitgliedschaft = $entry['Mitgliedschaft'];
	
	$expired = strtotime($entry['Ablauf']);
?>

<body>
<!-- Layout-->
        <header class="header">

            <div class="login">   
                <?php
			  if ($expired < time()) {
      			?>
        		<p class="error">Ihre letzte Unterst&uuml;tzung ist mehr als ein Jahr her, <a href="../spende/">bitte unterst&uuml;tzen Sie uns erneut</a>, um wieder vollen Zugriff zu erhalten.</p>
        	<?php
			}
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
				
                <div class="dropdown"><button class="login_button" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="<? echo $entry['user_email'];?>"><? echo $entry['user_email'];?><span class="caret"></span></button>
                		<ul class="dropdown-menu dropdown_menu dropdown-menu-right dropdown_menu" role="menu" aria-labelledby="dLabel">
                			<li class="dropdown-header dropdown_name"><? echo $entry['Vorname']." ".$entry['Nachname'];?></li>
                            <li class="dropdown-header dropdown_level"><? echo $Mitgliedschaft;?></li>
                			<li><a href="/spende/profil.php">Profil</a></li>
                			<li><a href="/spende/">Unterst&uuml;tzen</a></li>
                			<?php if ($mitgliedschaft >= 2){ ?>
                			<li class="divider"></li>
                      		<li class="dropdown-header dropdown_credits">Guthaben: <?echo $entry['credits_left'];?> <img class='dropdown_coin' src="/style/gfx/coin.png"></li>
                			<li><a href="/spende/korb.php">Warenkorb <span class="badge"><?echo $total_quantity;?></span></a></li> 
                			<li><a href="/spende/bestellungen.php">Bestellungen</a></li>
                			<li class="divider"></li>
                			<?php } ?>
                			<li><a href="/logout.php?logout">Abmelden</a></li>        			               		
                		</ul>
                	</div>
                			<?php if ($mitgliedschaft >= 2){ ?>
                	<div class="login_basket"><a href="../spende/korb.php">Warenkorb <span class="badge"><?echo $total_quantity;?></span></a></div>
<?
							} ?>
					
                	<div class="login_basket"><i><a href="../?sprache=de">Deutsch</a></i></div>
<?
	#isset and while-loop
		}
	}
?>
            </div>
            <div class="logo">
                <a href="/"><img class="logo_img" src="../style/gfx/scholarium_logo_w.png" alt="scholarium" name="Home"></a>                 
            </div>
            
            <div class="nav">
                <div class="navi">
                <ul id="nav">
            
                    <li id="navelm"><a class="navelm" id="drop2" data-toggle="dropdown" href="/scholien/" data-target="#" role="button" aria-haspopup="true" aria-expanded="false">Scholien</a>
                    	<div class="subnav dropdown-menu" aria-labelledby="drop2">
                    	<ul>
                    		<li class="subnav_head"><a class="subnav_head" href="/scholien/">Scholien</a></li>
                    		<li><a href="/scholien/">Artikel</a></li>
                    		<li><a href="/scholienbuechlein/">B&uuml;chlein</a></li>
                    	</ul>
                    	</div>
                    </li>
                    <li id="navelm"><a class="navelm" id="drop1" data-toggle="dropdown" href="/veranstaltungen/" data-target="#" role="button" aria-haspopup="true" aria-expanded="false">Veranstaltungen</a>
                    	<div class="subnav dropdown-menu" aria-labelledby="drop1">
                    	<ul>
                    		<li class="subnav_head"><a class="subnav_head" href="/veranstaltungen/">Veranstaltungen</a></li>
                    		<li><a href="/veranstaltungen/">Alle</a></li>
                    		<li><a href="/salon/">Salon</a></li>
                    		<li><a href="/seminare/">Seminare</a></li>
                    		<li><a href="/vortrag/">Vortrag</a></li>
                    	</ul>
                    	</div>
                    </li>
                    <li id="navelm"><a class="navelm" href="/buecher/">B&uuml;cher</a></li>
                    <li id="navelm"><a class="navelm" id="drop3" data-toggle="dropdown" href="/medien/" data-target="#" role="button" aria-haspopup="true" aria-expanded="false">Medien</a>
                    	<div class="subnav dropdown-menu" aria-labelledby="drop3">
                    	<ul>
                    		<li class="subnav_head"><a class="subnav_head" href="/medien/">Medien</a></li>
                    		<li><a href="/medien/">Alle</a></li>
                    		<li><a href="/medien/?type=media-salon">Salon</a></li>
                    		<li><a href="/medien/?type=media-vorlesung">Vorlesung</a></li>
                    		<li><a href="/medien/?type=media-vortrag">Vortrag</a></li>
                    	</ul>
                    	</div>
                    </li>
                    
                    <li id="navelm"><a class="navelm" id="drop4" data-toggle="dropdown" href="/studium/" data-target="#" role="button" aria-haspopup="true" aria-expanded="false">Studium</a>
                    	<div class="subnav dropdown-menu" aria-labelledby="drop4">
                    	<ul>
                    		<li class="subnav_head"><a class="subnav_head" href="/studium/">Studium</a></li>
                    		<li><a href="/studium/?q=orientierungscoaching">Orientierungscoaching</a></li>
                    		<li><a href="/studium/?q=studium">Studium generale</a></li>
                    		<li><a href="/studium/?q=baader-stipendium">Stipendium</a></li>
                    		<li><a href="/studium/?q=beratung">Beratung</a></li>
                    	</ul>
                    	</div>
                    <li id="navelm"><a class="navelm" href="/projekte/">Projekte</a></li>
                </ul>
                </div>
           </div>
        </header>
<?php			
} 

//header for not_in-view
else {
?>
	
	<body>
        <header class="header">
        	<div class="login">
              		<div class="anmelden"><i><a href="../?sprache=de">Deutsch</a></i></div>
                               	 
            </div>
            <div class="logo">
                <a href="/"><img class="logo_img" src="http://www.scholarium.at/style/gfx/scholarium_logo_w.png" alt="scholarium" name="Home"></a>              	
  			</div>
            <div class="nav">
                <div class="navi"></div>
           </div>
        </header>
        
        <?   
        
        }

//from here on the page is the same for in and not_in

//check if bot-field is filled out
				
				if($_POST['website'] != '') {
					echo '<p class="error">
					Something went wrong. Please try again.
					</p>';
				}

//show form success message if submit and no bot
        		if($ok == 1 && $_POST['website'] == '') {
					echo '<div class="basket_message">
					<h1>Thank you for your interest!</h1><br>
					<p>We will get back to you shortly.</p>
					</div>';
		}
?>
        
        <div class="content">
	<div class="blog">
		<div class="blog_text">
		
			<p><em>scholarium</em> is a private, tax-exempted institution founded by successful entrepreneurs and visionaries from Austria, Germany, Liechtenstein and Switzerland eager to pass on the spark to future generations. It is one of the last remaining research centers where the original Austrian School of Economics is alive, boasting the largest library on this tradition in Europe. Our director, Rahim Taghizadegan, is not only as an economist the foremost Austrian expert on the Austrian School of Economics, but also a trained physicist and engineer (specialization in nuclear physics and complex systems), a renowned philosopher and a visionary entrepreneur. He has taught at many universities around the world, is a best-selling book author and a sought-after public speaker. As one of the last Viennese polymaths he brings together profound theory and innovative practice.</p>
			<p>The Austrian School is frequently misunderstood as an ideological program, while it is in fact a research tradition closely linked to other traditions arising in the old Vienna – formerly one of the most important hubs of science, culture and entrepreneurship. What makes the Austrian School special is its realistic, no-nonsense approach, its philosophical scope, and its focus on entrepreneurship and the dynamics of complex systems. This research tradition in its original scope and depth cannot be studied as a college degree, because it is interdisciplinary and has to be applied to real-life, entrepreneurial decisions. It is the only economic tradition that cherishes entrepreneurship while at the same time being highly critical of the financially and politically inflated bubble economy and the concomitant inflation of bullshit.</p>
			<p>The <em>scholarium</em> is located in one of the most ancient, creative and educated parts of Vienna (Austria), close to one of the oldest universities of the world (alas, of past glories not much more than the facades has survived), neighboring a beautiful, hidden monastery where the last remaining urban monks tend to their garden and library. In a historic building with high ceilings and impeccable interiors we explore, experiment and innovate within walls adorned by one of the most spectacular private libraries of Vienna. The city is one of the capitals of old European culture, a historic center of science, art, literature, music and trade – giving us access to an ancient treasure trove of thought and creation.</p>
			<p>Our full-time study program in the living Austrian tradition of realistic economics, philosophy and politics is currently only open to those with good command of the German language as we go to the sources and the level of material, discussions and teaching is very high. However, we offer a limited number of English-speaking participants a unique educational program in Vienna.</p>
		
			<h1><em>Reality Check</em> – intense two-week program in Vienna, Austria</h1>
			<p>Young people today are flooded with educational, entrepreneurial and career options, which makes life decisions really difficult. At the same time, entry level jobs are becoming scarcer and scarcer. Due to current technological developments, the business cycle and political interventionism, soon there will be hardly any jobs for young people who have had no chance to prove their creativity and productivity — a vicious circle, because how to prove yourself without ever landing a sustainable job? Teachers, journalists, politicians have been misleading you for quite a while, but they do not know better. We understand your anger and fear. Better shape up and try to prepare for an uncertain future where many economic premises will turn out to be illusions.</p>
			<p>We invite you to spend two intense weeks in Vienna that might change your life. We offer a unique personal development program to help you prepare for an uncertain future, but not through brainwashing, psychobabble or motivational lectures, ebooks, guides and videos that promise you some kind of bogus certainty. Based on old knowledge and new insights, you will develop an interdisciplinary and entrepreneurial mindset and a clearer picture of future developments and your place within the world. Cut the crap, get real!</p>
			
			<h2>We will focus on the following skills during our program:</h2>
			<ul>
				<li>Geopolitical, economic, social and entrepreneurial dynamics and scenarios – developing analytical competence without political correctness, but also without ideological bias or cynicism.</li>
				<li>Development and examination of realistic business ideas</li>
				<li>Critical overview of relevant educational, entrepreneurial and career opportunities</li>
				<li>International arbitrage and relocation</li>
				<li>Investing and crisis resilience</li>
				<li>Practical philosophy in the original tradition of Austrian economics, politics and ethics</li>
				<li>cultural program (optional)</li>
				<li>mountain tours (optional)</li>
			</ul>
			<p>Most start-ups and entrepreneurial education programs are rather shallow. You mainly learn how to sell promises of endless riches to greedy investors, promises of faked coolness to indebted consumers and promises of heroic images to funding bureaucrats. Then, dreaming of sudden riches, you exploit yourself for another web app, another drink, another gadget. Only that 80% of start-ups fail, and we are still in the midst of a bubble economy. More will fail when the bubble bursts.</p>
			<p>Many alternative educational programs, on the other hand, are too much rooted in the past or too aloof in ivory towers to really understand what is going on in the world today and where it will lead. We are following the markets and geopolitics, and are sober, down-to-earth entrepreneurs at the forefront of innovation. You will get no fancy paper. Instead, you will get inspired, challenged, and prepared for the real world.</p>
			
			<h2>What is it like in Austria?</h2>
			<p>Vienna is ranked as the place with the highest quality of life worldwide and boasts unparalleled access to culture and nature and rich heritage as a center of science and entrepreneurship. Austria is famous for its magnificent, largely intact, rough nature. This is a boundless resource for knowledge and self-reliance. It is a historic center of alpinism, of seeking challenges, sharpening the senses and strengthening the body in the world's most beautiful and breathtaking training circuit toughened by elements and terrain. In Austria, ancient traditions of agriculture, horticulture, medicine and craft have survived the ages which contain amazing amounts of lost knowledge.</p>
			
			<h2>How much does it cost?</h2>
			<p>Only 990€, excluding accommodation. We will help you find a place to stay according to your budget.</p>
			
			<h2>The next <em>Reality Check</em> will take place in February 2018 (5th–18th).</h2>
			
			<p>We love exploring the unknown, we love entrepreneurship, we love learning new ideas, new skills and new ways, and we love our liberty and individuality. We distrust experts, politicians, bankers, managers, journalists, teachers, venture capitalists, just as much as we distrust gurus, doomsayers, ideologues, do-gooders, hipsters, internet celebrities and trolls. Joining our program is definitely not for the weak of heart. Illusions might get shattered. If you have what it takes, book your place now – only limited places available.</p>
			
			<div class="centered">
			<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="coaching_en_registrationform">
				
				<!-- fake input field against bots -->
				<div class='req'>
					<label for='website'>Please leave this field blank</label>
					<input type='text' name='website' autocomplete="off">
				</div>
				<!-- above div is hidden by jquery -->
				
				<input type="hidden" name="ok" value="1">
				
        		<input class="inputfield en_wider_inputfield" id="email" type="email" name="email" placeholder="E-Mail" required>
        		
        		<input type="submit" class="inputbutton" name="coaching_en_registrationform_submit" value=" Request More Information ">
			</form>
		
			<p>We are happy to answer any questions via e-mail:&nbsp;<a href="mailto:&#105;nf&#111;&#064;&#115;&#99;ho&#108;&#97;ri&#117;&#109;.&#97;&#116;">&#105;nf&#111;&#064;&#115;&#99;ho&#108;&#97;ri&#117;&#109;.&#97;&#116;</a></p>
			</div>
		</div>		
	</div>
</div>

<!-- Footer -->

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
        		</div>
        	</div>
        	<div class="footer_section">
        		<div class="footer_tm">
        			<p>&copy; scholarium&trade;</p>
        		</div>
        		<div class="footer_social">
        			<ul>
        				<li><a class="footer_social_facebook" href="https://www.facebook.com/wertewirtschaft" target="_blank" title="Besuchen Sie uns auf Facebook"></a></li>
        				<li><a class="footer_social_twitter" href="https://www.twitter.com/scholarium_at" target="_blank" title="Folgen Sie uns auf Twitter"></a></li>
        				<li><a class="footer_social_youtube" href="https://www.youtube.com/user/Wertewirtschaft" target="_blank" title="Schauen Sie unsere Videos auf YouTube"></a></li>
        			</ul>
        		</div>
        	</div>
        </footer>
    </body>
</html>
