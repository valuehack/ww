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
$title="Seminare";

?>

<div id="center">  
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a><a class="content" href="<?php echo $_SERVER['PHP_SELF']; ?>"> Seminare</a>
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
 	echo "<div style='text-align:center'><hr><i>You added ".$add_quantity." item(s) (ID: ".$add_id.") to your basket.</i> &nbsp <a href='../basket.php'>Go to Basket</a><hr><br></div>";

 	$_SESSION['basket'][$add_id] = $add_quantity; 
}


if(isset($_GET['id']))
{
  $id = $_GET['id'];

  //Termindetails
  $sql="SELECT * from termine WHERE id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  $title=$entry3[title];
  $avail=$entry3[spots]-$entry3[spots_sold];
  $gold=$entry3[gold];
  $gold2=$entry3[gold2];
  $adresse=$entry3[adresse];
  $date=strftime("%d.%m.%Y", strtotime($entry3[start]));
  $date2= substr($entry3[start],0,10);
?>
  
  <h3 style="font-style:none;"><?=ucfirst($entry3[type])." ".$entry3[title]?></h3>

  <p><? if ($entry3[img]) echo $entry3[img]; ?>

  <b>Ort:</b> <? if ($entry3[adresse]) echo $entry3[adresse]; else echo $entry3[location]; ?><br>
  <b>Termin:</b> 
  <? 
  if ($entry3[start]!="0000-00-00"&&$entry3[start]!=$entry3[end])
  {
    /* weekdays don't work
    $day=date("w",strtotime($entry3[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */
    echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry3[start]))." - ";
    if (strftime("%d.%m.%Y", strtotime($entry3[start]))!=strftime("%d.%m.%Y", strtotime($entry3[end])))
      {
      /*  
      $day=date("w",strtotime($entry3[end]));
      if ($day==0) $day=7;
      echo Phrase('day'.$day).", ";
      */
      echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry3[end]));
      }
    else echo strftime("%H:%M Uhr", strtotime($entry3[end]));
  }
  elseif ($entry3[start]!="0000-00-00")
    {
    /*
    $day=date("w",strtotime($entry3[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */
    echo strftime("%d.%m.%Y", strtotime($entry3[start]));
    }
  else echo "noch offen";
  
  if ($entry3[text]) echo "<p>$entry3[text]</p>";
  if ($entry3[text2]) echo "<p>$entry3[text2]</p>";

  if ($_SESSION['Mitgliedschaft'] == 1 || $_SESSION['Mitgliedschaft'] == 4) {
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
      <input type="hidden" name="add" value="<?php echo $id; ?>" />
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
  }
}

else {
  
  echo "<h2>Seminare</h2>";

  if ($_SESSION['Mitgliedschaft'] == 1 || $_SESSION['Mitgliedschaft'] == 4) {
  ?>
    <p><img class="wallimg big" src="akademie.jpg" alt="" titel="Akademieveranstaltung"></p>
         
    <p>Unsere Akademie inmitten unserer einzigartigen <a href="../institut/ort.php">Bibliothek</a> bietet inhaltliche Vertiefungen abseits des Mainstream-Lehrbetriebs. Wir folgen dabei dem Beispiel der klassischen Akademie - der Bibliothek im Hain der Mu&szlig;e fern vom Wahnsinn der Zeit, in der Freundschaften durch regen Austausch und gemeinsames Nachdenken gestiftet werden. Alle unsere Lehrangebote zeichnen sich durch geb&uuml;hrende Tiefe bei gleichzeitiger Verst&auml;ndlichkeit, kleine Gruppen und gro&szlig;en Freiraum f&uuml;r Fragen und Diskussionen aus. F&uuml;r Teilnehmer aus der Ferne bieten wir interaktive Fernkurse auf h&ouml;chstem technischen Niveau an, soda&szlig; diese &quot;live&quot; dabei sein k&ouml;nnen. Tauchen Sie mit uns in intellektuelle Abenteuer, wie sie unsere Zeit kaum noch zul&auml;&szlig;t.</p>    
   
  <?
  } ?>

  <h5>Termine</h5>
             
  <div id="tabs-wrapper-sidebar"></div>

  <?php
  $current_dateline=strtotime(date("Y-m-d"));
  
  $sql="SELECT * from termine WHERE (UNIX_TIMESTAMP(end)>=$current_dateline) and (type='lehrgang' or type='seminare' or type='akademie' or type='seminar' or type='Symposion' or type='Seminar' or type='Lehrgang') and status>0 order by start asc, id asc";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  
  while($entry = mysql_fetch_array($result))
  {
    $found=1;
    $id = $entry[id];
    echo "<div class=\"entry\">";
    echo "<h1>";
    echo "<a href='?id=$id'>";
    echo ucfirst($entry[type])." $entry[title]</a></h1>";
     
    echo "<div style=\"padding:5px;\">";
    /* weekdays don't work:
    $day=date("w",strtotime($entry[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */
    echo date("d.m.Y",strtotime($entry[start]));
    
    if (strtotime($entry[end])>(strtotime($entry[start])+86400))
      {
      echo " - ";
      /*
      $day=date("w",strtotime($entry[end]));
      if ($day==0) $day=7;
      echo Phrase('day'.$day).", ";
      */
      echo date("d.m.Y",strtotime($entry[end]));
      }
    echo ", $entry[location]</div>";
    
    echo "<p>";
    if ($entry[img]) echo $entry[img];
    echo $entry[text];
    echo " <a href='?id=$id'>";
    echo "&rarr; N&auml;here Informationen</a></p>";
    
    if ($_SESSION['Mitgliedschaft'] == 1 || $_SESSION['Mitgliedschaft'] == 4) {
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
      </div>
<?php
    } 
    else {
      ?>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="add" value="<?php echo $id; ?>" />
        <select name="quantity">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>        
        </select> 
        <input type="submit" value="Add to Basket">
      </form>
      </div>
<?php
    } 


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
        <p>Das Institut f&uuml;r Wertewirtschaft ist eine gemeinn&uuml;tzige Einrichtung, die sich durch einen besonders langfristigen Zugang auszeichnet. Um unsere Unabh&auml;ngigkeit zu bewahren, akzeptieren wir keinerlei Mittel, die aus unfreiwilligen Zahlungen (Steuern, Geb&uuml;hren, Zwangsmitgliedschaften etc.) stammen. Umso mehr sind wir auf freiwillige Investitionen angewiesen. Nur mit Ihrer Unterst&uuml;tzung k&ouml;nnen wir unsere Arbeit aufrecht erhalten oder ausweiten.</p>

<p><b>Warum in das Institut f&uuml;r Wertewirtschaft investieren?</b></p>

<p> Wo gibt es sonst noch vollkommen unabh&auml;ngige Universalgelehrte, die im Wahnsinn der Gegenwart den &Uuml;berblick bewahren und den Verlockungen von Macht und Geld widerstehen? Einst hatten Universit&auml;ten diese Aufgabe, doch sind diese l&auml;ngst durch die Politik korrumpiert und im Kern zerst&ouml;rt.  Jeder rationale Anleger sollte ebenso in die Institutionen investieren, die f&uuml;r eine freie und wohlhabende Gesellschaft unverzichtbar sind. Ohne Menschen, die ihr Leben der Erkenntnis widmen, sind den Illusionen, die zu Unfreiheit und Versklavung f&uuml;hren, keine Grenzen gesetzt.  Das Institut f&uuml;r Wertewirtschaft ist, obwohl wir wenig pragmatisch sind, wohl eines der effizientesten Institute weltweit. Wir leisten mehr als Einrichtungen, die das Hundertfache unseres Budgets aufweisen. Durch gro&szlig;en pers&ouml;nlichen Einsatz , &auml;u&szlig;erst sparsames Management und unternehmerische Einstellung k&ouml;nnen wir auch mit geringen Betr&auml;gen gro&szlig;en Mehrwert schaffen.  Eine Gesellschaft, in der nahezu die gesamte Bildung und Forschung in staatlicher Hand liegt, befindet sich auf direktem Weg in den Totalitarismus. Sagen Sie nachher nicht, wir h&auml;tten Sie nicht gewarnt.  Warnung: Wir k&ouml;nnen nat&uuml;rlich auch keine Wunder vollbringen (wiewohl wir uns oft wundern, was uns alles trotz unser knappen Mittel gelingt). Wir sind keinesfalls geneigt, uns in irgendeiner Form f&uuml;r Geldmittel zu verbiegen. Wenn Sie in unsere Arbeit investieren, dann tun Sie das, weil Sie unsere Selbst&auml;ndigkeit und Unkorrumpierbarkeit sch&auml;tzen. Finanzmittel sind nur eine Zutat, und keinesfalls die Wichtigste. Wir bitten Sie darum, weil materielle Unabh&auml;ngigkeit die Voraussetzung unserer Arbeit ist - und diese Unabh&auml;ngigkeit k&ouml;nnen wir nur durch eine Vielfalt an Stiftern erreichen.</p>

<p><b>Ihre Vorteile:</b></p>

<p> Deutliche Erm&auml;&szlig;igungen bei unseren Akademie-Veranstaltungen (schon bei wenigen Besuchen bringt Ihnen die Mitgliedschaft einen finanziellen Vorteil)  Erm&auml;&szlig;igter Eintritt zu unseren Salon-Veranstaltungen (Video&uuml;bertragung f&uuml;r ausw&auml;rtige Mitglieder)  Abonnement der Scholien inkludiert  Wachsende Zahl exklusiver Inhalte (Audio/Video)  Nutzung der Bibliothek, B&uuml;cherleihe  F&ouml;rderer:  F&ouml;rderer leisten einen regelm&auml;&szlig;igen Beitrag, der &uuml;ber die Kosten hinausgeht, um uns bei unserer Arbeit zu ermutigen und zu unterst&uuml;tzen. Daf&uuml;r sind sie etwas mehr in unser Institut eingebunden und erhalten zus&auml;tzlich zu den Mitgliedschaftsvorteilen:  Hintergrundinformationen zu unserer Arbeit  Einladung zu exklusiven Veranstaltungen  Ihre Begleitung erh&auml;lt den Mitgliedertarif bei unseren Veranstaltungen  ab 300 &euro; Beitrag: Zusendung signierter Exemplare aller Bucherscheinungen und sonstiger Publikationen </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
        <a href="../edit.php"><button type="button" class="btn btn-primary">Jetzt upgraden</button></a>
      </div>
    </div>
  </div>
</div>


<div id="tabs-wrapper-lower" style="margin-top:10px;"></div>


</div>
<?php include('_side_in.php'); ?>
</div>
<?php include('_footer.php'); ?>