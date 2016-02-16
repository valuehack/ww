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
    <meta property="og:image" content="http://scholarium.at/style/gfx/cover.jpg">
    <meta property="og:description" content="<?=$description_fb?>">
    <meta property="og:site_name" content="Scholarium">
    <meta property="og:locale" content="de_DE">
    <meta property="article:publisher" content="https://www.facebook.com/wertewirtschaft">
    <? }
?>

      <link rel="shortcut icon" href="/favicon.ico">
      <link rel="stylesheet" type="text/css" href="../style/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../tools/bootstrap.js"></script>
    <script src="../tools/custom.js"></script>

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
                    <div class="anmelden"><a href="http://craftprobe.com/">English</a></div>
                  <div class="anmelden"><button class="login_button" type="button" data-toggle="modal" data-target="#signup" value="Anmelden">Eintragen</button></div>
                  <div class="anmelden"><button class="login_button" type="button" data-toggle="modal" data-target="#login" value="Anmelden">Anmelden</button></div>

            </div>
            <div class="logo">
                <a href="/"><img class="logo_img" src="../style/gfx/scholarium_logo_w.png" alt="scholarium" name="Home"></a>
                  
<!-- Login Modal -->
  <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-login">
      <div class="modal-content-login">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-header">

          <h2 class="modal-title" id="myModalLabel">Anmelden</h2>
        </div>
        <div class="modal-body">
          <p>
            <form method="post" action="index.php" name="registerform">
              <input class="inputfield_login" id="user_email_login" type="email" placeholder=" E-Mail-Adresse" name="user_email" autocomplete="on" autofocus required><br>
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
    <div class="modal-dialog modal-dialog-login">
      <div class="modal-content-login">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-header">

          <h2 class="modal-title" id="myModalLabel">Eintragen</h2>
        </div>
        <div class="modal-body">
          <p>
            <form method="post" action="index.php" name="registerform">
                <input class="inputfield_login" id="user_email_signup" type="email" placeholder=" E-Mail-Adresse" name="user_email" required><br>
                <input type="hidden" name="first_reg" value="header">
                <input class="inputbutton_login" id="inputbutton" name="eintragen_submit" type="submit" value="Eintragen">
            </form>         
          </p>
        </div>
      </div>
    </div>
  </div>            
          </div>
            <div class="nav">
                <div class="navi">
                  <ul id="nav">
                      <li id="navelm"><a class="navelm" href="<?php BASE_URL ?>/fragen.php">H&auml;ufige Fragen</a></li>
                      <li id="navelm"><a class="navelm" href="<?php BASE_URL ?>/mitwirkende.php">Mitwirkende</a></li>
                      <li id="navelm"><a class="navelm" href="<?php BASE_URL ?>/abo/">F&uuml;r B&uuml;rger</a></li>
                      <li id="navelm"><a class="navelm" href="<?php BASE_URL ?>/studenten.php">F&uuml;r Studenten</a></li>
                      <li id="navelm"><a class="navelm" href="<?php BASE_URL ?>/eltern.php">F&uuml;r Eltern</a></li>
                      <li id="navelm"><a class="navelm" href="mailto:&#105;nf&#111;&#064;&#115;&#99;ho&#108;&#97;ri&#117;&#109;.&#97;&#116;">Kontakt</a></li>
                 </ul>
                </div>
           </div>
        </header>