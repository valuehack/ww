<!DOCTYPE html>
<html lang="de">
	<head>  
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
?>

    $ok2 = $_POST['ok2'];
?>	
	
	<body>
        <header class="header">
            <div class="logo">
                <a href="/"><img class="logo_img" src="../style/gfx/ww_logo_w.png" alt="Institut f&uuml; Wertewirtschaft" name="Home"></a>
                 <div class="login">
                	<div class="anmelden"><button class="login_button" type="button" data-toggle="modal" data-target="#login" value="Anmelden">Anmelden</button></div>
                	
<!-- Login Modal -->
  <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog-login">
      <div class="modal-content-login">
      	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-header">

          <h2 class="modal-title" id="myModalLabel">Anmelden</h2>
        </div>
        <div class="modal-body">
          <p>
          	<form method="post" action="index.php" name="registerform">
          		<input class="inputfield_login" type="email" placeholder=" E-Mail Adresse" name="user_email" required><br>
          		<input class="inputfield_login" type="password" name="user_password" placeholder=" Passwort" required><br>
          		<input class="inputbutton_login" type="submit" value="Anmelden">
          	</form>     
          	<p class="password_login"><a href="/password_reset.php">Passwort vergessen?</a></p>  	
          </p>
        </div>
      </div>
    </div>
  </div>
            	</div>
            </div>
            <div class="nav">
                <div class="navi"></div>
           </div>
        </header>