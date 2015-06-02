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
  $sql="SELECT * from produkte WHERE (type LIKE 'buch' OR type LIKE 'scholie' OR type LIKE 'analyse') AND id='$id'";
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
	<div class="medien_head">
  		<h1><?echo $entry3[title]?></h1>
  		<div class="centered">
			<img src="<?echo $img;?>" alt="<?echo $id;?>">
		</div>
	</div>
	<div class="medien_seperator">
		<h1>Inhalt</h1>
	</div>
	<div class="medien_content">
<? 
  if ($entry3[text]) echo $entry3[text];
  if ($entry3[text2]) echo $entry3[text2];
?>
  <!-- Button trigger modal -->
  		<div class="centered">
  			<input type="button" class="medien_inputbutton" value="Bestellen und Herunterladen" data-toggle="modal" data-target="#myModal">  
  		</div>
  		<div class="medien_anmeldung"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">zur&uuml;ck zu den Schriften</a></div>
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
    	
<?php
$sql = "SELECT * from produkte WHERE (type LIKE 'buch' OR type LIKE 'scholie' OR type LIKE 'analyse') AND status > 0 order by title asc, n asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

	echo "<table class='schriften_table'>";

while($entry = mysql_fetch_array($result))
{
	$id = $entry[id];
	
		      	//check, if there is a image in the salon folder
	$img = 'http://test.wertewirtschaft.net/schriften/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/schriften/default.jpg";
	}
	
?>
		<tr>
			<td class="schriften_table_a">
				<img src="<?echo $img_url;?>" alt="Cover <?echo $id;?>">
			</td>			
			<td class="schriften_table_b">
				<span><? echo ucfirst($entry[type]);?></span><br>
      			<? echo "<a href='?q=$id'>".$entry[title]." </a>"; ?>
			</td>
			<td class="schriften_table_c">	
				<input type="button" class="inputbutton" value="Bestellen / Herunterladen" data-toggle="modal" data-target="#myModal">
			</td>
		</tr>

<?php
	}
	echo "</table>";
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
        <h2 class="modal-title" id="myModalLabel">Bestellen und Herunterladen</h2>
      </div>
      <div class="modal-body">
  			<p>Wir freuen uns, dass Sie Interesse an unseren Schriften haben. Bitte tragen Sie hier Ihre E-Mail-Adresse ein, um mehr &uuml;ber die M&ouml;glichkeiten der Bestellung oder des Herunterladens digitaler Dateien zu erfahren (diese k&ouml;nnen wir leider nicht offen zug&auml;nglich machen):</p>
        <div class="subscribe">
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform">
          	<input class="inputfield" type="email" placeholder=" E-Mail Adresse" name="user_email" required>
          	<input class="inputbutton" type="submit" name="submit" value="Eintragen">
          </form> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="inputbutton_white" data-dismiss="modal">Schließen</button>
      </div>
    </div>
  </div>
</div>

<?php include('_footer.php'); ?>