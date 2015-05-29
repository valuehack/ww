<?php 

require_once('../classes/Login.php');
include('_header_not_in.php'); 
$title="Schriften";

?>

<div class="content">
	
<?php
if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Termindetails
  $sql="SELECT * from produkte WHERE (type LIKE 'buch' OR type LIKE 'scholien') AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  
      	//check, if there is a image in the salon folder
	$img = 'http://test.wertewirtschaft.net/schriften/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/schriften/default.jpg";
	}
?>  	
	<div class="medien">
  		<h1><?echo $entry3[title]?></h1>
		<!--<img src="<?echo $img;?>" alt="<?echo $id;?>">-->
<? 
  if ($entry3[text]) echo "<p>$entry3[text]</p>";
  if ($entry3[text2]) echo "<p>$entry3[text2]</p>";
?>

  <!-- Button trigger modal -->
  		<input type="button" value="Reservieren" data-toggle="modal" data-target="#myModal">  
  </div>
<?php
}
         
else { 
?>
	<div class="medien_info">
		<h1>Schriften</h1>

		<p>Unsere Schriften umfassen derzeit:<br>

			<ul>
				<li><b>B&uuml;cher</b> &ndash; teilweise eigene, eher f&uuml;r ein breiteres Publikum, teilweise &Uuml;bersetzungen, meist schwierigere Texte</li>
				<li><b>Analysen</b> &ndash; besonders effiziente und lesbare Texte f&uuml;r einen schnellen, aber profunden &Uuml;berblick zu einem Thema</li>
				<li>Restexemplare der gedruckten <b>Scholien</b> bis 2014</li>
			<li>neue Druckausgaben der <b>Scholien</b></li>
			</ul>
		</p>
	</div>
	<div class="medien_seperator">
    	<h1>Schriften</h1>
    </div>
    <div class="medien_content">
    	
		<table style="width:100%;border-collapse: collapse">

	<tr>
    	<td><b>Titel</b></td>

	</tr>

<?php
$sql = "SELECT * from produkte WHERE (type LIKE 'buch' OR type LIKE 'scholien') AND status > 0 order by title asc, n asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
	$id = $entry[id];
?>
   	<tr>
      	<td>
      		<?php 
      		echo "<a href='?id=$q'><i>".ucfirst($entry[type])."</i> ".$entry[title];
			if ($entry[format]) echo " ".$entry[format]." </a></td>"; 

?>    
    </tr>

<?php
}

echo "</table><br><br>";

}
?>

	</div>
</div>

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

<?php include('_footer.php'); ?>