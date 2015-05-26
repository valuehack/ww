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
$title="Kurse";

?>

<div id="center">  
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a><a class="content" href="index.php"> Kurse</a>
<div id="tabs-wrapper-lower"></div>

<?php 
if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}

if(isset($_POST['add'])){

  $add_id = $_POST['add'];
  $add_quantity = $_POST['quantity'];
  $add_code = $add_id . "0";
  echo "<div style='text-align:center'><hr><i>You added ".$add_quantity." item(s) (ID: ".$add_id.") to your basket.</i> &nbsp <a href='../abo/korb.php'>Go to Basket</a><hr><br></div>";

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
  $sql="SELECT * from produkte WHERE (type='lehrgang' or type='seminar' or type='kurs') AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  $n = $entry3[n];
?>
  
  <h3 style="font-style:none;"><?=ucfirst($entry3[type])." ".$entry3[title]?></h3>

  <p><? if ($entry3[img]) echo $entry3[img]; ?>

  <b>Termin:</b> 
  <? 
  /* weekdays don't work
    $day=date("w",strtotime($entry3[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */
    echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry3[start]));
  
  if ($entry3[text]) echo "<p>$entry3[text]</p>";
  if ($entry3[text2]) echo "<p>$entry3[text2]</p>";

  echo "<hr><p>Unsere Kurse inmitten unserer einzigartigen Bibliothek bieten inhaltliche Vertiefungen abseits des Mainstream-Lehrbetriebs. Wir folgen dabei dem Beispiel der klassischen Akademie &ndash; der Bibliothek im Hain der Mu&szlig;e fern vom Wahnsinn der Zeit, in der Freundschaften durch regen Austausch und gemeinsames Nachdenken gestiftet werden. Alle unsere Lehrangebote zeichnen sich durch geb&uuml;hrende Tiefe bei gleichzeitiger Verst&auml;ndlichkeit, kleine Gruppen und gro&szlig;en Freiraum f&uuml;r Fragen und Diskussionen aus. Tauchen Sie mit uns in intellektuelle Abenteuer, wie sie unsere Zeit kaum noch zul&auml;&szlig;t.</p>";

  if ($_SESSION['Mitgliedschaft'] == 1) {
    echo "Platzhalter Anmeldeformular";
    }

  if ($_SESSION['Mitgliedschaft'] == 2) {
    echo "Platzhalter Upgrade";  
    } 
  
  if ($_SESSION['Mitgliedschaft'] > 2) {
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />
      Menge: <select name="quantity">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>        
      </select>
      <input type="submit" value="Reservieren">&nbsp;<i><?php echo $entry3[price]; ?> Credits pro Reservierung</i>
    </form>
  <?php
  }
}

else {
  
  echo "<h2>Kurse</h2>";

  if ($_SESSION['Mitgliedschaft'] == 1 || $_SESSION['Mitgliedschaft'] == 2) {
  ?>
         
    <p>Unsere Kurse inmitten unserer einzigartigen Bibliothek bieten inhaltliche Vertiefungen abseits des Mainstream-Lehrbetriebs. Wir folgen dabei dem Beispiel der klassischen Akademie &ndash; der Bibliothek im Hain der Mu&szlig;e fern vom Wahnsinn der Zeit, in der Freundschaften durch regen Austausch und gemeinsames Nachdenken gestiftet werden. Alle unsere Lehrangebote zeichnen sich durch geb&uuml;hrende Tiefe bei gleichzeitiger Verst&auml;ndlichkeit, kleine Gruppen und gro&szlig;en Freiraum f&uuml;r Fragen und Diskussionen aus. Tauchen Sie mit uns in intellektuelle Abenteuer, wie sie unsere Zeit kaum noch zul&auml;&szlig;t.</p>
 
  <?
  } ?>

  <h5>Termine</h5>
             
  <div id="tabs-wrapper-sidebar"></div>

  <?php
  $current_dateline=strtotime(date("Y-m-d"));
  
  $sql="SELECT * from produkte WHERE (UNIX_TIMESTAMP(start)>=$current_dateline) and (type='lehrgang' or type='seminar' or type='kurs') and status>0 order by start asc, n asc";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  
  while($entry = mysql_fetch_array($result))
  {
    $found=1;
    $id = $entry[id];
    echo "<div class=\"entry\">";
    echo "<h1>";
    echo "<a href='?q=$id'>";
    echo ucfirst($entry[type])." ".$entry[title]."</a></h1>";
     
    echo "<div style=\"padding:5px;\">";
    /* weekdays don't work:
    $day=date("w",strtotime($entry[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */
    echo date("d.m.Y",strtotime($entry[start]));
    
    
    echo "<p>";
    if ($entry[img]) echo $entry[img];
    echo $entry[text];
    echo " <a href='?q=$id'>";
    echo "&rarr; N&auml;here Informationen</a></p>";
    echo "</div></div>";

  } 
} 

?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Mitgliedschaft 150</h2>
      </div>
      <div class="modal-body">
        Erklärung 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
        <a href="../upgrade.php"><button type="button" class="btn btn-primary">Jetzt upgraden</button></a>
      </div>
    </div>
  </div>
</div>


<div id="tabs-wrapper-lower" style="margin-top:10px;"></div>


</div>
<?php include('_side_in.php'); ?>
</div>
<?php include('_footer.php'); ?>