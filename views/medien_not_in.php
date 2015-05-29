<?
require_once('../classes/Login.php');
include('_header_not_in.php'); 
$title="Mitgliederbereich";

?>

<div class="content">
 
 <?php
if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Termindetails
  $sql="SELECT * from produkte WHERE (type LIKE 'audio' OR type LIKE 'video') AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  
      	//check, if there is a image in the salon folder
	$img = 'http://test.wertewirtschaft.net/medien/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/medien/default.jpg";
	}
?>
  	<div class="medien_head">
  		<h1><?=$entry3[title]." (".ucfirst($entry3[type]).")";?></h1>
		<!--<img src="<?echo $img;?>" alt="<?echo $id;?>">-->
	<div class="medien_seperator">
		<h1>Inhalt und Informationen</h1>
	</div>
	<div class="medien_content">
<? 
  if ($entry3[text]) echo $entry3[text];
  if ($entry3[text2]) echo $entry3[text2];
?>

  	<!-- Button trigger modal -->
  	<div class="centered">
  		<input type="button" value="Reservieren" data-toggle="modal" data-target="#myModal">
  	</div>  
  </div>
<?php
}
         
else { 
?>
   
	<div class="medien_info">
		<h1>Medien</h1>

  		<p>Da die meisten unserer G&auml;ste nicht in Wien zuhause sind und unsere Arbeit ein Publikum im gesamten deutschsprachigen Raum anspricht (hinter der Wertewirtschaft stehen deutsche, Schweizer und Liechtensteiner Unternehmer), bieten wir selbstverst&auml;ndlich digitale Medien an, die es erlauben, an unseren Erkenntnissen auch aus der Ferne teilzuhaben. Wir geben uns dabei viel M&uuml;he, den Fernzugang zu angenehm wie m&ouml;glich zu halten. Sie k&ouml;nnen also nicht nur bequem nachlesen, sondern meist auch nachh&ouml;ren, was sich in der Wertewirtschaft tut.</p>
	</div>
	
	<div class="medien_seperator">
    	<h1>Audio</h1>
    </div>
	<div class="medien_content">
		<table style="width:100%;border-collapse: collapse">


<?php
$sql = "SELECT * from produkte WHERE type LIKE 'audio' AND status > 0 order by title asc, n asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
  $id = $entry[id];
?>
    <tr>
        <td>
          <?php 
          echo "<a href='?q=$id'><i>".$entry[title];
      if ($entry[format]) echo " ".$entry[format]." </a></td>"; 

?>    
    </tr>

<?php
}

echo "</table><br><br>";

echo "</div>";

/*
?>

<h5>Video</h5>

<table style="width:100%;border-collapse: collapse">


<?php
$sql = "SELECT * from produkte WHERE type LIKE 'video' AND status > 0 order by title asc, id asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
  $id = $entry[id];
?>
    <tr>
        <td>
          <?php 
          echo "<a href='?q=$id'><i>".$entry[title];
      if ($entry[author]) echo " - ".$entry[author]; 
      if ($entry[format]) echo " ".$entry[format]." </a></td>"; 

?>    
    </tr>

<?php
}

echo "</table><br><br>";
*/
}
?>

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
         <p>Wir freuen uns, dass Sie Interesse an unseren Medien haben. Bitte tragen Sie hier Ihre E-Mail-Adresse ein, um mehr &uuml;ber die M&ouml;glichkeiten der Bestellung oder des Herunterladens digitaler Dateien zu erfahren (diese k&ouml;nnen wir leider nicht offen zug&auml;nglich machen):</p>
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

<? include "_footer.php"; ?>