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
  $sql="SELECT * from produkte WHERE id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  $n = $entry3[n];
?>
  
  <h3 style="font-style:none;"><?echo $entry3[title]?></h3>

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
  echo "<h2>Schriften</h2>";

  if ($_SESSION['Mitgliedschaft'] == 1) {
  ?>       
    <p>Unsere Schriften umfassen derzeit:<br>
      <ul>
        <li>B&uuml;cher &ndash; teilweise eigene, eher f&uuml;r ein breiteres Publikum, teilweise &Uuml;bersetzungen, meist schwierigere Texte</li>
        <li>Analysen &ndash; besonders effiziente und lesbare Texte f&uuml;r einen schnellen, aber profunden &Uuml;berblick zu einem Thema</li>
        <li>Restexemplare der gedruckten Scholien bis 2014</li>
        <li>neue Druckausgaben der Scholien</li>
      </ul>
</p>     
  <?
  } ?>

  <div id="tabs-wrapper-sidebar"></div>

<table style="width:100%;border-collapse: collapse">

  <tr>
      <td style="width:60%"><b>Titel</b></td>
      <td style="width:20%"><b>Quantity</b></td>
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


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Mitgliedschaft 75</h2>
      </div>
      <div class="modal-body">
        <p>Wir freuen uns, dass Sie eine unserer Schriften bestellen m&ouml;chten. Allerdings sind einige Schriften nicht f&uuml;r die &Ouml;ffentlichkeit bestimmt, andere sind im Buchhandel zu erwerben,&nbsp;da ein Vertrieb und Versand f&uuml;r uns nicht wirtschaftlich&nbsp;ist. Unser Webshop, &uuml;ber den alle Schriften entweder bestellt oder in allen digitalen Formaten f&uuml;r Leseger&auml;te heruntergeladen werden k&ouml;nnen, steht nur unseren G&auml;sten zur Verf&uuml;gung, die einen kleinen Kostenbeitrag (6,25&euro;) f&uuml;r das Bestehen der Wertewirtschaft leisten (und daf&uuml;r die meisten Schriften kostenlos beziehen k&ouml;nnen). K&ouml;nnen Sie sich das leisten? Dann folgen Sie diesem Link und in K&uuml;rze erhalten Sie Zugriff auf unsere Schriften:&nbsp;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
        <a href="../upgrade.php"><button type="button" class="btn btn-primary">Jetzt upgraden</button></a>
      </div>
    </div>
  </div>
</div>


</div>
<?php include('_side_in.php'); ?>
</div>
<?php include('_footer.php'); ?>