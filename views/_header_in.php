<!DOCTYPE html>
<html lang="de">
	<head>  
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title><?=$title?> | Wertewirtschaft</title>
    
    	<link rel="shortcut icon" href="/favicon.ico">
    	<link rel="stylesheet" type="text/css" href="../style/style.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

		<!-- Bootstrap -->
		<!--<link href="../style/modal.css" rel="stylesheet">-->
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
	</head>

<?php
//set timezone
mysql_query("SET time_zone = 'Europe/Vienna'");

// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            #add some html to make it look nicer
            
          ?><p style="text-align:center;"> <?php echo $error; ?> </p> <?php
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            #echo $message;
            ?><p style="text-align:center;"> <?php echo $message; ?> </p> <?php
        }
    }
}
?>

<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            #echo $error;
            ?><p style="text-align:center;"> <?php echo $error; ?> </p> <?php
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            #echo $message;
            ?><p style="text-align:center;"> <?php echo $message; ?> </p> <?php
        }
    }
}

$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];

//getting the number of items in the basket
if(isset($_POST['add'])){

  $add_quantity = $_POST['quantity'];

  $basket = $_SESSION['basket'];
  foreach ($basket as $code => $quantity) {
        $total_quantity += $quantity;
    }

  $total_quantity = $total_quantity + $add_quantity;
}

elseif(isset($_POST['delete'])) {
    $total_quantity = 0;
}

elseif(isset($_POST['remove'])) {
    $remove_id = $_POST['remove'];

    $remove_quantity = $_SESSION['basket'][$remove_id];

    $basket = $_SESSION['basket'];
    foreach ($basket as $code => $quantity) {
        $total_quantity += $quantity;
    }

  $total_quantity = $total_quantity - $remove_quantity; 
}

elseif(isset($_SESSION['basket'])) {
    $basket = $_SESSION['basket'];
    $total_quantity = 0;

    foreach ($basket as $code => $quantity) {
        $total_quantity += $quantity;
    }
    //$basket_quantity = count($basket);  
}

else {
    $total_quantity = 0;
}

if (!isset($user_id)) echo ""; 
else
{
$query = "SELECT * from mitgliederExt WHERE `user_id` LIKE '%$user_id%' AND `user_email` LIKE '%$user_email%' ";

$result = mysql_query($query) or die("Failed Query of " . $query. mysql_error());

while ($entry = mysql_fetch_array($result))
{
?>

<body>
<!-- Layout-->
        <header class="header">
        	<div class="login">         	
                <div class="dropdown"><button class="login_button" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="<? echo $entry[user_email];?>"><? echo $entry[user_email];?><span class="caret"></span></button>
                		<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dLabel">
                			<li class="dropdown-header"><? echo $entry[Vorname]." ".$entry[Nachname];?></li>
                			<li><a href="/abo/profil.php">Profil</a></li>
                			<li><a href="/abo/upgrade.php">Upgrade</a></li>
                			<li class="divider"></li>
                			<li class="dropdown-header">Credits: <?echo $entry[credits_left];?></li>
                			<li><a href="/abo/korb.php">Warenkorb <span class="badge"><?echo $total_quantity;?></span></a></li> 
                			<li class="divider"></li>
                			<li><a href="/index.php?logout">Abmelden</a></li>        			               		
                		</ul>
                	</div>
                	<div class="login_basket"><a href="../abo/korb.php">Warenkorb <span class="badge"><?echo $total_quantity;?></span></a></div>
<?
		}
	}
?>
            </div>
            <div class="logo">
                <a href="/"><img class="logo_img" src="../style/gfx/scholarium_logo_w.png" alt="Institut f&uuml; Wertewirtschaft" name="Home"></a>
                 

            </div>
            <div class="nav">
                <div class="navi">
                <ul class="navi">
                    <li><a href="/scholien/">Scholien</a></li>
                    <li><a href="/salon/">Salon</a></li>
                    <li><a href="/kurse/">Kurse</a></li>
                    <li><a href="/schriften/">Schriften</a></li>
                    <li><a href="/medien/">Medien</a></li>
                    <li><a href="/bibliothek/">Bibliothek</a></li>
                    <li><a href="/projekte/">Projekte</a></li>
                </ul>
                </div>
           </div>
        </header>