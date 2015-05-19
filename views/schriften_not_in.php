<!-- Bootstrap -->
<link href="../style/modal.css" rel="stylesheet">

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../tools/bootstrap.js"></script>


<?php 
//Author: Bernhard Hegyi

require_once('../classes/Login.php');
include('_header.php'); 
$title="Schriften";

?>

<div id="center">  
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a><a class="content" href="<?php echo $_SERVER['PHP_SELF']; ?>"> Schriften</a>
<div id="tabs-wrapper-lower"></div>

<?php
if(isset($_GET['id']))
{
  $id = $_GET['id'];

  //Termindetails
  $sql="SELECT * from produkte WHERE id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
?>
  
  <h3 style="font-style:none;"><?echo $entry3[title]?></h3>

<? 
	if ($entry3[img]) echo $entry3[img];

  if ($entry3[text]) echo "<p>$entry3[text]</p>";
  if ($entry3[text2]) echo "<p>$entry3[text2]</p>";

?>

  <!-- Button trigger modal -->
  <input type="button" value="Reservieren" data-toggle="modal" data-target="#myModal">  
  
<?php
}
         
else { 
?>

<h2>Schriften</h2>

<p>Unsere Schriften umfassen derzeit:<br>

<ul>
	<li>B&uuml;cher &ndash; teilweise eigene, eher f&uuml;r ein breiteres Publikum, teilweise &Uuml;bersetzungen, meist schwierigere Texte</li>
	<li>Analysen &ndash; besonders effiziente und lesbare Texte f&uuml;r einen schnellen, aber profunden &Uuml;berblick zu einem Thema</li>
	<li>Restexemplare der gedruckten Scholien bis 2014</li>
	<li>neue Druckausgaben der Scholien</li>
</ul>
</p>

<div id="tabs-wrapper-sidebar"></div>

<table style="width:100%;border-collapse: collapse">

	<tr>
    	<td><b>Titel</b></td>

	</tr>

<?php
$sql = "SELECT * from produkte WHERE type LIKE 'buch' OR type LIKE 'scholien' AND status > 0 order by title asc, id asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
	$id = $entry[id];
?>
   	<tr>
      	<td>
      		<?php 
      		echo "<a href='?id=$id'><i>".ucfirst($entry[type])."</i> ".$entry[title];
			if ($entry[author]) echo " ".$entry[author]; 
			if ($entry[format]) echo " ".$entry[format]." </a></td>"; 

?>    
    </tr>

<?php
}

echo "</table><br><br>";

}
?>


<br><br><br><br><br><br><br><br><br>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Reservierung</h2>
      </div>
      <div class="modal-body">
  			<p>Wir freuen uns, dass Sie Interesse an unseren Schriften haben. Bitte tragen Sie hier Ihre E-Mail-Adresse ein, um mehr &uuml;ber die M&ouml;glichkeiten der Bestellung oder des Herunterladens digitaler Dateien zu erfahren (diese k&ouml;nnen wir leider nicht offen zug&auml;nglich machen):</p>
        <div class="subscribe">
<!--           
  Commented out, because of the clashes between forms
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform">
          <input class="inputfield" id="keyword" type="email" placeholder=" E-Mail Adresse" name="user_email" autocomplete="off" required />
          <input class="inputfield" id="user_password" type="password" name="user_password" placeholder=" Passwort" autocomplete="off" style="display:none"  />
          <input class="inputbutton" id="inputbutton" type="submit" name="fancy_ajax_form_submit" value="Eintragen" />
          </form>  -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
      </div>
    </div>
  </div>
</div>


</div>
<?php include('_side_not_in.php'); ?>
</div>
<?php include('_footer.php'); ?>