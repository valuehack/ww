<?php 
//Author: Bernhard Hegyi

require_once('../classes/Login.php');
include('_header.php'); 
$title="Seminare";

?>

<div id="center">  
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a><a class="content" href="<?php echo $_SERVER['PHP_SELF']; ?>"> Seminare</a>
<div id="tabs-wrapper-lower"></div>

<?php 

if(isset($_GET['id']))
{
  $id = $_GET['id'];

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
?>
  
  <h3 style="font-style:none;"><?=ucfirst($entry3[type])." ".$entry3[title]?></h3>

  <p><? if ($entry3[img]) echo $entry3[img]; ?>

  <b>Ort:</b> <? if ($entry3[adresse]) echo $entry3[adresse]; else echo $entry3[location]; ?><br>
  <b>Termin:</b> 
  <? 
  if ($entry3[start]!="0000-00-00"&&$entry3[start]!=$entry3[end])
  {
    /* weekdays don't work
    $day=date("w",strtotime($entry3[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */
    echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry3[start]))." - ";
    if (strftime("%d.%m.%Y", strtotime($entry3[start]))!=strftime("%d.%m.%Y", strtotime($entry3[end])))
      {
      /*  
      $day=date("w",strtotime($entry3[end]));
      if ($day==0) $day=7;
      echo Phrase('day'.$day).", ";
      */
      echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry3[end]));
      }
    else echo strftime("%H:%M Uhr", strtotime($entry3[end]));
  }
  elseif ($entry3[start]!="0000-00-00")
    {
    /*
    $day=date("w",strtotime($entry3[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */
    echo strftime("%d.%m.%Y", strtotime($entry3[start]));
    }
  else echo "noch offen";
  
  if ($entry3[text]) echo "<p>$entry3[text]</p>";
  if ($entry3[text2]) echo "<p>$entry3[text2]</p>";

?>
  <hr>
  <h5>Anmeldung</h5>
  <i>Wenn Sie sich für unser Seminar interessieren, tragen Sie sich hier völlig unverbindlich ein:</i><br><br>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform" style="text-aligna:center; paddinga: 10px ">
      <input class="inputfield" id="user_email" type="email" placeholder=" E-Mail Adresse" name="user_email" required /><br>
      <input class="inputbutton" type="submit" name="subscribe" value="Eintragen" />
  </form><br>

<?php
}

else {
  ?>

  <h2>Seminare</h2>

  <p><img class="wallimg big" src="akademie.jpg" alt="" titel="Akademieveranstaltung"></p>
         
  <p>Unsere Akademie inmitten unserer einzigartigen <a href="../institut/ort.php">Bibliothek</a> bietet inhaltliche Vertiefungen abseits des Mainstream-Lehrbetriebs. Wir folgen dabei dem Beispiel der klassischen Akademie - der Bibliothek im Hain der Mu&szlig;e fern vom Wahnsinn der Zeit, in der Freundschaften durch regen Austausch und gemeinsames Nachdenken gestiftet werden. Alle unsere Lehrangebote zeichnen sich durch geb&uuml;hrende Tiefe bei gleichzeitiger Verst&auml;ndlichkeit, kleine Gruppen und gro&szlig;en Freiraum f&uuml;r Fragen und Diskussionen aus. F&uuml;r Teilnehmer aus der Ferne bieten wir interaktive Fernkurse auf h&ouml;chstem technischen Niveau an, soda&szlig; diese &quot;live&quot; dabei sein k&ouml;nnen. Tauchen Sie mit uns in intellektuelle Abenteuer, wie sie unsere Zeit kaum noch zul&auml;&szlig;t.</p>    

  <h5>Termine</h5>
             
  <div id="tabs-wrapper-sidebar"></div>

  <?php
  $current_dateline=strtotime(date("Y-m-d"));
  
  $sql="SELECT * from termine WHERE (UNIX_TIMESTAMP(end)>=$current_dateline) and (type='lehrgang' or type='seminare' or type='akademie' or type='seminar' or type='Symposion' or type='Seminar' or type='Lehrgang') and status>0 order by start asc, id asc";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  
  while($entry = mysql_fetch_array($result))
  {
    $found=1;
    $id = $entry[id];
    echo "<div class=\"entry\">";
    echo "<h1>";
    echo "<a href='?id=$id'>";
    echo ucfirst($entry[type])." $entry[title]</a></h1>";
     
    echo "<div style=\"padding:5px;\">";
    /* weekdays don't work:
    $day=date("w",strtotime($entry[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */
    echo date("d.m.Y",strtotime($entry[start]));
    
    if (strtotime($entry[end])>(strtotime($entry[start])+86400))
      {
      echo " - ";
      /*
      $day=date("w",strtotime($entry[end]));
      if ($day==0) $day=7;
      echo Phrase('day'.$day).", ";
      */
      echo date("d.m.Y",strtotime($entry[end]));
      }
    echo ", $entry[location]</div>";
    
    echo "<p>";
    if ($entry[img]) echo $entry[img];
    echo $entry[text];
    echo " <a href='?id=$id'>";
    echo "&rarr; N&auml;here Informationen</a></p>";
    echo "</div>";
  } 
}
?>

<div id="tabs-wrapper-lower" style="margin-top:10px;"></div>


</div>
<?php include('_side_not_in.php'); ?>
</div>
<?php include('_footer.php'); ?>