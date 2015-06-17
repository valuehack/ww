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

<html>
    <head>
        <title>Scholarium</title>
        <link rel="stylesheet" type="text/css" href="style/landing.css">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

        <!-- Bootstrap -->
        <script src="tools/bootstrap.js"></script>
        
    </head>
    <body>
       <header class="landing_header">
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
                <input class="inputbutton_login" id="inputbutton" name="fancy_ajax_form_submit" type="submit" value="Anmelden">
            </form>     
            <p class="password_login"><a href="/password_reset.php">Passwort vergessen?</a></p>     
          </p>
        </div>
      </div>
    </div>
  </div>
        </header>
             
        <div class="landing_logo_s">
        </div>
        
        <div class="landing_info">
            <p>SCHOLARIUM bedeutet Gemeinschaft der Lernenden und ist das, was die Universit&auml;t h&auml;tte sein k&ouml;nnen, aber nicht sein durfte. Im Gegensatz zum subventionierten Elfenbeinturm der Universitas magistrorum (Gemeinschaft der Intellektuellen) sind wir ein lernendes Unternehmen, in dem bessere Wege werte- und sinnorientierten Schaffens praktisch erkundet und theoretisch reflektiert werden. Wir bieten derzeit eine Orientierungshilfe f&uuml;r kritische B&uuml;rger und eine Bildungsalternative f&uuml;r junge Menschen, die der heutigen Blasenwirtschaft, aber auch ideologischen Versprechen misstrauen. Die Orientierungshilfe ist ein Programm verst&auml;ndlicher und inspirierender Schriften, Medien und Kurse unter der Devise &quot;Wertewirtschaft&quot;, das sich an kritische, unternehmerisch denkende B&uuml;rger richtet, die unabh&auml;ngige Erkenntnis suchen. Die Bildungsalternative bietet unter der Devise &quot;craftprobe&quot; jungen Menschen zwischen 18 und 28 Jahren eine praxisorientierte Hilfestellung f&uuml;r Bildungs- und Berufsentscheidungen. SCHOLARIUM ist ein professionell und wirtschaftlich gef&uuml;hrtes, dem nachhaltigen Unternehmertum verpflichtetes, rein privat finanziertes, und dennoch gemeinn&uuml;tziges Unternehmen: Alle Ertr&auml;ge und Zuwendungen flie&szlig;en direkt, ohne Abzug von Steuern, Dividenden und Zinsen, in den Unternehmenszweck, eigenverantwortlichen, insbesondere jungen Menschen Wege sinnorientierter Wertsch&ouml;pfung zu erschlie&szlig;en, sie dazu zu bef&auml;higen und zu inspirieren und dabei zu unterst&uuml;tzen.</p>
        </div>
        
        <div class="landing_links">
            <div class="landing_links_box">
            <div class="link_1"><p><a class="button_1" href="eltern.php"><span>f&uuml;r</span>Eltern</a></p></div>
            <div class="link_2"><p><a class="button_2" href="buerger.php">B&uuml;rger</a></p></div>
            <div class="link_3"><p><a class="button_3" href="http://www.craftprobe.com"><span>f&uuml;r</span>Studenten</a></p></div>
            </div>
        </div>
    </body>
</html>