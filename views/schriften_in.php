<!-- Bootstrap -->
<link href="../style/modal.css" rel="stylesheet">

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../tools/bootstrap.js"></script>

<script>
function changeView(price, price2) {
    var x = document.getElementById("change").value;

    if (x == 4) {    
      document.getElementById("quantity").innerHTML = 'Menge: <input type="number" name="quantity" style="width:35px;" value="1" min="1" max="100">';
      document.getElementById("price").innerHTML = price2 + " Credits pro St&uuml;ck";
    }
    else {
      document.getElementById("quantity").innerHTML = '<input type="hidden" name="quantity" value="1" />';
      document.getElementById("price").innerHTML = price + " Credits";
    }
}
</script>


<?php 
//Author: Bernhard Hegyi

require_once('../classes/Login.php');
include('_header.php'); 
$title="Schriften";

?>

<div id="center">  
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a><a class="content" href="index.php"> Schriften</a>
<div id="tabs-wrapper-lower"></div>


<?php 
if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}

if(isset($_POST['add'])){

	$add_id = $_POST['add'];
  $add_quantity = $_POST['quantity'];
  $add_format = $_POST['format'];
  $add_code = $add_id . $add_format;
 	echo "<div style='text-align:center'><hr><i>You added ".$add_quantity." item(s) (ID: ".$add_id." Format: ".$add_format.") to your basket.</i> &nbsp <a href='../abo/korb.php'>Go to Basket</a><hr><br></div>";

 	if (isset($_SESSION['basket'][$add_id])) {
    $_SESSION['basket'][$add_code] += $add_quantity; 
  }
  else {
    $_SESSION['basket'][$add_code] = $add_quantity; 
  }
}


if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Termindetails
  $sql="SELECT * from produkte WHERE (type LIKE 'buch' OR type LIKE 'scholien' OR type LIKE 'analyse') AND id='$id'";
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
    $pdf = substr($entry3[format],0,1);
    $epub = substr($entry3[format],1,1);
    $kindle = substr($entry3[format],2,1);
    $druck = substr($entry3[format],3,1);

    $price = $entry3[price];
    $price2 = $entry3[price2];

    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />
      <span id="quantity"><input type="hidden" name="quantity" value="1" /></span>
      Format: <select name="format" id="change" onchange="changeView(<?php echo $price; ?>, <?php echo $price2; ?>)">
        <?php
        if ($pdf == 1) echo '<option value="1">PDF</option>';
        if ($epub == 1) echo '<option value="2">ePub</option>';
        if ($kindle == 1) echo '<option value="3">Kindle</option>';
        if ($druck == 1) echo '<option value="4">Druck</option>';   
         ?>
      </select>
      
      <input type="submit" value="Auswählen">&nbsp;&nbsp;<i><span id="price"><?echo $entry3[price]?> Credits</span></i>
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
      <td><b>Titel</b></td>
      
  </tr>

<?php
$sql = "SELECT * from produkte WHERE (type LIKE 'buch' OR type LIKE 'scholien' OR type LIKE 'analyse') AND status > 0 order by title asc, n asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
  $id = $entry[id];
?>
    <tr>
        <td>
          <?php 
          echo "<a href='?q=$id'><i>".ucfirst($entry[type])."</i> ".$entry[title];

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