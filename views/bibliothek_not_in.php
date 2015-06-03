<?php 
//Author: Bernhard Hegyi

require_once('../classes/Login.php');
include('_header_not_in.php'); 
$title="Bibliothek";

?>

<div class="medien_info">
		<h1>Bibliothek</h1>

  		<p>Die Wertewirtschaft verf&uuml;gt &uuml;ber die wohl bedeutendste Bibliothek zu den Themenbereichen realistischer &Ouml;konomik, Unternehmertum, Freiheit und praktischer Philosophie &ndash; dank zahlreicher Stiftungen, insbesondere derjenigen des Privatgelehrten Roland Baader (Kirrlach), des Saloniers und Freidenkers Rainer Ernst Sch&uuml;tz (Wien), des &Ouml;konomen Hans-Hermann Hoppe (Istanbul) und des Wirtschaftsphilosophen Rahim Taghizadegan (Wien). Diese Bibliothek ist f&uuml;r unsere G&auml;ste zug&auml;nglich und nutzbar. Wir sind noch immer mit der gro&szlig;en Arbeit der vollst&auml;ndigen Erfassung und des digitalen Zugangs besch&auml;ftigt.</p>
		<p>Wenn Sie ein Zugang interessiert, hinterlassen Sie uns Ihre E-Mail-Adresse:</p>
	</div>
<!-- <div id="content"> -->
<!-- <a class="content" href="../index.php">Index &raquo;</a><a class="content" href="<?php echo $_SERVER['PHP_SELF']; ?>"> Bibliothek</a> -->
<!-- <div id="tabs-wrapper-lower"></div> -->

<!-- <h2>Bibliothek</h2> -->


 <!-- <div id="tabs-wrapper-sidebar"></div> -->

<!-- <i>Wenn Sie ein Zugang interessiert, hinterlassen Sie uns Ihre E-Mail-Adresse:</i><br><br> -->
  
  <div class="subscribe">
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform">
        <input class="inputfield" id="keyword" type="email" placeholder=" E-Mail Adresse" name="user_email" autocomplete="off" required />
        <input class="inputfield" id="user_password" type="password" name="user_password" placeholder=" Passwort" autocomplete="off" style="display:none"  />
        <input class="inputbutton" id="inputbutton" type="submit" name="fancy_ajax_form_submit" value="Eintragen" />
      </form>	
		</div>
		<br /><br />
		<p class="linie"><img src="../style/gfx/linie.png" alt=""></p>
		<br /><br /><br /><br /><br /><br /><br /><br />

<? include "_footer.php"; ?>