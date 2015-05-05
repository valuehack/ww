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

<h2>Schriften</h2>

<?php 
if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}

if(isset($_POST['add'])){

	$add_id = $_POST['add'];
	//$actual_quantity = $_SESSION['basket'][$add_id];
	$add_quantity = $_POST['quantity'];
	//$new_quantity = $add_quantity + $actual_quantity;
 	echo "<div style='text-align:center'><hr><i>You added ".$add_quantity." item(s) (ID: ".$add_id.") to your basket.</i> &nbsp <a href='../basket.php'>Go to Basket</a><hr><br></div>";

 	$_SESSION['basket'][$add_id] = $add_quantity; 
}

if ($_SESSION['Mitgliedschaft'] == 1) {
?>       
  <p>Erklärungstext zu Schriften...</p>     
<?
} ?>


<h5>Choose your books:</h5>

<div id="tabs-wrapper-sidebar"></div>

<table style="width:100%;border-collapse: collapse">

	<tr>
    	<td style="width:60%"><b>Titel</b></td>
   		<td style="width:20%"><b>Quantity</b></td>
	</tr>

<?php
$sql = "SELECT * from termine WHERE type LIKE 'Buch' OR type LIKE 'Scholien' order by title asc, id asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
	$event_id = $entry[id];
?>
   	<tr>
      	<td style="width:60%"><?php echo $event_id." <i>".ucfirst($entry[type])."</i> ".$entry[title]." ".$entry[author]." <i>".$entry[format]."</i>";?></a>
        <td style="width:20%">
          <?php
          if ($_SESSION['Mitgliedschaft'] == 1) {
          ?>
            <form>
              <select name="quantity">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>        
              </select> 
                <!-- Button trigger modal -->
                <input type="button" value="Add to Basket" data-toggle="modal" data-target="#myModal">  
            </form>
          <?php
          } 
          else {
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <input type="hidden" name="add" value="<?php echo $event_id; ?>" />
              <select name="quantity">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>        
              </select> 
              <input type="submit" value="Add to Basket">
            </form>
          <?php
          } ?>
        </td>
    </tr>

<?php
}

echo "</table><br><br>";

?>

<a href="../basket.php">Go to Basket</a>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Mitgliedschaft 75</h2>
      </div>
      <div class="modal-body">
        <p>Das Institut f&uuml;r Wertewirtschaft ist eine gemeinn&uuml;tzige Einrichtung, die sich durch einen besonders langfristigen Zugang auszeichnet. Um unsere Unabh&auml;ngigkeit zu bewahren, akzeptieren wir keinerlei Mittel, die aus unfreiwilligen Zahlungen (Steuern, Geb&uuml;hren, Zwangsmitgliedschaften etc.) stammen. Umso mehr sind wir auf freiwillige Investitionen angewiesen. Nur mit Ihrer Unterst&uuml;tzung k&ouml;nnen wir unsere Arbeit aufrecht erhalten oder ausweiten.</p>

<p><b>Warum in das Institut f&uuml;r Wertewirtschaft investieren?</b></p>

<p> Wo gibt es sonst noch vollkommen unabh&auml;ngige Universalgelehrte, die im Wahnsinn der Gegenwart den &Uuml;berblick bewahren und den Verlockungen von Macht und Geld widerstehen? Einst hatten Universit&auml;ten diese Aufgabe, doch sind diese l&auml;ngst durch die Politik korrumpiert und im Kern zerst&ouml;rt.  Jeder rationale Anleger sollte ebenso in die Institutionen investieren, die f&uuml;r eine freie und wohlhabende Gesellschaft unverzichtbar sind. Ohne Menschen, die ihr Leben der Erkenntnis widmen, sind den Illusionen, die zu Unfreiheit und Versklavung f&uuml;hren, keine Grenzen gesetzt.  Das Institut f&uuml;r Wertewirtschaft ist, obwohl wir wenig pragmatisch sind, wohl eines der effizientesten Institute weltweit. Wir leisten mehr als Einrichtungen, die das Hundertfache unseres Budgets aufweisen. Durch gro&szlig;en pers&ouml;nlichen Einsatz , &auml;u&szlig;erst sparsames Management und unternehmerische Einstellung k&ouml;nnen wir auch mit geringen Betr&auml;gen gro&szlig;en Mehrwert schaffen.  Eine Gesellschaft, in der nahezu die gesamte Bildung und Forschung in staatlicher Hand liegt, befindet sich auf direktem Weg in den Totalitarismus. Sagen Sie nachher nicht, wir h&auml;tten Sie nicht gewarnt.  Warnung: Wir k&ouml;nnen nat&uuml;rlich auch keine Wunder vollbringen (wiewohl wir uns oft wundern, was uns alles trotz unser knappen Mittel gelingt). Wir sind keinesfalls geneigt, uns in irgendeiner Form f&uuml;r Geldmittel zu verbiegen. Wenn Sie in unsere Arbeit investieren, dann tun Sie das, weil Sie unsere Selbst&auml;ndigkeit und Unkorrumpierbarkeit sch&auml;tzen. Finanzmittel sind nur eine Zutat, und keinesfalls die Wichtigste. Wir bitten Sie darum, weil materielle Unabh&auml;ngigkeit die Voraussetzung unserer Arbeit ist - und diese Unabh&auml;ngigkeit k&ouml;nnen wir nur durch eine Vielfalt an Stiftern erreichen.</p>

<p><b>Ihre Vorteile:</b></p>

<p> Deutliche Erm&auml;&szlig;igungen bei unseren Akademie-Veranstaltungen (schon bei wenigen Besuchen bringt Ihnen die Mitgliedschaft einen finanziellen Vorteil)  Erm&auml;&szlig;igter Eintritt zu unseren Salon-Veranstaltungen (Video&uuml;bertragung f&uuml;r ausw&auml;rtige Mitglieder)  Abonnement der Scholien inkludiert  Wachsende Zahl exklusiver Inhalte (Audio/Video)  Nutzung der Bibliothek, B&uuml;cherleihe  F&ouml;rderer:  F&ouml;rderer leisten einen regelm&auml;&szlig;igen Beitrag, der &uuml;ber die Kosten hinausgeht, um uns bei unserer Arbeit zu ermutigen und zu unterst&uuml;tzen. Daf&uuml;r sind sie etwas mehr in unser Institut eingebunden und erhalten zus&auml;tzlich zu den Mitgliedschaftsvorteilen:  Hintergrundinformationen zu unserer Arbeit  Einladung zu exklusiven Veranstaltungen  Ihre Begleitung erh&auml;lt den Mitgliedertarif bei unseren Veranstaltungen  ab 300 &euro; Beitrag: Zusendung signierter Exemplare aller Bucherscheinungen und sonstiger Publikationen </p>
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