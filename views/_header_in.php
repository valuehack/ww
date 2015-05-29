<!DOCTYPE html>
<html lang="de">
	<head>  
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?=$title?> | Institut f&uuml;r Wertewirtschaft</title>
    
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

<body>
<!-- Layout-->
        <header class="header">
            <div class="logo">
                <a href="/"><img class="logo_img" src="../style/gfx/ww_logo_w.png" alt="Institut f&uuml; Wertewirtschaft" name="Home"></a>
                <div class="login"><div class="dropdown"><button class="dropdown_button" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="Ulrich M&ouml;ller">Ulrich Moeller<span class="caret"></span></button>
                	<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                		<li class="dropdown-header">um@wertewirtschaft.org</li>
                		<li><a href="">Profil</a></li>
                		<li><a href="">Upgrade</a></li>
                		<li class="divider"></li>
                		<li>Credit: 150</li>
                		<li><a href="">Warenkorb</a></li>         			               		
                	</ul>
                </div></div>
            </div>
            <div class="nav">
                <div class="navi">
                <ul class="navi">
                    <li><a href="/scholien/">Scholien</a></li>
                    <li><a href="/salon/">Salon</a></li>
                    <li><a href="/kurse/">Kurse</a></li>
                    <li><a href="/schriften/">Schriften</a></li>
                    <li><a href="/medien/">Medien</a></li>
                    <!--<li><a href="/bibliothek/">Bibliothek</a></li>-->
                    <li><a href="/projekte/">Projekte</a></li>
                </ul>
                </div>
           </div>
        </header>

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
?>
   