<? 
include "../header1.inc.php";
$title="Analysen";
include "../header2.inc.php"; 
?>
<!--Content-->
<div id="center">
        <div id="content">
	  <a class="content" href="../index.php">Index &raquo;</a> <a class="content" href="#">Publikationen &raquo;</a> <a class="content" href="#">Analysen</a>
	  <div id="tabs-wrapper-lower"></div>
          <h3>Analysen</h3>

          <p>Diese thematischen Vertiefungen k&ouml;nnen Sie als "Kostproben" unserer Arbeit kostenlos herunterladen. Angenehmer liest es sich jedoch im Druck: <a href="../scholien/abo.php">&rarr;Bestellen Sie unsere Analysen im Abonnement</a> (und lassen Sie sich alle bisherigen Analysen, von denen noch Exemplare verf&uuml;gbar sind, mitschicken). Wenn Ihnen unsere Art der Auseinandersetzung zusagt, <a href="../angebote/#analysen">schreiben wir gerne auch f&uuml;r Sie</a>.</p>

<?
$limit=10;
$n=0;
$sql="SELECT * from analysen";
if ($id) $sql=$sql." WHERE id='$id'";
elseif ($tag) $sql=$sql." WHERE tags LIKE '%$tag%'";
$sql=$sql." order by time desc";
if ($offset||$limit) $sql=$sql." limit ";
if ($offset) $sql=$sql.$offset.",";
if ($limit) $sql=$sql."$limit";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
while($entry = mysql_fetch_array($result))
  {
   echo "<div class=\"entry\">";
    // if (!ereg("0000",$entry[time])) $date=strftime("%d.%m.%Y", strtotime($entry[time]));
    if (!preg_match('/ 0000 /',$entry[time])) $date=strftime("%d.%m.%Y", strtotime($entry[time]));    
  else $date=strftime("%d.%m.%Y", strtotime($entry[time_input]));
    $preview=$entry[id];
   echo "<h5><a href=\"$entry[url]\" style=\"border:none;\">$entry[titel]</a></h5>";
    echo "<div>$date, $entry[autor]</div>";
      $resize="";
	    if ($entry[img])
	      {
	      $info = @ getimagesize($entry[img]);
	      if ($info[0]<115||$info[1]<80) $resize="";
	      if ($info[0]>115&&$info[0]>$info[1]) $resize="width=\"100\"";
	      elseif ($info[1]>80&&$info[0]<=$info[1]) $resize="height=\"80\"";
	      if (!$info[0]||!$info[1]) $resize="height=\"70\"";
	      echo "<p><img class=\"anaimg\" alt=\"\" src=\"$entry[img]\" $resize>";
	      }
	    else echo "<p>";
	    echo $entry[text];
      if ($entry[url]) echo " <a href=\"$entry[url]\"><b>&rarr;Kostenlos herunterladen</b></a>";
    echo "</p></div>";
    $n++;
	}
if ($n==$limit)
	{
  ?>
          <div align="right"><b><a href="?offset=<?=($offset+$limit)?>">&rarr;Mehr Analysen</a></b></div>
<?
        }
?>
          <div id="tabs-wrapper-lower"></div>
        </div>
         <? include "../sidebar.inc.php"; ?>
        </div>
<? include "../footer.inc.php"; ?>