<?php 
require_once('../classes/Login.php');
include('_header_in.php'); 
$title="Bibliothek";

?>

<div class="content"></div>
		<div class="medien_info">
			<h1>Bibliothek</h1>
		
			<p>Die Wertewirtschaft verf&uuml;gt &uuml;ber die wohl bedeutendste Bibliothek zu den Themenbereichen realistischer &Ouml;konomik, Unternehmertum, Freiheit und praktischer Philosophie &ndash; dank zahlreicher Stiftungen, insbesondere derjenigen des Privatgelehrten Roland Baader (Kirrlach), des Saloniers und Freidenkers Rainer Ernst Sch&uuml;tz (Wien), des &Ouml;konomen Hans-Hermann Hoppe (Istanbul) und des Wirtschaftsphilosophen Rahim Taghizadegan (Wien). Diese Bibliothek ist f&uuml;r unsere G&auml;ste zug&auml;nglich und nutzbar. Wir sind noch immer mit der gro&szlig;en Arbeit der vollst&auml;ndigen Erfassung und des digitalen Zugangs besch&auml;ftigt.</p>

<?php
if ($_SESSION['Mitgliedschaft'] == 1) {
	
	echo '<p>Wir freuen uns, dass Sie unsere Bibliothek nutzen m&ouml;chten. Allerdings steht diese nur unseren G&auml;sten zur Verf&uuml;gung, die einen kleinen Kostenbeitrag (6,25&euro;) f&uuml;r das Bestehen der Wertewirtschaft leisten (und daf&uuml;r B&uuml;cher auch kostenlos entleihen k&ouml;nnen). K&ouml;nnen Sie sich das leisten? Dann folgen Sie <a href="http://test.wertewirtschaft.net/abo/">diesem Link</a>. Noch ist die Bibliothek nur vor Ort nutzbar, bzw. sind Anfragen zur Fernleihe per E-Mail m&ouml;glich; wir arbeiten daran, <a href="http://test.wertewirtschaft.net/abo/">G&auml;sten</a> bald einen digitalen Zugriff zu erlauben.</p>';

}
?>
	</div>
</div>
<?php include('_footer.php'); ?>