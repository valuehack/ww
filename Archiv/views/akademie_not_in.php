<? session_start();
include "_db.php";
$title="Akademie";
if ($id)
    {
  $anrede = $_POST['anrede'];
  $nachname = $_POST['nachname'];
  $vorname = $_POST['vorname'];
  $email = $_POST['email'];
  $telefon = $_POST['telefon'];
  $strasse = $_POST['strasse'];
  $land = $_POST['land'];
  $plz = $_POST['plz'];
  $ort = $_POST['ort'];
  $nachricht = $_POST['nachricht'];
  $guests = $_POST['guests'];
  $ok = $_POST['ok'];
  $waitlist = $_POST['waitlist'];

  $aufschlag=15;
  $result4 = mysql_query("SELECT oz from gold");
  $entry4=mysql_fetch_array($result4);
  $goldpreis=$entry4[oz];

//Termindetails

    $sql="SELECT * from termine WHERE id='$id'";
    $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
    $entry3 = mysql_fetch_array($result);
  $title=$entry3[title];
  $avail=$entry3[spots]-$entry3[spots_sold];
  $gold=$entry3[gold];
  $gold2=$entry3[gold2];
  $adresse=$entry3[adresse];
  $date=strftime("%d.%m.%Y", strtotime($entry3[start]));
  $date2= substr($entry3[start],0,10);


include "_header.php"; 
#<p><? if ($entry3[img]) echo "<img src=\"$entry3[img]\" alt=\"\" class=\"semimg\">"; 
?>
<!--Content-->
<div id="center">
        <div id="content">
      <a class="content" href="../index.php">Index &raquo;</a> <a class="content" href="index.php">Akademie &raquo;</a> <a class="content" href="#"><?=ucfirst($entry3[type])." ".$entry3[title]?></a>
      <div id="tabs-wrapper-lower"></div>
          <h3 style="font-style:none;"><?=ucfirst($entry3[type])." ".$entry3[title]?></h3>

          <p><? if ($entry3[img]) echo $entry3[img]; ?>

          <b>Ort:</b> <? if ($entry3[adresse]) echo $entry3[adresse]; else echo $entry3[location]; ?><br>
      <b>Termin:</b> <? if ($entry3[start]!="0000-00-00"&&$entry3[start]!=$entry3[end])
      {
      $day=date("w",strtotime($entry3[start]));
      if ($day==0) $day=7;
      echo Phrase('day'.$day).", ";
      echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry3[start]))." - ";
    if (strftime("%d.%m.%Y", strtotime($entry3[start]))!=strftime("%d.%m.%Y", strtotime($entry3[end])))
        {
        $day=date("w",strtotime($entry3[end]));
        if ($day==0) $day=7;
        echo Phrase('day'.$day).", ";
        echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry3[end]));
      }
    else echo strftime("%H:%M Uhr", strtotime($entry3[end]));
      }
    elseif ($entry3[start]!="0000-00-00")
      {
      $day=date("w",strtotime($entry3[start]));
      if ($day==0) $day=7;
      echo Phrase('day'.$day).", ";
      echo strftime("%d.%m.%Y", strtotime($entry3[start]));
      }
    else echo "noch offen";
  if ($entry3[flyer1]||$entry3[flyer2]) echo "<br><b>Flyer herunterladen:</b>";
  if ($entry3[flyer1]) echo " <a href=\"http://wertewirtschaft.org/akademie/$entry3[flyer1]\">klein <img src=\"http://liberty.li/Img/icons/portraits.png\"></a>";
  if ($entry3[flyer2]) echo " <a href=\"http://wertewirtschaft.org/akademie/$entry3[flyer2]\">gro&szlig;/Druckqualit&auml;t</a>"; ?>
    <? if ($entry3[text]) echo "<p>$entry3[text]</p>";
    if ($entry3[text2]&&!$ok) echo "<p>$entry3[text2]</p>"; ?>

          <h5>Anmeldung</h5>
  <?
  $ok = $_POST['ok'];
  $full=0;
  if ($entry3[spots_sold]>=$entry3[spots]) { echo "<b>Es sind leider keine Pl&auml;tze mehr frei. Das Programm ist vollkommen ausgebucht. Wenn Sie sich dennoch anmelden wollen, vermerken wir Sie auf eine Warteliste und melden uns bei Ihnen sobald ein Platz frei wird.</b><br>"; $full=1; }
  elseif ($entry3[spots_sold]/$entry3[spots]>.75) echo "<b>Achtung: Nur noch ".($entry3[spots]-$entry3[spots_sold])." Pl&auml;tze frei!</b><br>";
    if ($entry3[anmeldung]) echo "<p>$entry3[anmeldung]</p>";

    elseif (!$ok)
      {
    $euro1=round($gold*$goldpreis*(1+($aufschlag/100)));
    $euro2=round($gold2*$goldpreis*(1+($aufschlag/100))); ?>
          <p><b>Kostenbeitrag:</b> <? echo $gold."&euro;.";
     if ($gold2>0) echo " ($gold2&euro; f&uuml;r Mitglieder)"; ?>
          </p>
  
          <p><form action="?id=<?=$id?>" method="POST" name="formular" onSubmit="return CheckRequiredFields()">
          <input type="hidden" name="ok" value="1">

      <?php if ($entry3[spots]<= $entry3[spots_sold]) { echo '<input type="hidden" name="waitlist" value="1">'; } ?>

      <table align="center" class="apply">
       <tr>
        <td colspan="2">&nbsp;&nbsp;<input class="radioapply" type="radio" name="anrede" value="Herr" <? if ($anrede=="Herr"||!$anrede) echo "checked=\"checked\""; ?>><b>Herr</b>&nbsp;&nbsp;<input class="radioapply" type="radio" name="anrede" value="Frau" <? if ($anrede=="Frau") echo "checked=\"checked\""; ?>><b>Frau</b></td>
       </tr>
           <tr>
        <td style="width:175px"><img src="../style/arrow_small.png">&nbsp;&nbsp;<b>Vorname:</b></td>
        <td align="center"><input class="inputfieldapply" type="text" maxlength="50" name="vorname" value="<?=$vorname?>"></td>
       </tr>
       <tr>
        <td><img src="../style/arrow_small.png">&nbsp;&nbsp;<b>Nachname:</b></td>
        <td align="center"><input class="inputfieldapply" type="text" maxlength="50" name="nachname" value="<?=$nachname?>"></td>
       </tr>
       <tr>
        <td><img src="../style/arrow_small.png">&nbsp;&nbsp;<b>E-Mail:</b> </td>
        <td align="center"><input class="inputfieldapply" type="text" maxlength="50" name="email" value="<?=$email?>"></td>
       </tr>
       <tr>
        <td><img src="../style/arrow_small.png">&nbsp;&nbsp;<b>Telefon:</b> </td>
        <td align="center"><input class="inputfieldapply" type="text" maxlength="50" name="telefon" value="<?=$telefon?>"></td>
       </tr>
       <tr>
        <td><img src="../style/arrow_small.png">&nbsp;&nbsp;<b>Anschrift:</b></td>
        <td align="center"><input class="inputfieldapply" type="text" maxlength="100" name="strasse" value="<?=$strasse?>"></td>
       </tr>
       <tr>
        <td valign="top"><img src="../style/arrow_small.png">&nbsp;&nbsp;<b>[Land]-[PLZ] [Ort]</b></td>
        <td align="center" valign="top"><input class="inputfieldapplys" type="text" size="2" maxlength="3" name="land" value="<?=$land?>">-<input class="inputfieldapplys" type="text" size="10" maxlength="10" name="plz" value="<?=$plz?>"> <input class="inputfieldapplys" type="text" size="27" maxlength="100" name="ort" value="<?=$ort?>"></td>
       </tr>
           <tr>
            <td></td>
            <td align="center"><i><small>(z.B. D-13189 Berlin, A-1080 Wien, CH-8092 Z&uuml;rich, FL-9490 Vaduz)</small></i></td>
           </tr>
       <tr>
            <td valign="top"><img src="../style/arrow_small.png">&nbsp;&nbsp;<b>(Nachricht an uns:)</b></td>
        <td valign="top" align="center"><textarea class="apply" name="nachricht" cols="40" rows="4"></textarea></td>
       </tr>
    <? /*if ($gold2) { ?>
       <tr>
            <td><img src="../style/arrow_small.png">&nbsp;&nbsp;<b>Begleitung:</b></td>
            <td align="center"><select class="apply" name="guests" size="1">
                 <option value="0">ohne Begleitung</option>
                 <option value="1">mit Begleitung</option>
                </select>
            </td>
           </tr> <? } */?>
           <tr>
            <td></td>
            <td align="center"><img class="captcha" id="captcha" src="../math_captcha/image.php" alt="CAPTCHA Image" title="Klicken Sie zum neuladen auf das Bild" onclick="javascript:reloadCaptcha()">&nbsp; <a class="help" href="">[?] <span>Es handelt sich bei dieser Sicherheitsabfrage um eine <b>Rechenaufgabe</b>. Der einzugebende Wert entspricht der L&ouml;sung dieser Aufgabe, <b>nicht</b> der dargestellten Zeichenfolge. Wird beispielweise <b>3 + 5</b> angezeigt, so ist der einzugebende Wert <b>8</b>.</span></a></td>
       </tr>
           <tr>
            <td></td>
            <td align="center"><i><small>(Zum Neuladen klicken Sie bitte auf das Bild.)</small></i></td>
           </tr>
           <tr>
            <td><img src="../style/arrow_small.png" alt="">&nbsp;&nbsp;<b>Bitte tragen Sie das<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ergebnis der Aufgabe <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;im Bild ein:</td>
        <td align="center"><input class="inputfieldapply" onclick="this.value=''" value="" type="text" name="secure" size="5" maxlength="2"></td>
           </tr>
            <td></td>
            <td align="center"><input class="inputbuttonapply" type="submit"  name="submit" value="Anmeldung abschicken&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"></td>
           </tr>
          </table>
          <br>
          </form></p>

     <p>Falls Sie Probleme bei der Anmeldung haben (aufgrund von Spam mu&szlig;ten wir diese leider technisch erschweren), nehmen wir Ihre Anmeldung gerne auch per <a href="mailto:&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;">E-Mail</a> entgegen.
    </p>

<script type="text/javascript" language="JavaScript">

      function CheckRequiredFields() {
      var errormessage = new String();
      // Put field checks below this point.

      if(WithoutContent(document.formular.nachname.value))
        { errormessage += "\n\nNachname vergessen"; }
      if(WithoutContent(document.formular.vorname.value))
        { errormessage += "\n\nVorname vergessen"; }
      if(WithoutContent(document.formular.email.value))
        { errormessage += "\n\nE-Mail vergessen"; }
      if(NoneWithCheck(document.formular.anrede))
        { errormessage += "\n\nAnrede vergessen"; }

      // Put field checks above this point.
      if(errormessage.length > 2) {
        alert('FEHLER:' + errormessage);
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
      </script>
 
      <?
    }
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
?>
          <br><br><div align="center"><h5>Vielen Dank f&uuml;r Ihre Anmeldung!</h5></div>
          <p>Sie sollten nun ein Best&auml;tigungsemail erhalten. Falls Sie dieses Email nicht erreicht, schauen Sie bitte in Ihrem Spam-Ordner nach, bzw. geben Sie uns sicherheitshalber per <a href="mailto:&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;">E-Mail</a> Bescheid.</p> 
    <?

  if ($entry3[spots] > $entry3[spots_sold]) {

    //Email an Institut
    $body = ucfirst($entry3[type]).": $title ($id)\n\n$vorname $nachname";
    if ($guests) $body=$body." mit Begleitung";
    $body=$body."\n$strasse\n$land-$plz $ort";
    if ($nachricht) $body=$body."\n\nNachricht: $nachricht";
    $subject= "Anmeldung zum ".ucfirst($entry3[type])." $id";
    mail ("iwwanmeldungen@gmail.com",$subject,$body,"From: $email\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");
    mail ("moeller.ulrich@gmx.de",$subject,$body,"From: $email\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");

    //Email an Teilnehmer
    $kosten=$gold;
    $kosten2=$gold2;
    $body = "Sehr geehrte";
    if ($anrede=="Herr") $body = $body."r";
    $body = $body." ".$anrede." ";
    $body = $body.$nachname."!\n\n";
    $body = $body."Herzlichen Dank f&uuml;r Ihre Anmeldung zu unserem ".ucfirst($entry3[type])." &quot;$title&quot; am/ab $date.\n\n";
    if ($adresse) $body = $body."Ort: ".$adresse."\n\n";
    else $body = $body."Ort: Wird Ihnen noch rechtzeitig bekannt gegeben.\n\n";
      $body = $body."Bitte entrichten Sie den Kostenbeitrag von ";
     $body = $body.$kosten." EUR";
     if ($gold2>0) $body = $body." bzw. ".$kosten2." EUR f&uuml;r Mitglieder";
    $body = $body." bar vor Ort oder per &Uuml;berweisung auf unser Konto: \nInstitut f&uuml;r Wertewirtschaft\nErste Bank, Wien\nKontonummer: 28824799900\nBankleitzahl: 20111\nIBAN: AT332011128824799900\nBIC: GIBAATWW"; 
      
    $body = $body."\n\nMit diesem Email gilt Ihre Anmeldung als fixiert. Die kostenlose Stornierung der Teilnahme ist bei Eintreffen der Stornierung (per Post, Email oder Fax) bis mindestens 14 Tage vor dem Veranstaltungstermin m&ouml;glich. Bei Storno innerhalb von 14 Tagen vor dem Veranstaltungstermin wird eine Stornogeb&uuml;hr von 30% des Seminarpreises verrechnet. Bei Stornierung am Tag des Seminarbeginns oder bei Nichterscheinen betr&auml;gt die Stornogeb&uuml;hr 100%. Bei Nominierung eines Ersatzteilnehmers entf&auml;llt die Stornogeb&uuml;hr zur G&auml;nze. \n\nWir bedanken uns f&uuml;r Ihr Interesse und freuen uns sehr &uuml;ber Ihre Teilnahme. Bitte weisen Sie auch interessierte Kollegen/Freunde/Bekannte/Verwandte auf unseren Seminar hin.\n\nMit freundlichen Gr&uuml;&szlig;en,\n\nIhr Team im Institut f&uuml;r Wertewirtschaft\n\ninfo@wertewirtschaft.org\nhttp://wertewirtschaft.org";
      $body = html_entity_decode(preg_replace('<br>',"\n",$body));
      mail ($email,html_entity_decode("Vielen Dank f&uuml;r Ihre Anmeldung"),$body,"From: info@wertewirtschaft.org\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");
  }
  else 
  {
    //Email an Institut
    $body = ucfirst($entry3[type]).": $title ($id)\n\n$vorname $nachname\n\nwurde auf die Warteliste gesetzt.";
    if ($guests) $body=$body." mit Begleitung";
    $body=$body."\n$strasse\n$land-$plz $ort";
    if ($nachricht) $body=$body."\n\nNachricht: $nachricht";
    $subject= "Anmeldung zum ".ucfirst($entry3[type])." $id: Auf Warteliste";
    mail ("iwwanmeldungen@gmail.com",$subject,$body,"From: $email\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");
    //mail ("bfallmann@yahoo.de",$subject,$body,"From: $email\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");
    mail ("moeller.ulrich@gmx.de",$subject,$body,"From: $email\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");

    //Email an Teilnehmer
    $body = "Sehr geehrte";
    if ($anrede=="Herr") $body = $body."r";
    $body = $body." ".$anrede." ";
    $body = $body.$nachname."!\n\n";
    $body = $body."Herzlichen Dank f&uuml;r Ihre Anmeldung zu unserem ".ucfirst($entry3[type])." &quot;$title&quot; am/ab $date.\n\n";

    $body = $body."\n\nWir haben Sie in die Warteliste eingetragen. Wenn ein Platz frei wird, werden wir Sie umgehend informieren. \n\nWir bedanken uns f&uuml;r Ihr Interesse. Bitte weisen Sie auch interessierte Kollegen/Freunde/Bekannte/Verwandte auf unsere Veranstaltungen hin.\n\nMit freundlichen Gr&uuml;&szlig;en,\n\nIhr Team im Institut f&uuml;r Wertewirtschaft\n\ninfo@wertewirtschaft.org\nhttp://wertewirtschaft.org";
      $body = html_entity_decode(preg_replace('<br>',"\n",$body));
      mail ($email,html_entity_decode("Vielen Dank f&uuml;r Ihre Anmeldung"),$body,"From: info@wertewirtschaft.org\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");
  }

    if (!$already)
        {
      $tickets=1+$guests;
      mysql_query("INSERT INTO anmeldungen ( `id` , `userid` , `nachname` , `vorname`, `email`, `eventid` , `eventtype` , `eventdate` , `guests` , `payment` , `price`, `time` , `notiz`, `status`, `waitlist`) VALUES ('', '$userid', '$nachname', '$vorname', '$email', '$id', 'seminare', '$date2', '$guests', 'bar', '$kosten', '".date("Y-m-d H:j:s")."' , '".addslashes($nachricht)."', '1', '$waitlist')");
      mysql_query("INSERT INTO Teilnehmer ( `id` ,`Nachname` ,  `Vorname` ,`Email` ,  `Telefon` ,  `Strasse` ,  `PLZ` ,  `Ort` ,  `Land` ,  `Anrede` ,  `Titel` ,  `Anmeldezeit` ,  `Veranstaltung` ,  `Notiz` ,  `Warteliste` ,  `Status` ) VALUES ( '', '".addslashes($nachname)."', '".addslashes($vorname)."', '$email', '$telefon', '".addslashes($strasse)."', '$plz', '$ort', '$land', '$anrede', '', '".date("Y-m-d H:j:s")."', ',$id,', '".addslashes($nachricht)."', '$waitlist', '1' )");

       if ($entry3[spots] > $entry3[spots_sold])
      {
      mysql_query("UPDATE termine SET spots_sold=spots_sold+".($tickets)." WHERE id='$id'");
      }

       if ($email)
          {
          $sql2 = "SELECT id from contacts WHERE Email LIKE '%$email%'";
          $result2 = mysql_query($sql2);
          $entry2 = mysql_fetch_array($result2);
          if ($entry2[id])
            {
            $sql = "UPDATE contacts SET Vorname='$vorname',Nachname='$nachname',Adresse='$strasse',Land='$land',Ort='$ort',PLZ='$plz' WHERE Email = '$email'";
            $result = mysql_query($sql);
            }
          else
            {
            $sql = "INSERT INTO contacts ( `id` , `userid` , `Nachname` , `Vorname` , `nickname` , `Email` , `Telefon` , `Adresse` , `PLZ` , `Ort` , `Land` , `geocode` , `Anrede`, `Du` , `Titel` , `Vorstellung` , `Mitgliedschaft` , `Ablauf` , `Eintragung` , `Datum` , `Notiz` , `Seminare` , `Probenummer` , `N` , `A`, `F`, `M`, `Zahlung`, `PDF` ) VALUES ( '', '0', '".addslashes($nachname)."', '".addslashes($vorname)."', '', '$email', '$telefon', '".addslashes($strasse)."', '$plz', '$ort', '$land', '', '$anrede', '0', '', '', '', '', 'Seminar', '".date("Y-m-d H:j:s")."', '', ',$id,', '', '1', '', '', '', '', '' )";
            $result = mysql_query($sql);
            }
          }
      }
        }
  }

else
    {
    $title="Akademie";
    include "_header.php"; 
    ?>

<!--Content-->
<div id="center">
        <div id="content">
      <a class="content" href="../index.php">Index &raquo;</a> <a class="content" href="index.php">Akademie</a>
      <div id="tabs-wrapper-lower"></div>
           <h3>Akademie</h3>
           
           <p><img class="wallimg big" src="akademie.jpg" alt="" titel="Akademieveranstaltung"></p>
       
       <p>Unsere Akademie inmitten unserer einzigartigen <a href="../institut/ort.php">Bibliothek</a> bietet inhaltliche Vertiefungen abseits des Mainstream-Lehrbetriebs. Wir folgen dabei dem Beispiel der klassischen Akademie - der Bibliothek im Hain der Mu&szlig;e fern vom Wahnsinn der Zeit, in der Freundschaften durch regen Austausch und gemeinsames Nachdenken gestiftet werden. Alle unsere Lehrangebote zeichnen sich durch geb&uuml;hrende Tiefe bei gleichzeitiger Verst&auml;ndlichkeit, kleine Gruppen und gro&szlig;en Freiraum f&uuml;r Fragen und Diskussionen aus. F&uuml;r Teilnehmer aus der Ferne bieten wir interaktive Fernkurse auf h&ouml;chstem technischen Niveau an, soda&szlig; diese &quot;live&quot; dabei sein k&ouml;nnen. Tauchen Sie mit uns in intellektuelle Abenteuer, wie sie unsere Zeit kaum noch zul&auml;&szlig;t.</p>    
          
           <h5>Termine</h5>
           
           <div id="tabs-wrapper-sidebar"></div>
    <?
      $current_dateline=strtotime(date("Y-m-d"));
    $sql="SELECT * from termine WHERE (UNIX_TIMESTAMP(end)>=$current_dateline) and (type='lehrgang' or type='seminare' or type='akademie' or type='seminar' or type='Symposion' or type='Seminar' or type='Lehrgang') and status>0 order by start asc, id asc";
    $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
    while($entry = mysql_fetch_array($result))
      {
      $found=1;
      echo "<div class=\"entry\">";
      echo "<h1>";
      echo "<a href=\"http://wertewirtschaft.org/";
      if ($entry[url]) echo $entry[url];
      else echo "akademie/?id=$entry[id]&q=".preg_replace('/ /','+',$entry[title]);
      echo "\">".ucfirst($entry[type])." $entry[title]</a></h1>";
      echo "<div style=\"padding:5px;\">";
      $day=date("w",strtotime($entry[start]));
      if ($day==0) $day=7;
      echo Phrase('day'.$day).", ";
      echo date("d.m.Y",strtotime($entry[start]));
      if (strtotime($entry[end])>(strtotime($entry[start])+86400))
        {
        echo " - ";
        $day=date("w",strtotime($entry[end]));
        if ($day==0) $day=7;
        echo Phrase('day'.$day).", ";
        echo date("d.m.Y",strtotime($entry[end]));
        }
      echo ", $entry[location]</div>";
     echo "<p>";
     if ($entry[img]) echo $entry[img];
     echo $entry[text];
     echo " <a href=\"http://wertewirtschaft.org/";
      if ($entry[url]) echo $entry[url];
      else echo "akademie/?id=$entry[id]&q=".preg_replace('/ /','+',$entry[title]);
      echo "\">&rarr; N&auml;here Informationen</a></p>";
     echo "</div>";
    }
  }
?>

          <div id="tabs-wrapper-lower" style="margin-top:10px;"></div>
        </div>
         <?php include "_side_not_in.php"; ?>
        </div>
<?php include "_footer.php"; ?>
