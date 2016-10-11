<?
require_once('../classes/Login.php');
$title="Medien";
include('_header_not_in.php');

?>

<div class="content">

 <?php
if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Termindetails
  $sql="SELECT * from produkte WHERE (type LIKE 'paket' or type LIKE 'audio' or type LIKE 'video') AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);

      	//check, if there is a image in the medien folder
	$img = 'http://www.scholarium.at/medien/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://www.scholarium.at/medien/default.jpg";
	}
?>
    <?php
        $product_info = $general->getProduct($id);
  ?>
  <div class="content-area centered">
    <h2><?=$product_info->title?></h2>
  </div>

  <div class="medien_seperator">
		<h1>Inhalt</h1>
	</div>
	<div class="medien_content">
<?
  if ($entry3[text]) echo "<p>".$entry3[text]."</p>";
  if ($entry3[text2]) echo "<p>".$entry3[text2]."</p>";
?>

  	<!-- Button trigger modal and media information -->

<div class="medien_content">
<?php
  if ($product_info->text) echo "<p>".$product_info->text."</p>";
  if ($product_info->text2) echo "<p>".$product_info->text2."</p>";
?>
  	<div class="centered">
  		<input type="button" class="inputbutton" value="Herunterladen" data-toggle="modal" data-target="#myModal">
  	</div>
  	<div class="medien_anmeldung"><a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">zur&uuml;ck zu den Medien</a></div>
  </div>
<?php
}

else {
?>
	<div class="medien_info">
		<h1>Medien</h1>

		<?php
				$sql = "SELECT * from static_content WHERE (page LIKE 'medien')";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				$entry = mysql_fetch_array($result);

				echo $entry[info];
			?>
				<div class="centered">
					<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
						<input class="inputfield" id="user_email" type="email" placeholder=" E-Mail-Adresse" name="user_email" required>
  						<input type=hidden name="first_reg" value="medien">
  						<input class="inputbutton" type="submit" name="eintragen_submit" value="Kostenlos eintragen">
					</form>
				</div>
	</div>
<?
}
?>

	</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Herunterladen</h2>
      </div>
      <div class="modal-body">
         <p>Wir freuen uns, dass Sie Interesse an unseren Medien haben. Bitte tragen Sie hier Ihre E-Mail-Adresse ein, um mehr &uuml;ber die M&ouml;glichkeiten der Bestellung oder des Herunterladens digitaler Dateien zu erfahren (diese k&ouml;nnen wir leider nicht offen zug&auml;nglich machen):
         </p>
        <div class="subscribe">
          <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
          	<input class="inputfield" type="email" placeholder=" E-Mail-Adresse" name="user_email" required>
          	<input type=hidden name="first_reg" value="medien">
          	<input class="inputbutton" type="submit" name="eintragen_submit" value="Kostenlos eintragen">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<? include "_footer.php"; ?>
