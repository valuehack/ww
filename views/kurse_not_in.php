<?php 
//Author: Bernhard Hegyi

require_once('../classes/Login.php');
include('_header.php'); 
$title="Kurse";

?>

<div id="center">  
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a><a class="content" href="<?php echo $_SERVER['PHP_SELF']; ?>"> Kurse</a>
<div id="tabs-wrapper-lower"></div>

<?php 

if(isset($_GET['id']))
{
  $id = $_GET['id'];

  //Termindetails
  $sql="SELECT * from produkte WHERE id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  $title=$entry3[title];
  $avail=$entry3[spots]-$entry3[spots_sold];
?>
  
  <h3 style="font-style:none;"><?=ucfirst($entry3[type])." ".$entry3[title]?></h3>

  <p><? if ($entry3[img]) echo $entry3[img]; ?>

  <b>Termin:</b> 
  <? 
  /* weekdays don't work
    $day=date("w",strtotime($entry3[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */
    echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry3[start]));
  
  if ($entry3[text]) echo "<p>$entry3[text]</p>";
  if ($entry3[text2]) echo "<p>$entry3[text2]</p>";

?>
  <hr>
  <h5>Anmeldung</h5>
  <i><p>Melden Sie sich heute noch an (beschr&auml;nkte Pl&auml;tze) &ndash; Sie erhalten nicht nur eine Eintrittskarte f&uuml;r den Kurs, sondern auch Zugang zu den Scholien, unserem Salon, Schriften, Medien etc.</p></i><br><br>

  <div>
    Platzhalter Anmeldeformular
  </div>

  <div class="subscribe">
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform">
          <input class="inputfield" id="keyword" type="email" placeholder=" E-Mail Adresse" name="user_email" autocomplete="off" required />
          <input class="inputfield" id="user_password" type="password" name="user_password" placeholder=" Passwort" autocomplete="off" style="display:none"  />
          <input class="inputbutton" id="inputbutton" type="submit" name="fancy_ajax_form_submit" value="Eintragen" />
          </form> 
  </div>
<?php
}

else {
  ?>

  <h2>Kurse</h2>

  <!--<p><img class="wallimg big" src="akademie.jpg" alt="" titel="Akademieveranstaltung"></p>-->
         
  <p>Unsere Kurse inmitten unserer einzigartigen Bibliothek bieten inhaltliche Vertiefungen abseits des Mainstream-Lehrbetriebs. Wir folgen dabei dem Beispiel der klassischen Akademie &ndash; der Bibliothek im Hain der Mu&szlig;e fern vom Wahnsinn der Zeit, in der Freundschaften durch regen Austausch und gemeinsames Nachdenken gestiftet werden. Alle unsere Lehrangebote zeichnen sich durch geb&uuml;hrende Tiefe bei gleichzeitiger Verst&auml;ndlichkeit, kleine Gruppen und gro&szlig;en Freiraum f&uuml;r Fragen und Diskussionen aus. Tauchen Sie mit uns in intellektuelle Abenteuer, wie sie unsere Zeit kaum noch zul&auml;&szlig;t.</p>
  <hr>
  <h5>Termine</h5>
             
  <div id="tabs-wrapper-sidebar"></div>

  <?php
  $current_dateline=strtotime(date("Y-m-d"));
  
  $sql="SELECT * from produkte WHERE (UNIX_TIMESTAMP(start)>=$current_dateline) and (type='lehrgang' or type='seminar' or type='kurs') and status>0 order by start asc, id asc";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  
  while($entry = mysql_fetch_array($result))
  {
    $found=1;
    $id = $entry[id];
    echo "<div class=\"entry\">";
    echo "<h1>";
    echo "<a href='?id=$id'>";
    echo ucfirst($entry[type])." ".$entry[title]."</a></h1>";
     
    echo "<div style=\"padding:5px;\">";
    /* weekdays don't work:
    $day=date("w",strtotime($entry[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */
    echo date("d.m.Y",strtotime($entry[start]));
    
    
    echo "<p>";
    if ($entry[img]) echo $entry[img];
    echo $entry[text];
    echo " <a href='?id=$id'>";
    echo "&rarr; N&auml;here Informationen</a></p>";
    echo "</div></div>";
  } 
}
?>

<div id="tabs-wrapper-lower" style="margin-top:10px;"></div>


</div>
<?php include('_side_not_in.php'); ?>
</div>
<?php include('_footer.php'); ?>