<!--Author: Bernhard Hegyi
    Content: Blog view for members-->

<?php 

require_once('../classes/Login.php');
include('_header.php'); 
$title="Blog";

?>

<div id="center">  
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a><a class="content" href="<?php echo $_SERVER['PHP_SELF']; ?>"> Blog</a>
<div id="tabs-wrapper-lower"></div>

<h2>Scholien</h2>

<?php 
if(isset($_GET['id']))
{
	$id = $_GET['id'];

 	$sql = "SELECT * from blog WHERE id='$id'";
	$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
	$entry = mysql_fetch_array($result);

	$title = $entry[title];
	$private = $entry['private'];
	$public = $entry['public'];
	$publ_date = $entry[publ_date];
	
	echo "<h5>".$title."</h5>";
	echo "<i>Keyword: ".$id."&nbsp &nbsp &nbsp Datum: ".date('d.m.Y', strtotime($publ_date))."</i><br>";
	
	if ($_SESSION['Mitgliedschaft'] == 1) {
		echo $public."<br>";
		echo "Beschreibung Mitgliedschaft: <br> Das Institut für Wertewirtschaft ist eine gemeinnützige Einrichtung, die sich durch einen besonders langfristigen Zugang auszeichnet. Um unsere Unabhängigkeit zu bewahren, akzeptieren wir keinerlei Mittel, die aus unfreiwilligen Zahlungen (Steuern, Gebühren, Zwangsmitgliedschaften etc.) stammen. Umso mehr sind wir auf freiwillige Investitionen angewiesen. Nur mit Ihrer Unterstützung können wir unsere Arbeit aufrecht erhalten oder ausweiten.";
		echo "<a href='/upgrade.php'> &rarr; Upgrade</a><br>";
		echo "<br><a href='index.php'>Alle Scholien</a>";
	}

	else {
		echo $private."<br><br>";
		echo "<a href='index.php'>Alle Scholien</a>";
	}
	
}

else 
{
	$limit=5;
	$n=0;
	$sql = "SELECT * from blog WHERE publ_date<=CURDATE() order by publ_date desc, id asc";
	
	if ($offset||$limit) $sql=$sql." limit ";
	if ($offset) $sql=$sql.$offset.",";
	if ($limit) $sql=$sql."$limit";
	
	$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

	while($entry = mysql_fetch_array($result))
	{
		$id = $entry[id];
		$title = $entry[title];
		$private = $entry['private'];
		$publ_date = $entry[publ_date];

		echo "<h5><a href='?id=$id'>".$title."</a></h5>";
		echo "<i>Keyword: ".$id."&nbsp &nbsp &nbsp Datum: ".date('d.m.Y', strtotime($publ_date))."</i><br>";
		
		if (strlen($private) > 500) {
			echo substr ($private, 0, 500);
			echo " ... </p><a href='?id=$id'>&rarr; Weiterlesen</a><hr>";
		}
		else {
			echo $private;
			echo " <a href='?id=$id'>&rarr; Weiterlesen</a><hr>";
		}
	$n++;
	}
if ($n==$limit)
	{
		echo $sql;
  ?>
          <div align="right"><b><a href="?offset=<?=($offset+$limit)?>">&rarr;Mehr Blogposts</a></b></div>
<?
        }
}
?>

</div>
<?php include('_side_in.php'); ?>
</div>
<?php include('_footer.php'); ?>