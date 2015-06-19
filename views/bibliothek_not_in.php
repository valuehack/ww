<?php 
require_once('../classes/Login.php');
$title="Bibliothek";
include('_header_not_in.php'); 


?>
<div class="content">
		<div class="medien_info">
			<h1>Bibliothek</h1>

  			<p>Die Wertewirtschaft verf&uuml;gt &uuml;ber die wohl bedeutendste Bibliothek zu den Themenbereichen realistischer &Ouml;konomik, Unternehmertum, Freiheit und praktischer Philosophie &ndash; dank zahlreicher Stiftungen, insbesondere derjenigen des Privatgelehrten Roland Baader (Kirrlach), des Saloniers und Freidenkers Rainer Ernst Sch&uuml;tz (Wien), des &Ouml;konomen Hans-Hermann Hoppe (Istanbul) und des Wirtschaftsphilosophen Rahim Taghizadegan (Wien). Diese Bibliothek ist f&uuml;r unsere G&auml;ste zug&auml;nglich und nutzbar. Wir sind noch immer mit der gro&szlig;en Arbeit der vollst&auml;ndigen Erfassung und des digitalen Zugangs besch&auml;ftigt.</p>
			<p>Wenn Sie ein Zugang interessiert, hinterlassen Sie uns Ihre E-Mail-Adresse:</p>
  
  			<div class="subscribe">
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform">
        			<input class="inputfield" type="email" placeholder=" E-Mail Adresse" name="user_email" autocomplete="off" required>
        			<input class="inputbutton" id="inputbutton" type="submit" name="eintragen_submit" value="Eintragen">
      			</form>	
			</div>
		</div>
</div>

<? include "_footer.php"; ?>