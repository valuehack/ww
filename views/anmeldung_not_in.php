<? session_start();
include "_db.php";
$title="Unterst&uuml;tzen";
include "_header.php";

$anrede = $_POST['anrede'];
$nachname = $_POST['nachname'];
$vorname = $_POST['vorname'];
$firma = $_POST['firma'];
$email = $_POST['email'];
$telefon = $_POST['telefon'];
$strasse = $_POST['strasse'];
$firma = $_POST['firma'];
$land = $_POST['land'];
$plz = $_POST['plz'];
$ort = $_POST['ort'];
$ok = $_POST['ok'];
$zahlung = $_POST['zahlung'];
$abo = $_POST['abo'];
$pdf2009 = $_POST['pdf2009'];
$pdf2010 = $_POST['pdf2010'];
$pdf2011 = $_POST['pdf2011'];
$pdf2012 = $_POST['pdf2012'];
$wwv = $_POST['wwv'];
$wienerschule = $_POST['wienerschule'];
$systemtrottel = $_POST['systemtrottel'];
$endewut = $_POST['endewut'];
$philosophicum = $_POST['philosophicum'];
$praxis = $_POST['praxis'];
$spende = $_POST['spende'];
$gold = $_POST['gold'];
$stipendium = $_POST['stipendium'];
$rothbard_man = $_POST['rothbard_man'];
$doku = $_POST['doku'];
$freie_verwendung = $_POST['freie_verwendung'];
?>

<!--Content-->
<div id="center">
        <div id="content">
	  <a class="content" href="../index.php">Index &raquo;</a> <a class="content" href="index.php">Unterst&uuml;tzen</a>
	  <div id="tabs-wrapper-lower"></div>
          <h3 class="with-tabs">Unterst&uuml;tzen</h3>
<?
if ($ok)
        {

 if($_POST['secure'] != $_SESSION['security_number'])
	{
		echo "Ihr Ergebnis ist falsch. <br /><br />";
		echo "Bitte gehen Sie <a href='javascript:history.go(-1)'>zur&uuml;ck</a> und versuchen Sie es erneut.";
         	echo '<div id="tabs-wrapper-lower"></div>';
        	echo "</div>";
         	include "_side_not_in.php";
        	echo "</div>";
		include "_footer.php";
		exit;
	}

  //Email an Institut
  $subject= "Neues Mitglied";
  $body = "$vorname $nachname\n\n";

  $betrag=$abo;
  $s=1;
  if ($abo==90){$mitgliedschaft=4; $body=$body."Standardmitgliedschaft";}
  if ($abo==150){$mitgliedschaft=5; $body=$body."F&ouml;rdermitgliedschaft (150 Euro)";}
  if ($abo==300){$mitgliedschaft=6; $body=$body."F&ouml;rdermitgliedschaft (300 Euro)";}
  //if ($abo==50){$mitgliedschaft=1; $s=0; $body=$body."Sozialmitgliedschaft";}

  $body=$body." $abo EUR";
	if ($analysen) {$betrag=$betrag+25; $body=$body."\n+ Analysenpaket ";}
	if ($pdf2009) {$betrag=$betrag+60; $body=$body."\n JG 2009-PDF ";}
	if ($pdf2010) {$betrag=$betrag+60; $body=$body."\n+ JG 2010-PDF ";}
	if ($pdf2011) {$betrag=$betrag+60; $body=$body."\n+ JG 2011-PDF ";}
	if ($wwv) {$betrag=$betrag+25; $body=$body."\n+ Wirtschaft wirklich verstehen";}
	if ($wienerschule) {$betrag=$betrag+24; $body=$body."\n+ Die Wiener Schule der National&ouml;konomie";}
    if ($systemtrottel) {$betrag=$betrag+20; $body=$body."\n+ Vom Systemtrottel zum Wutb&uuml;rger";}
	if ($endewut) {$betrag=$betrag+15; $body=$body."\n+ Das Ende der Wut";}
	if ($philosophicum){$betrag=$betrag+($philosophicum*10); $body=$body."\n+ $philosophicum Gutschein(e) Philosophicum";}
    if ($praxis){$betrag=$betrag+($praxis*100); $body=$body."\n+ $praxis Gutschein(e) Philosophische Praxis";}
	if ($spende){$betrag=$betrag+$spende; $body=$body."\n+ Spende in H&ouml;he von $spende Euro";}

	if ($gold) {$mitgliedschaft=7;$body.$body."\n\nM&auml;zen\n\n";
	  if ($gold==1){$body=$body."\n+ 1 Unze Gold";}
	  if ($gold==2){$body=$body."\n+ 2 Unzen Gold";}
	  if ($gold==5){$body=$body."\n+ 5 Unzen Gold";}
	  if ($gold==10){$body=$body."\n+ 10 Unzen Gold";}

	  if ($stipendium){$body=$body."\nStipendienfonds";}
	  if ($rothbard_man){$body=$body."\n&Uuml;bersetzungsprojekt - Rothbard, Man, Economy and State";}
	  if ($doku){$body=$body."\nFilmrojekt";}
	  if ($freie_verwendung){$body=$body."\nFreie Verwendung";}
	}

  if ($land=="A"||$land=="AT") {$l="Oesterreich";}
  elseif ($land=="D"||$land=="DE") {$l="Deutschland";}
  elseif ($land=="CH") {$l="Schweiz";}
  elseif ($land=="FL") {$l="Liechtenstein";}
  else {$l=$land;}

  $body=$body."\n\n$vorname $nachname\n$strasse\n$land-$plz $ort\n$email\n$telefon\n\nGesamt: $betrag EUR";

  mail ("iwwanmeldungen@gmail.com",$subject,$body,"From: $email\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");
  mail ("moeller.ulrich@gmx.de",$subject,$body,"From: $email\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");

#####################################################
#Adds a new registered member to members' newsletter in Cleverreach  
#Added by Dainius on 7thMay2014 

	$apiKey = "e6042d06135634899a3b2e43369abfd0-1";
	$wsdl_url="http://api.cleverreach.com/soap/interface_v5.1.php?wsdl";
	$listId = "29872";
	
	$api = new SoapClient($wsdl_url);

   $vornamehtml = htmlentities($vorname);
	$nachnamehtml = htmlentities($nachname);
	
	$user = array
	     (
	     "email" => $email,
	     #"registered" => time(),
	     #"activated" => time(),
	     "source" => "Mitgliedschaft",
	     "attributes" => array
	         (
	         0 => array("key" => "firstname", "value" => $vornamehtml),
	         1 => array("key" => "lastname", "value" => $nachnamehtml),
	         )
	     );
	 
	$result = $api->receiverAdd($apiKey, $listId, $user);
	
	/*  
	#Error check 
	if($result->status=="SUCCESS"){	        //successfull list call
		var_dump($result->data);
	}else{					//lists call failed
		var_dump($result->message);	//display error as TEXT
	}
	*/

#####################################################



/*    $sql2 = "SELECT id from Mitglieder WHERE `Email` LIKE '%$email%'";
    $result2 = mysql_query($sql2);
	  $entry2 = mysql_fetch_array($result2);
    $id=$entry2[id];
    if ($id)
    	{
	    $sql = "UPDATE Mitglieder SET Vorname='".addslashes($vorname)."',Nachname='".addslashes($nachname)."',Strasse='".addslashes($strasse)."',Firma='".addslashes($firma)."',Land='$l',Ort='$ort',PLZ='$plz',Telefon='$telefon',Mitgliedschaft='$mitgliedschaft',Scholien='$s', Firma='$firma' WHERE `Email` = '$email'";
	    $result = mysql_query($sql) or die("Failed Query of " . $sql. mysql_error());
      }
    else
    	{
    	*/
      $sql = "INSERT INTO Mitglieder ( `id`, `Nachname`, `Vorname`, `Email`, `Telefon`, `Firma`, `Strasse`, `PLZ`, `Ort`, `Land`, `Anrede`, `Titel`, `Anredename`, `Du`, `Mitgliedschaft`, `Ablauf`, `Zahlung`, `Eintritt`, `Notiz`, `Gesamt`, `Scholien`, `Mahnstufe`, `auslaufend` ) VALUES ( '', '".addslashes($nachname)."', '".addslashes($vorname)."', '$email', '$telefon', '".addslashes($firma)."','".addslashes($strasse)."', '$plz', '$ort', '$l', '$anrede', '$titel', '', '0', '$mitgliedschaft', '','', '".date("Y-m-d H:j:s")."', '', '', '$s', '','')";
  		$result = mysql_query($sql) or die("Failed Query of " . $sql. mysql_error());
      $result3 = mysql_query("SELECT id from Mitglieder WHERE `Email` LIKE '%$email%'");
      $entry3 = mysql_fetch_array($result3);
      $id=$entry3[id];
    /*  } */


    #Email an Mitglied
    $body = "Sehr geehrte";
    if ($anrede=="Herr") $body = $body."r";
    $body = $body." ".$anrede." ";
    $body = $body.$nachname."!\n\n";
    $body = $body."Herzlichen Dank f&uuml;r Ihre Mitgliedschaft! Bitte beachten Sie, dass Ihre Mitgliedschaft f&uuml;r ein Jahr gilt und sich um ein weiteres Jahr verl&auml;ngert wenn Sie nicht zwei Wochen vor Ablauf k&uuml;ndigen. Eine K&uuml;digung ist jederzeit m&ouml;glich E-Mail oder Fax gen&uuml;gt.";

	if ($abo)  {
	   $body = $body."\n\nSie haben \n";
	   if ($abo==90){$body=$body."\n - die Standardmitgliedschaft (90 Euro)";}
       if ($abo==150){$body=$body."\n - F&ouml;rdermitgliedschaft (150 Euro)";}
       if ($abo==300){$body=$body."\n - F&ouml;rdermitgliedschaft (300 Euro)";}
	   $body = $body."\n\nbestellt.";


	   $body = $body."\n\nBitte &Uuml;berweisen Sie den anfallenden Betrag von $betrag EUR auf folgendes Konto:
	                  \nInstitut f&uuml;r Wertewirtschaft\nErste Bank, Wien\nKontonummer: 28824799900\nBankleitzahl: 20111\nIBAN: AT332011128824799900\nBIC: GIBAATWW
	                  \n\nBitte verwenden Sie als Zahlungsreferenz/Betreff unbedingt &quot;Mitglied Nr. $id&quot;";}

	   if ($spende) {$body=$body."\n\nVielen Dank f&uuml;r Ihre gro&szlig;&uuml;gige Spende in H&uoml;he von $spende Euro.";}
	   if ($analysen) {$body=$body."\n\nWir senden Ihnen in K&uuml;rze ein Gesamtpaket unserer bisher im Druck erschienenen Analysen zu.";}
	   if ($scholien) {$body=$body."\n\nHaben Sie bitte etwas Geduld, wir senden Ihnen die n&auml;chste Ausgabe der Scholien nach Erscheinen unverz&uuml;glich zu. Das Scholienabo l&auml;uft ebenfalls f&uuml;r ein Jahr und verl&auml;ngernt sich automatisch um ein weiteres Jahr wenn Sie nicht zwei Wochen vor Ablauf k&uuml;ndigen.";}

	   if ($gold and $freie_verwendung!=1) {$body=$body."\n\nWillkommen im ausgew&auml;hlten Kreis unserer M&auml;zene! Wir freuen, dass Sie uns bei der Verwirklichung eines konkretes Projektes unterst&uuml;tzen m&ouml;chten!\n\nSie haben sich daf&uuml;r entschieden unseren Stipendienfonds, unser &Uuml;bersetzungsprojekt und/oder unser Filmprojekt mit $gold Unze(n) Gold zu unterst&uuml;tzen. Vielen Dank!";}
	   if ($gold and $freie_verwendung) {$body=$body."\n\nWillkommen im ausgew&auml;hlten Kreis unserer M&auml;zene! Wir freuen, dass Sie sich entschieden haben uns so gro&szlig;z&uuml;gig mit $gold Unze(n) Gold zu unterst&uuml;tzen. Vielen Dank!";}

			$body = $body."\n\nHier sind Ihre Zugangsdaten f&uuml;r den Mitgliederbereich: Benutzername wertewirtschaft, Passwort praktischephilosophie.";

	       $body = $body."\n\nMit freundlichen Gr&uuml;&szlig;en,\n\nInstitut f&uuml;r Wertewirtschaft\n\ninfo@wertewirtschaft.org\nhttp://wertewirtschaft.org";
	$body = html_entity_decode(ereg_replace('<br>',"\n",$body));
  	$subject= "Vielen Dank fuer Ihre Mitgliedschaft!";
  	mail ($email,$subject,$body,"From: info@wertewirtschaft.org\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");

?>
          <p><b>Vielen Dank f&uuml;r Ihre Mitgliedschaft!</b></p>

          <p><b>Laufzeit und K&uuml;ndigung:</b></p>

          <p>Die Mitgliedschaft l&auml;uft ein Jahr und verl&auml;ngernt sich automatisch um ein weiteres Jahr wenn Sie nicht zwei Wochen vor Ablauf k&uuml;ndigen. Eine K&uuml;ndigung ist jederzeit m&ouml;glich, E-Mail oder Fax gen&uuml;gt.</p>

          <? if ($abo || $analysen || $pdf2009 || $pdf2011|| $wwv || $wienerschule || $systemtrottel || $endewut || $philosophicum || $praxis)  {
          echo "<p>Sie haben
             <ul>";

               if ($abo==90){echo "<li>Standardmitgliedschaft</li>";}
               if ($abo==150){echo "<li>F&ouml;rdermitgliedschaft (150 &euro;)</li>";}
               if ($abo==300){echo "<li>F&ouml;rdermitgliedschaft (300 &euro;)</li>";}
               //if ($abo==50){echo "<li>reduzierte Mitgliedschaft</li>";}
	           if ($analysen) {echo "<li>die gesammelten Analysen</li>";}
	           if ($pdf2009) {echo "<li>den Jahrgang 2009 der Scholien als PDF";}
	           if ($pdf2010) {echo "<li>den Jahrgang 2010 der Scholien als PDF";}
	           if ($pdf2011) {echo "<li>den Jahrgang 2011 der Scholien als PDF";}
	           if ($wwv) {echo "<li>Wirtschaft wirklich verstehen</li>";}
	           if ($wienerschule) {echo "<li>Die Wiener Schule der National&ouml;konomie</li>";}
               if ($systemtrottel) {echo "<li>Vom Systemtrottel zum Wutb&uuml;rger</li>";}
	           if ($endewut) {echo "<li>Das Ende der Wut</li>";}
			   if ($philosophicum) {echo "<li>$philosophicum Gutschein(e) f&uuml;r das Philosophicum</li>";}
	           if ($praxis) {echo "<li>$praxis Gutschein(e) f&uuml;r die Philosophische Praxis</li>";}

	         echo "</ul>bestellt."; }
              if ($spende) {echo "<br><br>Vielen Dank f&uuml; Ihre gro&szlig;&uuml;gige Spende!";}
              if ($gold and $freie_verwendung!=1) {echo "<p><b>Willkommen im ausgew&auml;hlten Kreis unserer M&auml;zene!</b> Wir freuen uns, dass Sie uns bei der Verwirklichung eines konkretes Projektes unterst&uuml;tzen m&ouml;chten!\n\nSie haben sich daf&uuml;r entschieden, unseren Stipendienfonds, unser &Uuml;bersetzungsprojekt und/oder unser Filmprojekt mit $gold Unze(n) Gold zu unterst&uuml;tzen. Vielen Dank!</p>";}
	          if ($gold and $freie_verwendung) {echo "<p><b>Willkommen im ausgew&auml;hlten Kreis unserer M&auml;zene!</b> Wir freuen uns, dass Sie sich entschieden haben, unsere Arbeit so gro&szlig;z&uml;gig mit $gold Unze(n) Gold zu unterst&uuml;tzen. Vielen Dank!</p>";}

              ?>


<? if ($zahlung=="bank")
	{
	?>
          <p>Bitte &uuml;berweisen Sie den gew&auml;hlten Betrag von EUR <?=$betrag?> an:</p>
	  <p><i>International</i>
	  <ul>
           <li>Institut f&uuml;r Wertewirtschaft</li>
           <li>Erste Bank, Wien/&Ouml;sterreich</li>
           <li>Kontonummer: 28824799900</li>
           <li>Bankleitzahl: 20111</li>
	       <li>IBAN: AT332011128824799900</li>
	       <li>BIC: GIBAATWW</li>
          </ul></p>

          <p>Alternativ k&ouml;nnen Sie den Gegenwert in Schweizer Franken auf folgendes Konto &uuml;berweisen:</p>

          <p>
          <ul>
           <li>Institut f&uuml;r Wertewirtschaft</li>
           <li>Liechtensteinische Landesbank</li>
           <li>Kontonummer: 23103297</li>
           <li>Bankleitzahl: 08800</li>
           <li>IBAN: LI6308800000023103297</li>
           <li>BIC: LILALI2X</li>
          </ul>
          </p>

          <p><b>Bitte verwenden Sie als Sie als Zahlungsreferenz/Betreff unbedingt &quot;Mitglied Nr. <?=$id?>&quot;</b></p>
<?
	}
if ($zahlung=="kredit")
	{
	?>
          <p>Bitte &uuml;berweisen Sie den gew&auml;hlten Betrag von EUR <?=$betrag?> per Paypal: Einfach auf das Symbol unterhalb klicken, Ihre Kreditkartennummer eingeben, fertig. Unser Partner PayPal garantiert eine schnelle, einfache und sichere Zahlung (an Geb&uuml;hren fallen 2-3% vom Betrag an). Sie m&uuml;ssen kein eigenes Konto bei PayPal einrichten, die Eingabe Ihrer Kreditkartendaten reicht.</p><br>

          <div align="center">
	      <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" name="paypal">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="info@wertewirtschaft.org">
            <input type="hidden" name="item_name" value="Mitglied Nr.<?=$id?>">
            <input type="hidden" name="amount" value="<?=$betrag?>">
            <input type="hidden" name="shipping" value="0">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="no_note" value="1">
            <input type="hidden" name="currency_code" value="EUR">
            <input type="hidden" name="tax" value="0">
            <input type="hidden" name="bn" value="PP-BuyNowBF">
            <input type="image" src="https://www.paypal.com/de_DE/i/btn/x-click-but6.gif" border="0" name="submit" alt="" style="border:none">
            <img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
           </form>
          </div>
<?
	}

elseif ($zahlung=="bar")
      {
      echo "<p>Bitte schicken Sie uns den gew&auml;hlten Betrag von $betrag &euro; in Euro-Scheinen oder im ungef&auml;hren Edelmetallgegenwert (Gold-/Silberm&uuml;nzen) an das Institut f&uuml;r Wertewirtschaft, Schl&ouml;sselgasse 19/2/18, 1080 Wien, &Ouml;sterreich. Alternativ k&ouml;nnen Sie uns den Betrag auch pers&ouml;nlich im Institut (bitte um Voranmeldung) oder bei einer unserer Veranstaltungen &uuml;berbringen.</p>";
      }
    if ($analysen) {echo "<p>Wir senden Ihnen in K&uuml;rze ein Gesamtpaket unserer bisher im Druck erschienenen Analysen zu.</p>";}
   }
else { ?>

          <p>Das Institut f&uuml;r Wertewirtschaft ist eine gemeinn&uuml;tzige Einrichtung, die sich durch einen besonders langfristigen Zugang auszeichnet. Um unsere Unabh&auml;ngigkeit zu bewahren, akzeptieren wir keinerlei Mittel, die aus unfreiwilligen Zahlungen (Steuern, Geb&uuml;hren, Zwangsmitgliedschaften etc.) stammen. Umso mehr sind wir auf freiwillige Investitionen angewiesen. Nur mit Ihrer Unterst&uuml;tzung k&ouml;nnen wir unsere Arbeit aufrecht erhalten oder ausweiten. </p>

          <p><b>Warum in das Institut f&uuml;r Wertewirtschaft investieren?</b>
          <ul>
	       <li>Wo gibt es sonst noch vollkommen unabh&auml;ngige Universalgelehrte, die im Wahnsinn der Gegenwart den &Uuml;berblick bewahren und den Verlockungen von Macht und Geld widerstehen? Einst hatten Universit&auml;ten diese Aufgabe, doch sind diese l&auml;ngst durch die Politik korrumpiert und im Kern zerst&ouml;rt.</li>
           <li>Jeder rationale Anleger sollte ebenso in die Institutionen investieren, die f&uuml;r eine freie und wohlhabende Gesellschaft unverzichtbar sind. Ohne Menschen, die ihr Leben der Erkenntnis widmen, sind den Illusionen, die zu Unfreiheit und Versklavung f&uuml;hren, keine Grenzen gesetzt.</li>
           <li>Das Institut f&uuml;r Wertewirtschaft ist, obwohl wir wenig pragmatisch sind, wohl eines der effizientesten Institute weltweit. Wir leisten mehr als Einrichtungen, die das Hundertfache unseres Budgets aufweisen. Durch gro&szlig;en pers&ouml;nlichen Einsatz , &auml;u&szlig;erst sparsames Management und unternehmerische Einstellung k&ouml;nnen wir auch mit geringen Betr&auml;gen gro&szlig;en Mehrwert schaffen.</li>
           <li>Eine Gesellschaft, in der nahezu die gesamte Bildung und Forschung in staatlicher Hand liegt, befindet sich auf direktem Weg in den Totalitarismus. Sagen Sie nachher nicht, wir h&auml;tten Sie nicht gewarnt.</li>
           <li>Warnung: Wir k&ouml;nnen nat&uuml;rlich auch keine Wunder vollbringen (wiewohl wir uns oft wundern, was uns alles trotz unser knappen Mittel gelingt). Wir sind keinesfalls geneigt, uns in irgendeiner Form f&uuml;r Geldmittel zu verbiegen. Wenn Sie in unsere Arbeit investieren, dann tun Sie das, weil Sie unsere Selbst&auml;ndigkeit und Unkorrumpierbarkeit sch&auml;tzen. Finanzmittel sind nur eine Zutat, und keinesfalls die Wichtigste. Wir bitten Sie darum, weil materielle Unabh&auml;ngigkeit die Voraussetzung unserer Arbeit ist - und diese Unabh&auml;ngigkeit k&ouml;nnen wir nur durch eine Vielfalt an Stiftern erreichen.</li>
          </ul></p>

         <p><b>Ihre Vorteile:</b>
         <ul>
	      <li>Deutliche Erm&auml;&szlig;igungen bei unseren Akademie-Veranstaltungen (schon bei wenigen Besuchen bringt Ihnen die Mitgliedschaft einen finanziellen Vorteil)</li>
          <li>Erm&auml;&szlig;igter Eintritt zu unseren Salon-Veranstaltungen (Video&uuml;bertragung f&uuml;r ausw&auml;rtige Mitglieder)</li>
          <li><a href="http://www.wertewirtschaft.org/scholien/">Abonnement der Scholien</a> inkludiert</li>
          <li>Wachsende Zahl exklusiver Inhalte (Audio/Video)</li>
          <li>Nutzung der Bibliothek, B&uuml;cherleihe</li>
          <li><b>F&ouml;rderer:</b><br> F&ouml;rderer leisten einen regelm&auml;&szlig;igen Beitrag, der &uuml;ber die Kosten hinausgeht, um uns bei unserer Arbeit zu ermutigen und zu unterst&uuml;tzen. Daf&uuml;r sind sie etwas mehr in unser Institut eingebunden und erhalten zus&auml;tzlich zu den Mitgliedschaftsvorteilen:
          	<ul class="sub">
          		<li>Hintergrundinformationen zu unserer Arbeit</li>
          		<li>Einladung zu exklusiven Veranstaltungen</li>
          		<li>Ihre Begleitung erh&auml;lt den Mitgliedertarif bei unseren Veranstaltungen</li>
          		<li>ab 300 &euro; Beitrag: Zusendung signierter Exemplare aller Bucherscheinungen und sonstiger Publikationen</li>
          	</ul>
          </li>
          <li><b>M&auml;zene:</b><br> Ein M&auml;zen hilft uns, ein konkretes Projekt zu realisieren, indem er einen gr&ouml;&szlig;eren Betrag in unsere Arbeit investiert. Ab einer Investition von einer Unze Gold oder ihrem Gegenwert in Euro oder Franken geh&ouml;ren Sie zum erlesenen Kreis unserer M&auml;zene und damit zum engsten Kreis unserer Institutsfreunde. Zus&auml;tzlich zu den Mitgliedschaftsvorteilen erhalten Sie, sofern eine Mitgliedschaft aufrecht ist:
          	<ul class="sub">
          		<li>Exklusive, pers&ouml;nliche Einladungen</li>
          		<li>Platzgarantie f&uuml;r alle Veranstaltungen</li>
          		<li>Einj&auml;hrige Mitgliedschaft geschenkt - falls Sie bereits Mitglied sind, zum Weiterverschenken.</li>
          	</ul>
          </li>
         </ul>
         </p>

   <script type="text/javascript" language="JavaScript">

	  function CheckRequiredFields() {
	  var errormessage = new String();
	  // Put field checks below this point.

	  if(WithoutContent(document.data.nachname.value))
	    { errormessage += "\n\nVorname vergessen"; }
	  if(WithoutContent(document.data.vorname.value))
	    { errormessage += "\n\nNachname vergessen"; }
	  if(WithoutContent(document.data.email.value))
	    { errormessage += "\n\nE-Mail vergessen"; }
          if(WithoutContent(document.data.strasse.value))
	    { errormessage += "\n\nStrasse vergessen"; }
          if(WithoutContent(document.data.ort.value))
	    { errormessage += "\n\nOrt vergessen"; }
          if(WithoutContent(document.data.plz.value))
	    { errormessage += "\n\nPLZ vergessen"; }
          if(WithoutContent(document.data.land.value))
	    { errormessage += "\n\nLand vergessen"; }
	  if(NoneWithCheck(document.data.anrede))
	    { errormessage += "\n\nAnrede vergessen"; }

	  // Put field checks above this point.
	  if(errormessage.length > 2) {
	    alert('ACHTUNG:' + errormessage);
	    return false;
	    }
	  return true;
	  } // end of function CheckRequiredFields()


	  function WithoutContent(ss) {
	  if(ss.length > 0) { return false; }
	  return true;
	  }

	  function NoneWithContent(ss) {
	  for(var i = 0; i < ss.length; i++) {
	    if(ss[i].value.length > 0) { return false; }
	    }
	  return true;
	  }

	  function NoneWithCheck(ss) {
	  for(var i = 0; i < ss.length; i++) {
	    if(ss[i].checked) { return false; }
	    }
	  return true;
	  }

	  function WithoutCheck(ss) {
	  if(ss.checked) { return false; }
	  return true;
	  }

	  function WithoutSelectionValue(ss) {
	  for(var i = 0; i < ss.length; i++) {
	    if(ss[i].selected) {
	      if(ss[i].value.length) { return false; }
	      }
	    }
	  return true;
	  }

/* this is just a simple reload; you can safely remove it; remember to remove it from the image too */
	function reloadCaptcha()
	{
		document.getElementById('captcha').src = document.getElementById('captcha').src+ '?' +new Date();
	}

/*removes charackteres*/
	function CheckZahl(feld)
    {
     if(isNaN(feld.value) == true)
     {
      feld.value=feld.value.slice(0,feld.value.length-1); //Eingegebener Buchstabe wird gelöscht
     }
    }
	  </script>
	  
	  <p><b>Bitcoins spenden:</b> 
	  <a href="bitcoin:1AvB1DL7iz2JfMsxi8jndVAo4vq8jMFvCt?label=iww">1AvB1DL7iz2JfMsxi8jndVAo4vq8jMFvCt</a></p>

 <form name="data" method="POST" onSubmit="return CheckRequiredFields()" action="">
          <input type="hidden" name="ok" value="1">

	  <table class="apply" cellspacing="0">
           <tr>
            <th colspan="2" class="apply">Mitgliedschaftsoptionen</th>
           </tr>
           <tr>
            <td class="apply" valign="top"><b>Standardmitgliedschaft:</b></td>
            <td class="apply" valign="top"><input type="radio" name="abo" value="90"> 90&euro;/Jahr
            </td>
           </tr>
           <tr>
            <td class="apply" valign="top"><b>F&ouml;rdermitgliedschaft:</b></td>
            <td class="apply" valign="top"><input type="radio" name="abo" value="150"> 150&euro;/Jahr &nbsp;&nbsp; <input type="radio" name="abo" value="300"> 300&euro;/Jahr
            </td>
           </tr>
           <tr>
	        <td class="apply" valign="top"><b>Zahlungsart</b></td>
	        <td class="apply" valign="top"><input type="radio" name="zahlung" value="bank">Bank&uuml;berweisung <input type="radio" name="zahlung" value="kredit"> Kreditkarte (Paypal) <input type="radio" name="zahlung" value="bar"> Bar</td>
	       </tr>
	       <tr>
            <th colspan="2" class="apply">Investieren Sie als M&auml;zen in ein konkretes Projekt</th>
           </tr>
           <tr>
	        <td class="apply" valign="top"><b>Betrag:</b></td>
            <td valign="top"><input type="radio" name="gold" value="1">1 Unze <input type="radio" name="gold" value="2">2 Unzen <input type="radio" name="gold" value="5">5 Unzen <input type="radio" name="gold" value="10">10 Unzen Gold</td>
	       </tr>
           <tr>
	        <td class="apply" valign="top"><b>Verwendung:</b></td>
            <td class="apply" valign="top"><table>
            	                           <tr><td width="10%"><input type="Checkbox" name="stipendium" value="1"></td><td>Stipendien f&uuml;r den <a href="http://www.wertewirtschaft.org/baaderkreis/" target="_blank">Baader-Kreis</a></td></tr>
            	                           <tr><td><input type="Checkbox" name="rothbard_man" value="1"></td><td>&Uuml;bersetzungen | &Uuml;bersetzung von Murray Rothbard: Man, Economy, and State</td></tr>
            	                           <tr><td><input type="Checkbox" name="doku" value="1"></td><td>Filmprojekt | Erstellen eines professionellen Dokumentarfilms, um ein breiteres Publikum aufzukl&auml;ren</td></tr>
            	                           <tr><td><input type="Checkbox" name="freie_verwendung" value="1"></td><td>freie Verwendung</td></tr>
            	                          </table>
            </td>
	       </tr>

           <tr>
            <th colspan="2" class="apply">Pers&ouml;nliche Daten</th>
           </tr>
	   <tr>
	    <td colspan="2">&nbsp;&nbsp;<input type="radio" name="anrede" value="Herr" <? if ($anrede=="Herr"||!$anrede) echo "checked=\"checked\""; ?>><b>Herr</b>&nbsp;&nbsp;<input type="radio" name="anrede" value="Frau" <? if ($anrede=="Frau") echo "checked=\"checked\""; ?>><b>Frau</b></td>
	   </tr>
           <tr>
	    <td style="width:175px"><img src="../style/arrow_small.png" alt="">&nbsp;&nbsp;<b>Vorname:</b></td>
	    <td align="center"><input class="inputfieldapply" type="text" maxlength="50" name="vorname" value="<?=$vorname?>"></td>
	   </tr>
	   <tr>
	    <td><img src="../style/arrow_small.png" alt="">&nbsp;&nbsp;<b>Nachname:</b></td>
	    <td align="center"><input class="inputfieldapply" type="text" maxlength="50" name="nachname" value="<?=$nachname?>"></td>
	   </tr>
	   <tr>
	    <td><img src="../style/arrow_small.png" alt="">&nbsp;&nbsp;<b>E-Mail:</b> </td>
	    <td align="center"><input class="inputfieldapply" type="text" maxlength="50" name="email" value="<?=$email?>"></td>
	   </tr>
	   <tr>
	    <td><img src="../style/arrow_small.png" alt="">&nbsp;&nbsp;<b>Telefon:</b> </td>
	    <td align="center"><input class="inputfieldapply" type="text" maxlength="50" name="telefon" value="<?=$telefon?>"></td>
	   </tr>
	   <tr>
	    <td><img src="../style/arrow_small.png" alt="">&nbsp;&nbsp;<b>Anschrift:</b></td>
	    <td align="center"><input class="inputfieldapply" type="text" maxlength="100" name="strasse" value="<?=$strasse?>"></td>
	   </tr>
     	   <tr>
	    <td><img src="../style/arrow_small.png" alt="">&nbsp;&nbsp;<b>(Firma/Adresszusatz:)</b></td>
	    <td align="center"><input class="inputfieldapply" type="text" maxlength="100" name="firma" value="<?=$firma?>"><br>(falls Zustellung an Gesch&auml;ftsadresse)</td>
	   </tr>
	   <tr>
	    <td valign="top"><img src="../style/arrow_small.png" alt="">&nbsp;&nbsp;<b>[Land]-[PLZ] [Ort]</b></td>
	    <td align="center" valign="top"><input class="inputfieldapplys" type="text" size="2" maxlength="3" name="land" value="<?=$land?>">-<input class="inputfieldapplys" type="text" size="10" maxlength="10" name="plz" value="<?=$plz?>"> <input class="inputfieldapplys" type="text" size="27" maxlength="100" name="ort" value="<?=$ort?>"></td>
	   </tr>
           <tr>
            <td></td>
            <td align="center"><i><small>(z.B. D-13189 Berlin, A-1150 Wien, CH-8092 Z&uuml;rich, FL-9490 Vaduz)</small></i></td>
           </tr>
           <tr>
            <td></td>
            <td align="center"><img class="captcha" id="captcha" src="../math_captcha/image.php" alt="CAPTCHA Image" title="Klicken Sie zum neuladen auf das Bild" onclick="javascript:reloadCaptcha()">&nbsp; <a class="help" href="">[?] <span>Es handelt sich bei dieser Sicherheitsabfrage um eine <b>Rechenaufgabe</b>. Der einzugebende Wert entspricht der L&ouml;sung dieser Aufgabe <b>nicht</b> der dargestellten Zeichenfolge. Wird beispielweise <b>3 + 5</b> angezeigt, so ist der einzugebende Wert <b>8</b>.</span></a></td>
	   </tr>
           <tr>
            <td></td>
            <td align="center"><i><small>(Zum neuladen klicken Sie bitte auf das Bild.)</small></i></td>
           </tr>
           <tr>
            <td><img src="../style/arrow_small.png" alt="">&nbsp;<b>Bitte tragen Sie das<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ergebnis der Aufgabe <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;im Bild ein:</td>
	        <td align="center"><input class="inputfieldapply" value="" onclick="this.value=''" type="text" name="secure" size="5" maxlength="2"></td>
           </tr>
           <tr>
            <td></td>
            <td align="center"><input class="inputbuttonapply" type="submit"  value="Anmeldung abschicken&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"></td>
           </tr>
          </table>
          </form>

	 <p>Falls Sie Probleme bei der Anmeldung haben (aufgrund von Spam mu&szlig;ten wir diese leider technisch erschweren), nehmen wir Ihre Anmeldung gerne auch per <a href="mailto:&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;">E-Mail</a> entgegen und beantworten Fragen zur Mitgliedschaft und zum Institut.</p>

          <?
            }
          ?>
         <div id="tabs-wrapper-lower"></div>
        </div>
<? include "_side_not_in.php"; ?>
        </div>
<? include "_footer.php"; ?>
