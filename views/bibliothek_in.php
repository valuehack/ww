<?php 
//Author: Bernhard Hegyi

require_once('../classes/Login.php');
include('_header.php'); 
$title="Bibliothek";

?>

<div id="center">  
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a><a class="content" href="<?php echo $_SERVER['PHP_SELF']; ?>"> Bibliothek</a>
<div id="tabs-wrapper-lower"></div>

<h2>Bibliothek</h2>

<p>Die Wertewirtschaft verf&uuml;gt &uuml;ber die wohl bedeutendste Bibliothek zu den Themenbereichen realistischer &Ouml;konomik, Unternehmertum, Freiheit und praktischer Philosophie &ndash; dank zahlreicher Stiftungen, insbesondere derjenigen des Privatgelehrten Roland Baader (Kirrlach), des Saloniers und Freidenkers Rainer Ernst Sch&uuml;tz (Wien), des &Ouml;konomen Hans-Hermann Hoppe (Istanbul) und des Wirtschaftsphilosophen Rahim Taghizadegan (Wien). Diese Bibliothek ist f&uuml;r unsere G&auml;ste zug&auml;nglich und nutzbar. Wir sind noch immer mit der gro&szlig;en Arbeit der vollst&auml;ndigen Erfassung und des digitalen Zugangs besch&auml;ftigt.</p>

 <div id="tabs-wrapper-sidebar"></div>

<?php
if ($_SESSION['Mitgliedschaft'] == 1) {

	echo '<p>Wir freuen uns, dass Sie unsere Bibliothek nutzen m&ouml;chten. Allerdings steht diese nur unseren G&auml;sten zur Verf&uuml;gung, die einen kleinen Kostenbeitrag (6,25&euro;) f&uuml;r das Bestehen der Wertewirtschaft leisten (und daf&uuml;r B&uuml;cher auch kostenlos entleihen k&ouml;nnen). K&ouml;nnen Sie sich das leisten? Dann folgen Sie <a href="http://test.wertewirtschaft.net/abo/">diesem Link</a>. Noch ist die Bibliothek nur vor Ort nutzbar, bzw. sind Anfragen zur Fernleihe per E-Mail m&ouml;glich; wir arbeiten daran, <a href="http://test.wertewirtschaft.net/abo/">G&auml;sten</a> bald einen digitalen Zugriff zu erlauben.</p>';

}
?>


</div>
<?php include('_side_in.php'); ?>
</div>
<?php include('_footer.php'); ?>