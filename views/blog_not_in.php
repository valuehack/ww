<!--Author: Bernhard Hegyi
    Content: Blog view for non-members-->

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
	 echo "Institutsgrülnder Rahim Taghizadegan lädt ein zu einer ganz persönlichen Weltschau. Seine Scholien (Scholion: Randnotiz) erscheinen als Quartalsschrift und enthalten Gedanken, Ideen, Fragen, Rezensionen, Empfehlungen, Exzerpte, Gedichte, Kontakte und Fundstücke. Dieses Angebot richtet sich primär an Freunde und Seelenverwandte und ist daher persönlich und frei von der Leber geschrieben - ohne Blatt vor dem Mund. <hr><br>";
	
	// #$scholien = htmlentities($scholien);

	// echo $scholien;

	$id = $_GET['id'];

 	$sql = "SELECT * from blog WHERE id='$id'";
	$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
	$entry = mysql_fetch_array($result);

	$title = $entry[title];
	$public = $entry['public'];
	$publ_date = $entry[publ_date];

	echo "<h5>".$title."</h5>";
	echo "<i>Keyword: ".$id."&nbsp &nbsp &nbsp Datum: ".date('d.m.Y', strtotime($publ_date))."</i><br>";
	echo $public."<br>";
?>
	<i>Wenn Sie weiterlesen wollen, tragen Sie sich hier völlig unverbindlich ein:</i><br><br>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform" style="text-aligna:center; paddinga: 10px ">
  		<input class="inputfield" id="user_email" type="email" placeholder=" E-Mail Adresse" name="user_email" required /><br>
  		<input class="inputbutton" type="submit" name="subscribe" value="Eintragen" />
	</form><br>

	<a href='index.php'>Alle Scholien</a>
<?php
}
else 
{
	$sql = "SELECT * from blog WHERE publ_date<=CURDATE() order by publ_date desc, id asc";	//$sql = "SELECT * from blog WHERE 'date'>='".date("Y-m-d")."'";
	$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

	while($entry = mysql_fetch_array($result))
	{
		$id = $entry[id];
		$title = $entry[title];
		$public = $entry['public'];
		$publ_date = $entry[publ_date];

		echo "<h5><a href='?id=$id'>".$title."</a></h5>";
		echo "<i>Keyword: ".$id."&nbsp &nbsp &nbsp Datum: ".date('d.m.Y', strtotime($publ_date))."</i><br>";
		
		if (strlen($public) > 500) {
			echo substr ($public, 0, 500);
			echo " ... </p><a href='?id=$id'>&rarr; Weiterlesen</a><hr>";
		}
		else {
			echo $public;
			echo " <a href='?id=$id'>&rarr; Weiterlesen</a><hr>";
		}
	}
}
?>

</div>
<?php include('_side_not_in.php'); ?>
</div>
<?php include('_footer.php'); ?>