<?php

require_once('config/config.php');

@$con=mysql_connect(DB_HOST,DB_USER,DB_PASS) or die ("cannot connect to MySQL");
mysql_select_db(DB_NAME);

//Ablauf aktualisieren
$sql = "SELECT * from Zahlungen order by Datum asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. mysql_error());
while ($entry = mysql_fetch_array($result))
  {
  $id=$entry[Mitglied];
  $sql2 = "SELECT Zahlung,Ablauf,Eintritt,Mitgliedschaft,Gesamt,Anrede,Titel,Nachname,user_email from mitgliederExt WHERE user_id='$id'";
  $result2 = mysql_query($sql2) or die("Failed Query of " . $sql2. mysql_error());
  $entry2 = mysql_fetch_array($result2);
  $gesamt[$id]=$gesamt[$id]+$entry[Betrag];
  if ($entry[Datum]>$entry2[Zahlung])
    {
    $mitgliedschaft=0;
     if ($entry[Betrag]>=75) $mitgliedschaft=2;
     if ($entry[Betrag]>=150) $mitgliedschaft=3;
     if ($entry[Betrag]>=300) $mitgliedschaft=4;
     if ($entry[Betrag]>=600) $mitgliedschaft=5;
     if ($entry[Betrag]>=1200) $mitgliedschaft=6;
     if ($mitgliedschaft>1)
     	{
      if ($entry2[Ablauf]=="0000-00-00") $ablauf=date("Y-m-d", strtotime(date("Y-m-d", strtotime($entry2[Eintritt])) . " +1 year"));
      else $ablauf=date("Y-m-d", strtotime(date("Y-m-d", strtotime($entry2[Ablauf])) . " +1 year"));
      $sql3 = "UPDATE mitgliederExt SET Zahlung='$entry[Datum]', Ablauf='$ablauf', Gesamt='$gesamt[$id]', Mitgliedschaft='$mitgliedschaft', Mahnstufe=0 WHERE user_id='$id'";
      $result3 = mysql_query($sql3) or die("Failed Query of " . $sql3. mysql_error());
      echo $entry2[Nachname].": ".$ablauf.", &euro; ".$entry[Betrag]."<br>";
      if ($entry2[Anrede]=="Herr") $anrede="Sehr geehrter Herr ";
      else $anrede="Sehr geehrte Frau ";
      if ($entry2[Titel]) $anrede=$anrede.$entry2[Titel]." ";
      $anrede=$anrede.$entry2[Nachname];
      $dankemail=$anrede.",\n\nWir m&ouml;chten Ihnen nur kurz mitteilen, da&szlig; Ihre Unterst&uuml;tzung beim scholarium eingegangen ist. Ihr Vertrauen und Ihre Unterst&uuml;tzung bedeuten uns sehr viel! Nur dank privaten Unterst&uuml;tzern wie Ihnen kann das scholarium unabh&auml;ngig bleiben und &uuml;berleben.\n\n
Falls Sie Fragen haben, stehen wir Ihnen gerne zur Verf&uuml;gung. Herzliche Gr&uuml;&szlig;e und vielen Dank f&uuml;r Ihre Unterst&uuml;tzung,\n\n
Ihr Scholarium";
      $body1 = html_entity_decode(preg_replace('<br>',"\n",$dankemail));
// mail ($entry2[user_email],html_entity_decode("Vielen Dank fuer Ihre Unterstuetzung"),$body1,"From: info@scholarium.at\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");
//echo $body1; 

      }
    }
  }


//Mahnen

/*
//1.Mahnung

$sql = "SELECT * from Mitglieder WHERE (UNIX_TIMESTAMP(Ablauf)<".strtotime(date("Y-m-d")).") AND Ablauf<>'0000-00-00' AND Mahnstufe=0 AND auslaufend=0 order by Ablauf asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. mysql_error());
while ($entry = mysql_fetch_array($result))
  {
  if ($entry[Anrede]=="Herr") $anrede="Sehr geehrter Herr ";
  else $anrede="Sehr geehrte Frau ";
  if ($entry[Titel]) $anrede=$anrede.$entry[Titel]." ";
  $anrede=$anrede.$entry[Nachname];
  $mahnmail1=$anrede.",\n\nDies ist eine automatische Erinnerungsnachricht, dass ein Beitrag f&uuml;r Ihre Mitgliedschaft/Ihr Abonnement f&auml;llig ist. Ihre Mitgliedschaft/Ihr Abonnement war bis ".date("d.m.Y",strtotime($entry[Ablauf]))." bezahlt. Wir m&ouml;chten Sie um rasche &Uuml;berweisung des offenen Betrages bitten, denn unser Institut kann nur deshalb ohne Zwangs- und Lobbygelder &uuml;berleben, wenn uns Menschen wie Sie regelm&auml;&szlig;ig unterst&uuml;tzen.\n\n 
  Ein Abonnement der Scholien ist nunmehr mit einer Mitgliedschaft im Institut f&uuml;r Wertewirtschaft verbunden und bietet Ihnen weitere Vorteile. Der Mindestbeitrag betr&auml;gt 90 Euro. Neue Zusatzleistungen:\n\n
 - Deutliche Erm&auml;&szlig;igungen bei unseren Akademie-Veranstaltungen (schon bei wenigen Besuchen bringt Ihnen die Mitgliedschaft einen finanziellen Vorteil)\n
 - Kostenloser Video-Stream zu unseren Salon-Veranstaltungen\n
 - Wachsende Zahl exklusiver Inhalte (Video/Audio)\n
 - Nutzung der Bibliothek, B&uuml;cherleihe\n\n
Wenn Sie unsere Arbeit f&uuml;r wertvoll halten und honorieren wollen, w&uuml;rden wir uns geehrt f&uuml;hlen durch eine Unterst&uuml;tzung, die &uuml;ber diesem minimalen Kostenbeitrag liegt:\n\n
F&ouml;rdermitgliedschaft - 150 Euro;\n\n
 - Hintergrundinformationen zu unserer Arbeit\n
 - Einladung zu exklusiven Veranstaltungen\n
 - Ihre Begleitung erh&auml;lt den Mitgliedertarif bei unseren Veranstaltungen\n\n
F&ouml;rdermitgliedschaft - 300 Euro;\n\n
 - Zusendung signierter Exemplare aller Bucherscheinungen und sonstiger Publikationen\n\n
Zahlungsoptionen:\n\n
 - Per Bank&uuml;berweisung auf unser EUR-Konto bei der „Erste Bank“ (Wien): 
Kontonummer: 28824799900, Bankleitzahl: 20111;  
IBAN: AT332011128824799900, BIC: GIBAATWW\n
 - Per Paypal (erm&ouml;glicht Kreditkartenzahlung) an die Adresse info@wertewirtschaft.org.\n
 - Bar oder in Edelmetallen auf dem Postweg an: Institut f&uuml;r Wertewirtschaft, Schl&ouml;sselgasse 19/2/18, 1080 Wien, &Ouml;sterreich
 Bitte geben Sie bei der Zahlung an: Mitglied ".$entry[id].".\n\n
Falls Sie Fragen haben, stehen wir Ihnen gerne zur Verf&uuml;gung. Dies ist eine automatisch erstellte Nachricht - wir hoffen, die Technik funktionierte und Sie haben Verst&auml;ndnis f&uuml;r diese unpers&ouml;nliche Erinnerung. Herzliche Gr&uuml;&szlig;e und vielen Dank f&uuml;r Ihre Unterst&uuml;tzung,\n\n
Ihr Institut f&uuml;r Wertewirtschaft";
$body = html_entity_decode(preg_replace('<br>',"\n",$mahnmail1));
mail ($entry[Email],html_entity_decode("Zahlungserinnerung"),$body,"From: info@wertewirtschaft.org\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm"); 
  echo "Mail geschickt an: $entry[Email]<hr>";
  $sql4 = "UPDATE Mitglieder SET Mahnstufe='1' WHERE id='$entry[id]'";
  $result4 = mysql_query($sql4) or die("Failed Query of " . $sql4. mysql_error());
  
  }
  
 if ($body) { mail ("rahim.taghizadegan@gmail.com",html_entity_decode("Zahlungserinnerung"),$body,"From: info@wertewirtschaft.org\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm"); }
*/
 
//2. Mahnung
/*
$sql = "SELECT * from Mitglieder WHERE (UNIX_TIMESTAMP(Ablauf)<".strtotime(date("Y-m-d")).") AND Ablauf<>'0000-00-00' AND Mahnstufe=1 AND auslaufend=0 order by Ablauf asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. mysql_error());
while ($entry = mysql_fetch_array($result))
  {
  if ($entry[Anrede]=="Herr") $anrede="Sehr geehrter Herr ";
  else $anrede="Sehr geehrte Frau ";
  if ($entry[Titel]) $anrede=$anrede.$entry[Titel]." ";
  $anrede=$anrede.$entry[Nachname];
  $mahnmail1=$anrede.",\n\nLeider haben Sie nach unserer letzten Erinnerungsnachricht Ihren Beitrag f&uuml;r Ihre Mitgliedschaft/Ihr Abonnement nicht eingezahlt. Ihre Mitgliedschaft/Ihr Abonnement war bis ".date("d.m.Y",strtotime($entry[Ablauf]))." bezahlt. Wir m&ouml;chten Sie um rasche &Uuml;berweisung des offenen Betrages bitten, denn unser Institut kann nur deshalb ohne Zwangs- und Lobbygelder &uuml;berleben, wenn uns Menschen wie Sie regelm&auml;&szlig;ig unterst&uuml;tzen.\n\n 
  Ein Abonnement der Scholien ist nunmehr mit einer Mitgliedschaft im Institut f&uuml;r Wertewirtschaft verbunden und bietet Ihnen weitere Vorteile. Der Mindestbeitrag betr&auml;gt 90 Euro. Neue Zusatzleistungen:\n\n
 - Deutliche Erm&auml;&szlig;igungen bei unseren Akademie-Veranstaltungen (schon bei wenigen Besuchen bringt Ihnen die Mitgliedschaft einen finanziellen Vorteil)\n
 - Kostenloser Video-Stream zu unseren Salon-Veranstaltungen\n
 - Wachsende Zahl exklusiver Inhalte (Video/Audio)\n
 - Nutzung der Bibliothek, B&uuml;cherleihe\n\n
Wenn Sie unsere Arbeit f&uuml;r wertvoll halten und honorieren wollen, w&uuml;rden wir uns geehrt f&uuml;hlen durch eine Unterst&uuml;tzung, die &uuml;ber diesem minimalen Kostenbeitrag liegt:\n\n
F&ouml;rdermitgliedschaft - 150 Euro;\n\n
 - Hintergrundinformationen zu unserer Arbeit\n
 - Einladung zu exklusiven Veranstaltungen\n
 - Ihre Begleitung erh&auml;lt den Mitgliedertarif bei unseren Veranstaltungen\n\n
F&ouml;rdermitgliedschaft - 300 Euro;\n\n
 - Zusendung signierter Exemplare aller Bucherscheinungen und sonstiger Publikationen\n\n
Zahlungsoptionen:\n\n
 - Per Bank&uuml;berweisung auf unser EUR-Konto bei der „Erste Bank“ (Wien): 
Kontonummer: 28824799900, Bankleitzahl: 20111;  
IBAN: AT332011128824799900, BIC: GIBAATWW\n
 - Per Paypal (erm&ouml;glicht Kreditkartenzahlung) an die Adresse info@wertewirtschaft.org.\n
 - Bar oder in Edelmetallen auf dem Postweg an: Institut f&uuml;r Wertewirtschaft, Schl&ouml;sselgasse 19/2/18, 1080 Wien, &Ouml;sterreich
 Bitte geben Sie bei der Zahlung an: Mitglied ".$entry[id].".\n\n
Falls Sie Fragen haben, stehen wir Ihnen gerne zur Verf&uuml;gung. Dies ist eine automatisch erstellte Nachricht - wir hoffen, die Technik funktionierte und Sie haben Verst&auml;ndnis daf&uuml;r, wenn sich die Technik mal irren sollte (bitte geben Sie uns dann gleich Bescheid). Herzliche Gr&uuml;&szlig;e und vielen Dank f&uuml;r Ihre Unterst&uuml;tzung,\n\n
Ihr Institut f&uuml;r Wertewirtschaft";
$body = html_entity_decode(preg_replace('<br>',"\n",$mahnmail1));
mail ($entry[Email],html_entity_decode("Mahnung"),$body,"From: info@wertewirtschaft.org\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm"); 
  echo "Mail geschickt an: $entry[Email]<hr>";
  $sql4 = "UPDATE Mitglieder SET Mahnstufe='2' WHERE id='$entry[id]'";
  $result4 = mysql_query($sql4) or die("Failed Query of " . $sql4. mysql_error());
  
  }
  
 if ($body) { mail ("rahim.taghizadegan@gmail.com",html_entity_decode("Mahnung"),$body,"From: info@wertewirtschaft.org\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm"); }
*/
/*
//ENTSCHULDIGUNG

$sql = "SELECT * from Mitglieder WHERE (UNIX_TIMESTAMP(Ablauf)<".strtotime(date("Y-m-d")).") AND Ablauf<>'0000-00-00' AND Mahnstufe=1 AND auslaufend=0 order by Ablauf asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. mysql_error());
while ($entry = mysql_fetch_array($result))
  {
  if ($entry[Anrede]=="Herr") $anrede="Sehr geehrter Herr ";
  else $anrede="Sehr geehrte Frau ";
  if ($entry[Titel]) $anrede=$anrede.$entry[Titel]." ";
  $anrede=$anrede.$entry[Nachname];
  $mahnmail1=$anrede.",\n\nBitte vielmals um Verzeihung f&uuml;r die mehrfache Zusendung der Zahlungserinnerung, dies war auf ein technisches Problem zur&uuml;ckzuf&uuml;hren (Internetausfall w&auml;hrend der Bearbeitung). Wir versuchen im Sinne unserer Unterst&uuml;tzer den Verwaltungsaufwand so gering wie m&ouml;glich zu halten, darum senden wir keine Rechnungen, sondern elektronische Erinnerungen aus (falls Sie eine Rechnung ben&ouml;tigen, geben Sie uns Bescheid, wir k&uuml;mmern uns dann pers&ouml;nlich darum). Dies war ein Versuch, die Erinnerungen k&uuml;nftig automatisch zu versenden, denn die Zahl unserer Abonnenten und Mitglieder ist zum Gl&uuml;ck schon so gro&szlig;, da&szlig; ein pers&ouml;nlicher Abgleich nicht mehr m&ouml;glich ist. Bitte haben Sie darum Verst&auml;ndnis f&uuml;r die elektronische Abfertigung. Falls dabei ein Fehler unterlaufen sollte, bitten wir um Verzeihung und Hinweis. Vielen Dank f&uuml;r Ihr Verst&auml;ndnis und Ihre Unterst&uuml;tzung, die f&uuml;r uns sehr wichtig ist. F&uuml;r Fragen und Anregungen stehen wir gerne zur Verf&uuml;gung.\n\nHerzlichst,\n\n
Rahim Taghizadegan";
$body = html_entity_decode(preg_replace('<br>',"\n",$mahnmail1));
mail ($entry[Email],html_entity_decode("Entschuldigung"),$body,"From: info@wertewirtschaft.org\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm"); 
  echo "Mail geschickt an: $entry[Email]<hr>";
  $sql4 = "UPDATE Mitglieder SET Mahnstufe='1' WHERE id='$entry[id]'";
  $result4 = mysql_query($sql4) or die("Failed Query of " . $sql4. mysql_error());
  
  }
  
 if ($body) { mail ("rahim.taghizadegan@gmail.com",html_entity_decode("Entschuldigung"),$body,"From: info@wertewirtschaft.org\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm"); }



//REPAIR
$sql = "SELECT * from Zahlungen order by Datum asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. mysql_error());
while ($entry = mysql_fetch_array($result))
  {
  $sql2 = "SELECT Email from Mitglieder WHERE id='$entry[Mitglied]'";
  $result2 = mysql_query($sql2) or die("Failed Query of " . $sql2. mysql_error());
  $entry2 = mysql_fetch_array($result2);
  $sql3 = "SELECT Zahlung,Ablauf from contacts WHERE Email='$entry2[Email]'";
  $result3 = mysql_query($sql3) or die("Failed Query of " . $sql3. mysql_error());
  $entry3 = mysql_fetch_array($result3);
      $sql4 = "UPDATE Mitglieder SET Zahlung='$entry3[Zahlung]', Ablauf='$entry3[Ablauf]' WHERE id='$entry[Mitglied]'";
      $result4 = mysql_query($sql4) or die("Failed Query of " . $sql4. mysql_error());
      echo $sql4."<br>";
      

  }
*/


/*
//IMPORT

$sql = "SELECT * from contacts WHERE (A>0 OR M>0) AND userid>0 order by userid asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. mysql_error());
while ($entry = mysql_fetch_array($result))
  {
    $notiz=str_replace(array("\r\n", "\r", "\n"), '/', $entry[Notiz]);
    if ($entry[Mitgliedschaft]=="Gr&uuml;nder"||$entry[Mitgliedschaft]=="Gr&uuml;nder ") {$notiz="Gr&uuml;nder/".$notiz;}
    elseif ($entry[Mitgliedschaft]) {$notiz=$notiz."/(".$entry[Mitgliedschaft]." Euro)";}
    if ($entry[F]==1) {$mitgliedschaft=5;}
    if ($entry[A]==1&&$entry[M]==0) {$mitgliedschaft=2;}
    elseif ($entry[F]==1||($entry[Mitgliedschaft]>=120&&$entry[Mitgliedschaft]<300)) {$mitgliedschaft=5;}
    elseif ($entry[Mitgliedschaft]>=240) {$mitgliedschaft=6;}
    else {$mitgliedschaft=4;}
    if ($entry[PDF]==1) {$scholien=0;}
    else {$scholien=1;}
    if ($entry[Land]=="A"||$entry[Land]=="AT") {$land="Oesterreich";}
    elseif ($entry[Land]=="D") {$land="Deutschland";}
    elseif ($entry[Land]=="CH") {$land="Schweiz";}
    elseif ($entry[Land]=="FL") {$land="Liechtenstein";}
     elseif ($entry[Land]=="nl") {$land="Niederlande";}
      elseif ($entry[Land]=="F") {$land="Frankreich";}
       elseif ($entry[Land]=="I") {$land="Italien";}
    else {$land=$entry[Land];}

    $sql2 = "INSERT INTO Mitglieder (`id`, `Nachname`, `Vorname`, `Email`, `Telefon`, `Firma`, `Strasse`, `PLZ`, `Ort`, `Land`, `Anrede`, `Titel`, `Anredename`, `Du`, `Mitgliedschaft`, `Ablauf`, `Eintritt`, `Notiz`, `Gesamt`, `Scholien`, `Mahnstufe`) VALUES ('','$entry[Nachname]','$entry[Vorname]','$entry[Email]','$entry[Telefon]','','$entry[Adresse]','$entry[PLZ]','$entry[Ort]','$land','$entry[Anrede]','$entry[Titel]','$entry[nickname]','$entry[Du]','$mitgliedschaft','$entry[Ablauf]','$entry[Datum]','$notiz','','$scholien','')";
  $result2 = mysql_query($sql2) or die("Failed Query of " . $sql2. mysql_error());
    }

    $sql = "SELECT * from contacts WHERE (A>0 OR M>0) AND userid=0 order by id asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. mysql_error());
while ($entry = mysql_fetch_array($result))
  {
    $notiz=str_replace(array("\r\n", "\r", "\n"), '/', $entry[Notiz]);
    if ($entry[Mitgliedschaft]=="Gr&uuml;nder"||$entry[Mitgliedschaft]=="Gr&uuml;nder ") {$notiz="Gr&uuml;nder/".$notiz;}
    elseif ($entry[Mitgliedschaft]) {$notiz=$notiz."/(".$entry[Mitgliedschaft]." Euro)";}
    if ($entry[F]==1) {$mitgliedschaft=5;}
    if ($entry[A]==1&&$entry[M]==0) {$mitgliedschaft=2;}
    elseif ($entry[F]==1||($entry[Mitgliedschaft]>=120&&$entry[Mitgliedschaft]<300)) {$mitgliedschaft=5;}
    elseif ($entry[Mitgliedschaft]>=240) {$mitgliedschaft=6;}
    else {$mitgliedschaft=4;}
    if ($entry[PDF]==1) {$scholien=0;}
    else {$scholien=1;}
    if ($entry[Land]=="A"||$entry[Land]=="AT") {$land="Oesterreich";}
    elseif ($entry[Land]=="D") {$land="Deutschland";}
    elseif ($entry[Land]=="CH") {$land="Schweiz";}
    elseif ($entry[Land]=="FL") {$land="Liechtenstein";}
     elseif ($entry[Land]=="nl") {$land="Niederlande";}
      elseif ($entry[Land]=="F") {$land="Frankreich";}
       elseif ($entry[Land]=="I") {$land="Italien";}
    else {$land=$entry[Land];}

    $sql2 = "INSERT INTO Mitglieder (`id`, `Nachname`, `Vorname`, `Email`, `Telefon`, `Firma`, `Strasse`, `PLZ`, `Ort`, `Land`, `Anrede`, `Titel`, `Anredename`, `Du`, `Mitgliedschaft`, `Ablauf`, `Eintritt`, `Notiz`, `Gesamt`, `Scholien`, `Mahnstufe`) VALUES ('','$entry[Nachname]','$entry[Vorname]','$entry[Email]','$entry[Telefon]','','$entry[Adresse]','$entry[PLZ]','$entry[Ort]','$land','$entry[Anrede]','$entry[Titel]','$entry[nickname]','$entry[Du]','$mitgliedschaft','$entry[Ablauf]','$entry[Datum]','$notiz','','$scholien','')";
  $result2 = mysql_query($sql2) or die("Failed Query of " . $sql2. mysql_error());
    }
    */
?>