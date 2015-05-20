<!-- Bootstrap -->
<link href="../style/modal.css" rel="stylesheet">

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../tools/bootstrap.js"></script>


<?
require_once('../classes/Login.php');
$title="Medien";
include "_header.php";

?>
<!--Content-->
<div id="center">
        <div id="content">
          <a class="content" href="../index.php">Index &raquo;</a> <a class="content" href="index.php"> Medien</a>
	    <div id="tabs-wrapper"></div>

<?php 
if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}

if(isset($_POST['add'])){

  $add_id = $_POST['add'];
  //$actual_quantity = $_SESSION['basket'][$add_id];
  $add_quantity = $_POST['quantity'];
  //$new_quantity = $add_quantity + $actual_quantity;
  echo "<div style='text-align:center'><hr><i>You added ".$add_quantity." item(s) (ID: ".$add_id.") to your basket.</i> &nbsp <a href='../abo/korb.php'>Go to Basket</a><hr><br></div>";

  if (isset($_SESSION['basket'][$add_id])) {
    $_SESSION['basket'][$add_id] += $add_quantity; 
  }
  else {
    $_SESSION['basket'][$add_id] = $add_quantity; 
  }
}


if(isset($_GET['id']))
{
  $id = $_GET['id'];

  //Termindetails
  $sql="SELECT * from produkte WHERE type LIKE 'audio' OR type LIKE 'video' AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  $n = $entry3[n];
?>
  
  <h3 style="font-style:none;"><?=$entry3[title]." (".ucfirst($entry3[type]).")";?></h3>

<? 
  if ($entry3[img]) echo $entry3[img];

  if ($entry3[text]) echo "<p>$entry3[text]</p>";
  if ($entry3[text2]) echo "<p>$entry3[text2]</p>";

  if ($_SESSION['Mitgliedschaft'] == 1) {  
    //Button trigger modal
    echo '<input type="button" value="Reservieren" data-toggle="modal" data-target="#myModal">';  
  }
  else {
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />
      <select name="quantity">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>        
      </select> 
      <input type="submit" value="Auswählen">&nbsp;<i><?php echo $entry3[price]; ?> Credits</i>
    </form>
<?php 
  }

}
     

else {
  echo "<h2>Medien</h2>";

  if ($_SESSION['Mitgliedschaft'] == 1) {
  ?>       
      <p>Da die meisten unserer G&auml;ste nicht in Wien zuhause sind und unsere Arbeit ein Publikum im gesamten deutschsprachigen Raum anspricht (hinter der Wertewirtschaft stehen deutsche, Schweizer und Liechtensteiner Unternehmer), bieten wir selbstverst&auml;ndlich digitale Medien an, die es erlauben, an unseren Erkenntnissen auch aus der Ferne teilzuhaben. Wir geben uns dabei viel M&uuml;he, den Fernzugang zu angenehm wie m&ouml;glich zu halten. Sie k&ouml;nnen also nicht bequem nachlesen, sondern meist auch nachh&ouml;ren, was sich in der Wertewirtschaft tut.</p>
  <?
  } ?>

<div id="tabs-wrapper-sidebar"></div>

<h5>Audio</h5>

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
          echo "<a href='?id=$id'><i>".$entry[title];
      if ($entry[author]) echo " - ".$entry[author]; 
      if ($entry[format]) echo " ".$entry[format]." </a></td>"; 

?>    
    </tr>

<?php
}

echo "</table><br><br>";


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
          echo "<a href='?id=$id'><i>".$entry[title];
      if ($entry[author]) echo " - ".$entry[author]; 
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
          <p>Wir freuen uns, dass Sie eine unserer Aufzeichnungen herunterladen m&ouml;chten. Allerdings sind einige Aufnahmen nicht f&uuml;r die &Ouml;ffentlichkeit bestimmt &ndash; wir und unsere G&auml;ste m&uuml;ssten uns ein allzu gro&szlig;es Blatt vor den Mund nehmen, wenn jeder mith&ouml;ren k&ouml;nnte. Das Herunterladen von Medien steht nur unseren G&auml;sten zur Verf&uuml;gung, die einen kleinen Kostenbeitrag (6,25&euro;) f&uuml;r das Bestehen der Wertewirtschaft leisten (und daf&uuml;r die meisten Medien kostenlos beziehen k&ouml;nnen). K&ouml;nnen Sie sich das leisten? Dann folgen Sie diesem Link und in K&uuml;rze erhalten Sie Zugriff auf alle unsere Medien:</p>
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
<? include "_side_in.php"; ?>
</div>
<? include "_footer.php"; ?>