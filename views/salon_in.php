<!-- Bootstrap -->
<link href="../style/modal.css" rel="stylesheet">

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../tools/bootstrap.js"></script>


<?
require_once('../classes/Login.php');
$title="Salon";
include "_header_in.php"; 

//print_r($_SESSION);

//Inserted from catalog.php
if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}

if(isset($_POST['add'])){

  $add_id = $_POST['add'];
  $add_quantity = $_POST['quantity'];
  $add_code = $add_id . "0";
  echo "<div style='text-align:center'><hr><i>You added ".$add_quantity." item(s) (ID: ".$add_id.") to your basket.</i> &nbsp <a href='../abo/korb.php'>Go to Basket</a><hr><br></div>";

  if (isset($_SESSION['basket'][$add_id])) {
    $_SESSION['basket'][$add_code] += $add_quantity; 
  }
  else {
    $_SESSION['basket'][$add_code] = $add_quantity; 
  }
}

if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Termindetails
  $sql="SELECT * from produkte WHERE type LIKE 'salon' AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  $n = $entry3[n];
  
  	//check, if there is a image in the salon folder
	$img = 'http://test.wertewirtschaft.net/salon/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/salon/default.jpg";
	}  
?>
  <div class="content">
  	<div class="salon">
  		<h1><?echo $entry3[title]?></h1>

  		<img src="<?echo $img_url;?>" alt="<? echo $id;?>">

  		<p class="salon_date">Termin: 
  <?php
  /* weekdays don't work
    $day=date("w",strtotime($entry3[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */
    echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry3[start]));
  	echo "</p>";
  if ($entry3[text]) echo "<p>$entry3[text]</p>";
  if ($entry3[text2]) echo "<p>$entry3[text2]</p>";

?>

  <p>Unser Salon erweckt eine alte Wiener Tradition zu neuem Leben: Wie im Wien der Jahrhundertwende widmen wir uns gesellschaftlichen, philosophischen und wirtschaftlichen Themen ohne Denkverbote, politische Abh&auml;ngigkeiten und Ideologien, Sonderinteressen und Schablonen. Dieser Salon soll ein erfrischender Gegenentwurf zum vorherrschenden Diskurs sein. Wir besinnen uns dabei auf das Beste der Wiener Salontradition.</p>

  <p>N&uuml;tzen Sie die Gelegenheit, die Wertewirtschaft und deren au&szlig;ergew&ouml;hnliche G&auml;ste bei einem unserer Salonabende kennenzulernen. Ein spannender und tiefgehender Input bringt Ihren Geist auf Hochtouren, worauf dann eine intensive Diskussion in intimer Atmosph&auml;re folgt. Dabei kommt auch das leibliche Wohl nicht zu kurz: Selbst zu bereitete Gaumenfreuden und gute Tropfen machen den Abend auch zu einem kulinarischen Erlebnis.</p>

<?php
  if ($_SESSION['Mitgliedschaft'] == 1) {  
    //Button trigger modal
    echo '<div class="salon_reservation">';
    echo '<input class="inputbutton" type="button" value="Reservieren" data-toggle="modal" data-target="#myModal">';
	echo '</div>';
  }
  else {
    ?>
    <form class="salon_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />
      Menge: <select name="quantity">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>        
      </select> 
      <input class="inputbutton" type="submit" value="Auswählen">&nbsp;<i><?php echo $entry3[price]; ?> Credits pro Credits</i>
    </form>
<?php  
  }

}

else {
?>		
	<div class="content">
  		<div class="salon">
		<?
//für Interessenten (Mitgliedschaft 1) Erklärungstext oben
	echo "<div class='salon_info'>";
  if ($_SESSION['Mitgliedschaft'] == 1) {
    echo "<p>Unser Salon erweckt eine alte Wiener Tradition zu neuem Leben: Wie im Wien der Jahrhundertwende widmen wir uns gesellschaftlichen, philosophischen und wirtschaftlichen Themen ohne Denkverbote, politische Abh&auml;ngigkeiten und Ideologien, Sonderinteressen und Schablonen. Dieser Salon soll ein erfrischender Gegenentwurf zum vorherrschenden Diskurs sein. Wir besinnen uns dabei auf das Beste der Wiener Salontradition.</p>";

    echo "<p>N&uuml;tzen Sie die Gelegenheit, die Wertewirtschaft und deren au&szlig;ergew&ouml;hnliche G&auml;ste bei einem unserer Salonabende kennenzulernen. Ein spannender und tiefgehender Input bringt Ihren Geist auf Hochtouren, worauf dann eine intensive Diskussion in intimer Atmosph&auml;re folgt. Dabei kommt auch das leibliche Wohl nicht zu kurz: Selbst zu bereitete Gaumenfreuden und gute Tropfen machen den Abend auch zu einem kulinarischen Erlebnis.</p>";
     echo "</div>";
  }
?>       
             
  <h2>Termine:</h2>        

  <?php
  $sql = "SELECT * from produkte WHERE type LIKE 'salon' AND start > NOW() AND spots > spots_sold AND status = 1 order by start asc, n asc";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

  while($entry = mysql_fetch_array($result))
  {
    $id = $entry[id];
      ?>
<?php echo "<h3><a href='?q=$id'><i>".$event_id."</i>".$entry[title]; ?></a></h3>
	<div class="salon_dates"><?php echo date("d.m.Y",strtotime($entry[start])); ?> %ndash; 
						 	 <?php echo date("H:i",strtotime($entry[start])); ?>
	</div>
		<?php echo $entry[text]; ?>
		
  <?php
  }
  ?>

   <h5>Informationen</h5>
   
   <p><b>Veranstaltungsort:</b></p>
   
   <p><table width="570px"><tr><td width="50%" valign="top">
   <ul>
    <li class="ort"><b>Institut f&uuml;r Wertewirtschaft</b></li>
    <li class="ort">Schl&ouml;sselgasse 19/2/18</li>
    <li class="ort">A 1080 Wien</li>
    <li class="ort">&Ouml;sterreich</li>
    <li class="ort">&nbsp;</li>
    <li class="ort">Fax: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+43 1 2533033 4733</li>
    <li class="ort">E-Mail: &nbsp;<a href="mailto:&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;">&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;</a></li>
   </ul>
   
   <p><b>Teilnahme:</b></p> <p>10 Euro (5 Euro f&uuml;r <a href="../institut/mitglied.php">Mitglieder</a>). Inkludiert sind Buffet und Getr&auml;nke. Eine Anmeldung ist n&ouml;tig, da beschr&auml;nkte Platzzahl. Aufpreis an der Abendkassa (f&uuml;r unangemeldete Teilnehmer, falls noch Pl&auml;tze frei) 5 Euro, Platzgarantie nur f&uuml;r <a href="../institut/mitglied.php">M&auml;zene</a>. Video&uuml;bertragung f&uuml;r <a href="../institut/mitglied.php">Mitglieder</a>.</p></td> 
   <td><iframe width="300" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.de/maps?f=q&amp;source=s_q&amp;hl=de&amp;geocode=&amp;q=Schl%C3%B6sselgasse+19%2F18+1080+Wien,+%C3%96sterreich&amp;aq=0&amp;oq=Schl%C3%B6sselgasse+19%2F18,+1080+Wien&amp;sll=51.175806,10.454119&amp;sspn=7.082438,21.643066&amp;ie=UTF8&amp;hq=&amp;hnear=Schl%C3%B6sselgasse+19,+Josefstadt+1080+Wien,+%C3%96sterreich&amp;t=m&amp;z=14&amp;ll=48.213954,16.353095&amp;output=embed"></iframe><br /><small><a href="https://maps.google.de/maps?f=q&amp;source=embed&amp;hl=de&amp;geocode=&amp;q=Schl%C3%B6sselgasse+19%2F18+1080+Wien,+%C3%96sterreich&amp;aq=0&amp;oq=Schl%C3%B6sselgasse+19%2F18,+1080+Wien&amp;sll=51.175806,10.454119&amp;sspn=7.082438,21.643066&amp;ie=UTF8&amp;hq=&amp;hnear=Schl%C3%B6sselgasse+19,+Josefstadt+1080+Wien,+%C3%96sterreich&amp;t=m&amp;z=14&amp;ll=48.213954,16.353095"></iframe>
   </td></tr>
   </table></p>
<?php
}    
  ?> 

 <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h2 class="modal-title" id="myModalLabel">Reservieren</h2>
        </div>
        <div class="modal-body">
          <p>Wir freuen uns, dass Sie erstmals teilnehmen wollen! Ein Salon ist jedoch, wenn man ihn ernst nimmt und nicht nur den sch&ouml;nen Namen f&uuml;hrt, eine intime und exklusive Veranstaltung, die viel Vertrauen erfordert. Eine Einzelkarte k&ouml;nnen nur bestehende G&auml;ste der Wertewirtschaft erwerben. Sie k&ouml;nnen entweder einen Ihnen bekannten Gast darum bitten, f&uuml;r Sie zu b&uuml;rgen und eine Eintrittskarte f&uuml;r Sie zu erwerben. Oder Sie werden Teil unseres exklusiven Netzwerks, indem Sie unsere Arbeit mit nur 6.25&euro; im Monat unterst&uuml;tzen und damit auch aus unserer Arbeit vollen Nutzen ziehen k&ouml;nnen: Sie erhalten nicht nur Zugang zu unserem Salon (ohne weitere Mehrkosten, inklusive Abendessen), sondern unter anderem auch Zugang zu den Scholien und zu unserer einzigartigen physischen und digitalen Bibliothek. Ist es das wert? Vertrauen Sie uns (Wertsch&ouml;pfung ist unser Antrieb) &ndash; dann vertrauen auch wir Ihnen.</p>
          <p>Sind Sie gar nicht in Wien zuhause? Keine Sorge, die meisten unserer G&auml;ste kommen von au&szlig;erhalb. Wenn sich kein Wienbesuch mit einem sch&ouml;nen Abend bei uns &uuml;berschneiden sollte, erleiden Sie keine Einbu&szlig;e: Sie k&ouml;nnen stattdessen im selben Gegenwert Aufzeichnungen anh&ouml;ren, Schriften beziehen oder anderswie aus unserem umfangreichen Angebot Nutzen ziehen &ndash; ein Angebot, das insbesondere f&uuml;r Nicht-Wiener gedacht ist, denn vom Unternehmergeist und Erkenntnisdrang des alten Wiens bestehen im neuen leider nur noch letzte Reste. Inspiration findet sich hier aber noch genug, und wir bringen Leben ins Freilicht-Museum! Geben Sie uns eine Chance, auch Sie zu inspirieren und zu beleben.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
          <a href="../abo/"><button type="button" class="btn btn-primary">Jetzt upgraden</button></a>
        </div>
      </div>
    </div>
  </div>

        </div>
	</div>
<? include "_footer.php"; ?>