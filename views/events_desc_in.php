<?php 

include ("_db.php"); 
include ("_header.php"); 
$title="Akademie";


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
	<?php if ($entry3[text]) echo "<p>$entry3[text]</p>";
	if ($entry3[text2]&&!$ok) echo "<p>$entry3[text2]</p>"; ?>

</div>
          
<?php include "_side_in.php"; ?>
</div>

<?php 
include "_footer.php"; 
?>