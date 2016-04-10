<?php 
require_once('../classes/Login.php');
$title="Programme";
include ("_header_not_in.php"); 
?>

<div class="content">

<?php
if(isset($_GET['q']))
{
  $id = $_GET['q'];
  
  //Programmdetails
  $sql="SELECT * from produkte WHERE `type` LIKE 'programm' AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry = mysql_fetch_array($result);
  $title=$entry[title];
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
    		<input type="button" value="Ausw&auml;hlen" class="medien_inputbutton" data-toggle="modal" data-target="#myModal"> 
    	</div>
    	<div class="medien_anmeldung"><a href="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>">zur&uuml;ck zu den Programmen</a></div>
	</div>

<?php
}

else {
?>
	<div class="medien_info">
		<h1>Programme</h1>  

		<?php  
			$sql = "SELECT * from static_content WHERE (page LIKE 'programme')";
			$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
			$entry4 = mysql_fetch_array($result);
	
				echo $entry4[info];			
			?>
				<div class="centered">
					<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
						<input class="inputfield" id="user_email" type="email" placeholder=" E-Mail-Adresse" name="user_email" required>
  						<input type=hidden name="first_reg" value="programme">
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
        <h2 class="modal-title" id="myModalLabel">Ausw&auml;hlen</h2>
      </div>
      <div class="modal-body">
         <p>Wir freuen uns, dass Sie Interesse an unseren Programmen haben. Bitte tragen Sie hier Ihre E-Mail-Adresse ein, um mehr dar&uuml;ber zu erfahren:
         </p>
        <div class="subscribe">
          <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
          	<input class="inputfield" type="email" placeholder=" E-Mail-Adresse" name="user_email" required>
          	<input type=hidden name="first_reg" value="programme">
          	<input class="inputbutton" type="submit" name="eintragen_submit" value="Kostenlos eintragen">
          </form> 
        </div>
      </div>
    </div>
  </div>
</div>

<?php 
include "_footer.php"; 
?>