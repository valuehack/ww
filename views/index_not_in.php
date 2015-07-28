<!DOCTYPE html>
<?php
    include ("_db.php");
?>
<html lang="de">
    <head>  
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>Willkommen | Scholarium</title>
    
        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="stylesheet" type="text/css" href="../style/style.css">
        <link rel="stylesheet" type="text/css" href="../style/landing.css">

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

    $ok2 = $_POST['ok2'];
?>  
    <body>
       <header class="landing_header">
       				<div class="landing_anmelden"><a href=""><img src="../style/gfx/flagge_us.png"></a> <a href=""><img src="../style/gfx/flagge_at.png"></a></div>
       	            <div class="anmelden"><button class="landing_login_button" type="button" data-toggle="modal" data-target="#signup" value="Anmelden">Eintragen</button></div>
                    <div class="anmelden"><button class="landing_login_button" type="button" data-toggle="modal" data-target="#login" value="Anmelden">Anmelden</button></div>

                    
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
                <input class="inputfield_login" id="keyword" type="email" placeholder=" E-Mail Adresse" name="user_email" required><br>
                <input class="inputfield_login" id="user_password" type="password" name="user_password" placeholder=" Passwort" required><br>
                <input class="inputbutton_login" id="inputbutton" name="anmelden_submit" type="submit" value="Anmelden">
            </form>     
            <p class="password_login"><a href="/password_reset.php">Passwort vergessen?</a></p>
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

          <h2 class="modal-title" id="myModalLabel">Eintragen</h2>
        </div>
        <div class="modal-body">
          <p>
            <form method="post" action="index.php" name="registerform">
                <input class="inputfield_login" id="keyword" type="email" placeholder=" E-Mail Adresse" name="user_email" required><br>
                <input class="inputfield_login" id="user_password" type="password" name="user_password" placeholder=" Passwort" required><br>
                <input class="inputbutton_login" id="inputbutton" name="eintragen_submit" type="submit" value="Eintragen">
            </form>         
          </p>
        </div>
      </div>
    </div>
  </div>
        </header>
             
        <div class="landing_logo">
        </div>
        
        <div class="landing_info">
        	<?php
				$sql = "SELECT * from static_content WHERE (page LIKE 'landing')";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				$entry = mysql_fetch_array($result);
				
				echo $entry[info];			
			?>
        </div>
        
        <div class="landing_links_box">
            <div class="link"><p><a class="button_1" href="eltern.php"><span>f&uuml;r</span>Eltern</a></p></div>
            <div class="link"><p><a class="button_2" href="buerger.php">B&uuml;rger</a></p></div>
            <div class="link"><p><a class="button_3" href="http://www.craftprobe.com"><span>f&uuml;r</span>Studenten</a></p></div>
        </div>
    </body>
</html>