<?
$id=$HTTP_GET_VARS['id'];
$t=$HTTP_GET_VARS['t'];
$q=$HTTP_GET_VARS['q'];
$active="artikel";
include "/home/content/56/6152056/html/rahim/header1.inc.php";

include "/home/content/56/6152056/html/rahim/header2.inc.php";
?>
<td valign="top" width="600">
<p>Ich publiziere prim&auml;r f&uuml;r das Institut f&uuml;r Wertewirtschaft, in der Regel l&auml;ngere Analysen. Gelegentlich &uuml;berwinde ich meinen Widerwillen und schreibe f&uuml;r Zeitungen und Zeitschriften. Ich kann es nicht leiden, auf ein "Publikum", eine Zeichenzahl oder eine redaktionelle Vorgabe schielend zu schreiben - das lenkt meinen Blick vom Wesentlichen ab.</p>

<h1>Letzte Analysen</h1>
  <?
  $limit=10;
	$sql="SELECT * from analysen WHERE autor='Rahim Taghizadegan' order by time desc limit $limit";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
while($entry = mysql_fetch_array($result))
  {
  $url="http://wertewirtschaft.org/analysen/$entry[url]";

  echo "<div class=\"magentry\">";
  if (!ereg("0000",$entry[time])) $date=strftime("%d.%m.%Y", strtotime($entry[time]));

 echo "<h2><a href=\"$url\" style=\"border:none;\" target=\"_parent\">$entry[titel]</a> ($date)</h2>";
    echo "<p>".stripslashes($entry[text])."</p>";
    echo "</div>";
  }
?>
</td>
<?
include "/home/content/56/6152056/html/rahim/footer.inc.php";
?>
