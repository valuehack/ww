<!DOCTYPE html>
<html lang="de">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title><?=$title?> | Scholarium</title>
<?php
		if ($type == 'blog'){
			?>
    	<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@scholarium_at">
		<meta name="author" content="scholarium">
		<meta property="og:type" content="article">
		<meta property="og:title" content="<?=$title?>">
		<meta property="og:url" content="http://www.scholarium.at/">
		<meta property="og:image" content="http://scholarium.at/style/gfx/cover.jpg">
		<meta property="og:description" content="<?=$description_fb?>">
		<meta property="og:site_name" content="Scholarium">
		<meta property="og:locale" content="de_DE">
		<meta property="article:publisher" content="https://www.facebook.com/wertewirtschaft">
		<?
		}
?>
    	<link rel="shortcut icon" href="/favicon.ico">
    	<link rel="stylesheet" type="text/css" href="../style/style.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="../js/general.js"></script>

		<!-- Bootstrap -->
		<!--<link href="../style/modal.css" rel="stylesheet">-->
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="../tools/bootstrap.js"></script>

		<!-- PHP FreeChat -->
		<link rel="stylesheet" type="text/css" href="../phpfreechat/client/themes/scholarium/jquery.phpfreechat.css">
  		<script src="../phpfreechat/client/jquery.phpfreechat.js" type="text/javascript"></script>

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
	</head>

<?php
//set timezone
mysql_query("SET time_zone = 'Europe/Vienna'");

$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];

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

        if ($itemsPriceArray[type] == 'projekt') {
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
    switch ($entry[Mitgliedschaft]) {
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
            $Mitgliedschaft = 'Ehrenpr&auml;sident';
            break;
        }
	$mitgliedschaft = $entry[Mitgliedschaft];
	
	$test = $entry[test];
	
	$expired = strtotime($entry['Ablauf']);
?>

<body>
<!-- Layout-->
        <header class="header">

            <div class="login">   
                <?php
			  if ($expired < time()) {
      			?>
        		<p class="error">Ihre Mitgliedschaft ist abgelaufen. Um unsere Angebote wieder komplett nutzen zu k&ouml;nnen, <a href="../abo/">erneuern Sie bitte Ihre Mitgliedschaft.</a></p>
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

                <div class="dropdown"><button class="login_button" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="<? echo $entry[user_email];?>"><? echo $entry[user_email];?><span class="caret"></span></button>
                		<ul class="dropdown-menu dropdown_menu dropdown-menu-right dropdown_menu" role="menu" aria-labelledby="dLabel">
                			<li class="dropdown-header dropdown_name"><? echo $entry[Vorname]." ".$entry[Nachname];?></li>
                            <li class="dropdown-header dropdown_level"><? echo $Mitgliedschaft;?></li>
                			<li><a href="/abo/profil.php">Profil</a></li>
                			<li><a href="/abo/">Unterst&uuml;tzen</a></li>
                			<? 
                			if ($mitgliedschaft >= 2){
                			?>
                			<li class="divider"></li>
                      <li class="dropdown-header dropdown_credits">Guthaben: <?echo $entry[credits_left];?> <img class='dropdown_coin' src="../style/gfx/coin.png"></li>
                			<li><a href="/abo/korb.php">Warenkorb <span class="badge"><?echo $total_quantity;?></span></a></li> 
                			<li><a href="/abo/bestellungen.php">Bestellungen</a></li>
                			<li class="divider"></li>
                			<?
                			}
                			?>
                			<li><a href="/logout.php?logout">Abmelden</a></li>        			               		
                		</ul>
                	</div>
                			<? 
                			if ($mitgliedschaft >= 2){
                			?>
                	<div class="login_basket"><a href="../abo/korb.php">Warenkorb <span class="badge"><?echo $total_quantity;?></span></a></div>
<?
							}
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
                    <li id="navelm"><a class="navelm" href="/scholien/">Scholien</a></li>
                    <li id="navelm"><a class="navelm" id="drop1" data-toggle="dropdown" href="#" data-target="#" role="button" aria-haspopup="true" aria-expanded="false">Veranstaltungen</a>
                    	<div class="subnav dropdown-menu" aria-labelledby="drop1">
                    	<ul>
                    		<li class="subnav_head"><a class="subnav_head" href="#">Veranstaltungen</a></li>
                    		<li><a href="/veranstaltungen/">Alle</a></li>
                    		<li><a href="/salon/">Salons</a></li>
                    		<li><a href="/seminare/">Seminare</a></li>
                    	</ul>
                    	</div>
                    </li>
                    <li id="navelm"><a class="navelm" id="drop2" data-toggle="dropdown" href="#" data-target="#" role="button" aria-haspopup="true" aria-expanded="false">Schriften</a>
                    	<div class="subnav dropdown-menu" aria-labelledby="drop2">
                    	<ul>
                    		<li class="subnav_head"><a class="subnav_head" href="#">Schriften</a></li>
                    		<li><a href="/schriften/">Alle</a></li>
                    		<li><a href="/schriften/index.php?type=scholien">Scholien</a></li>
                    		<li><a href="/schriften/index.php?type=analysen">Analysen</a></li>
                    		<li><a href="/schriften/index.php?type=buecher">B&uuml;cher</a></li>
                    		<li><a href="/schriften/antiquariat.php">Antiquariat</a></li>
                    	</ul>
                    	</div>
                    </li>
                    
                    <li id="navelm"><a class="navelm" id="drop3" data-toggle="dropdown" href="#" data-target="#" role="button" aria-haspopup="true" aria-expanded="false">Medien</a>
                    	<div class="subnav dropdown-menu" aria-labelledby="drop3">
                    	<ul>
                    		<li class="subnav_head"><a class="subnav_head" href="#">Medien</a></li>
                    		<li><a href="/medien/">Alle</a></li>
                    		<li><a href="/medien/index.php?type=media-salon">Salon</a></li>
                    		<li><a href="/medien/index.php?type=media-vorlesung">Vorlesung</a></li>
                    		<li><a href="/medien/index.php?type=media-vortrag">Vortrag</a></li>
                    	</ul>
                    	</div>
                    </li>
                    <li id="navelm"><a class="navelm" href="/programme/">Programme</a></li>
                    <li id="navelm"><a class="navelm" href="/projekte/">Projekte</a></li>
                </ul>
                </div>
           </div>
        </header>