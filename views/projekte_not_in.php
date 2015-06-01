<?php 
require_once('../classes/Login.php');
include ("_header_not_in.php"); 
$title="Projekte";
?>

<div class="content">

<?php
if ($id = $_GET["q"])
{
  $sql="SELECT * from produkte WHERE `type` LIKE 'projekt' AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry = mysql_fetch_array($result);
  $title=$entry[title];
  $avail=$entry[spots]-$entry[spots_sold];
  $text=$entry[text];
?>
	<div class="medien_head">
  		<h1><?echo $title?></h1>
	</div>
	<div class="medien_seperator">
		<h1>Inhalt und Informationen</h1>
	</div>
	<div class="medien_content">
<?php
 	if ($entry[img]) echo $entry[img];

  	if ($entry[text]) echo $entry[text];
 	if ($entry[text2]) echo $entry[text2];
?>
   		<!-- Button trigger modal -->
   		<div class="centered">
    		<input type="button" value="Investieren" class="medien_inputbutton" data-toggle="modal" data-target="#myModal"> 
    	</div>
    	<div class="medien_anmeldung"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">zur&uuml;ck zu den Projekten</a></div>
	</div>

<?php
}

else {
?>
	<div class="medien_info">
		<h1>Projekte</h1>  

		<p>In der Wertewirtschaft finden Sie eine professionelle, seri&ouml;se und realistische Alternative, als B&uuml;rger in den langfristigen Bestand, die Entwicklung und das Gedeihen Ihrer Gesellschaft zu investieren. Ohne dieses b&uuml;rgerliche Engagement bliebe es bei der ewigen Polarisierung von Markt und Staat, die meist zugunsten der Gewalt entschieden wird. Wir &uuml;berlassen Ihnen aber freilich Ausma&szlig; und Verwendung Ihres Beitrages &ndash; bitte w&auml;hlen Sie jene Projekte aus, die Ihnen sinnvoll erscheinen. Je nach H&ouml;he Ihrer Investition profitieren Sie als Anerkennung Ihres Beitrages von den Angeboten der Wertewirtschaft.</p>
	</div>
	<div class="medien_seperator">
		<h1>Offene Projekte</h1>
	</div>
	<div class="medien_content">

<?php 
$sql = "SELECT * from produkte WHERE `type` LIKE 'projekt' AND spots_sold < spots AND status > 0 order by n asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

  while($entry = mysql_fetch_array($result))
  {
    $id = $entry[id];
   ?>
	<div class="projekte">
		<h1><a href='?q=<?php echo $id;?>'><?php echo $entry[title];?></h1></a>
		<?php echo $entry[text]; ?>
		<div class="medien_anmeldung"><a href="?q=<?php echo $id;?>">weitere Informationen</a></div>
		<div class='centered'><p class='linie'><img src='../style/gfx/linie.png' alt=''></p></div>
 	</div>   
    <?php
    }
    ?>

</div>

<?php 
} 
?>

</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Investieren</h2>
      </div>
      <div class="modal-body">
        Spendenformular

        </div>
      <div class="modal-footer">
        <button type="button" class="inputbutton_white" data-dismiss="modal">Schließen</button>
      </div>
    </div>
  </div>
</div>

<?php 
include "_footer.php"; 
?>