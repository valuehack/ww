<?
$id=$HTTP_GET_VARS['id'];
$t=$HTTP_GET_VARS['t'];
$q=$HTTP_GET_VARS['q'];
$active="vortraege";
include "/home/content/56/6152056/html/rahim/header1.inc.php";

include "/home/content/56/6152056/html/rahim/header2.inc.php";
?>
<td valign="top" width="600">
<h1>N&auml;chste Termine, zu denen ich vortrage/lehre:</h1><ul style="font-size:12px">
<?
$current_dateline=strtotime(date("Y-m-d"));
$to_dateline=$current_dateline+(14*86400);
$sql = "SELECT * from termine WHERE UNIX_TIMESTAMP(start)>=$current_dateline and status>0 and rt=1 order by start asc limit 10";
//echo $sql;
  $result = mysql_query($sql);
  while($entry = mysql_fetch_array($result))
    {
    echo "<li><b>".date("d.m.Y",strtotime($entry[start]));
    if (strtotime($entry[end])>(strtotime($entry[start])+86400)) echo "-".date("d.m.Y",strtotime($entry[end]));
    echo " ($entry[location])</b> - <a href=\"http://wertewirtschaft.org/";
    if ($entry[url]) echo $entry[url];
    else echo $entry[type]."/?id=$entry[id]&q=".ereg_replace(" ","+",$entry[title]);
    echo "\">$entry[title]</a></li>";
    }
	  ?>
<h1>Vergangene Termine</h1><ul style="font-size:12px">
<?
$current_dateline=strtotime(date("Y-m-d"));
$to_dateline=$current_dateline+(14*86400);
$sql = "SELECT * from termine WHERE UNIX_TIMESTAMP(start)<$current_dateline and status>0 and rt=1 order by start desc limit 10";
//echo $sql;
  $result = mysql_query($sql);
  while($entry = mysql_fetch_array($result))
    {
    echo "<li><b>".date("d.m.Y",strtotime($entry[start]));
    if (strtotime($entry[end])>(strtotime($entry[start])+86400)) echo "-".date("d.m.Y",strtotime($entry[end]));
    echo " ($entry[location])</b> - <a href=\"http://wertewirtschaft.org/";
    if ($entry[url]) echo $entry[url];
    else echo $entry[type]."/?id=$entry[id]&q=".ereg_replace(" ","+",$entry[title]);
    echo "\">$entry[title]</a></li>";
    }
	  ?>
</ul><p>Anfragen f&uuml;r Vortr&auml;ge bitte <a href="mailto:info&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;">an mein B&uuml;ro</a>.</p></td>
<?
include "/home/content/56/6152056/html/rahim/footer.inc.php";
?>
