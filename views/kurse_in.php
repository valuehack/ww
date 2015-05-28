<?php 
require_once('../classes/Login.php');
include('_header_in.php'); 
$title="Kurse";

?>

<div class="content">
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

    	//check, if there is a image in the salon folder
	$img = 'http://test.wertewirtschaft.net/salon/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/salon/default.jpg";
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
  	<div class="salon_head">
 	 	<h1><?=ucfirst($entry3[type])." ".$entry3[title]?></h1>
  		<p class="salon_date">
  			<?  if ($entry3[start] != NULL && $entry3[end] != NULL)
    {
    $tag=date("w",strtotime($entry3[start]));
    $tage = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
    echo $tage[$tag].", ";
    echo strftime("%d.%m.%Y, %H:%M Uhr", strtotime($entry3[start]))." &ndash; ";
    if (strftime("%d.%m.%Y", strtotime($entry3[start]))!=strftime("%d.%m.%Y", strtotime($entry3[end])))
      {
      $tag=date("w",strtotime($entry3[end]));
      echo $tage[$tag].", ";
      echo strftime("%d.%m.%Y, %H:%M Uhr", strtotime($entry3[end]));
      }
    else echo strftime("%H:%M Uhr", strtotime($entry3[end]));
  }
  elseif ($entry3[start]!= NULL)
    {
    $tag=date("w",strtotime($entry3[start]));
    echo $tage[$tag].", ";
    echo strftime("%d.%m.%Y", strtotime($entry3[start]));
  }
  else echo "Der Termin wird in k&uuml;rze bekannt gegeben";?>
  			</p>
		<!--<img src="<?echo $img_url;?>" alt="<? echo $id;?>">-->
		
		<div class="centered">
			<div class="salon_reservation">
				<?	
  if ($_SESSION['Mitgliedschaft'] == 1) {
    echo '<input class="salon_reservation_inputbutton" type="button" value="Anmelden" data-toggle="modal" data-target="#myModal1">';
    }

  if ($_SESSION['Mitgliedschaft'] == 2) {
    echo '<input class="salon_reservation_inputbutton" type="button" value="Upgrade" data-toggle="modal" data-target="#myModal2">';  
    } 
  
  if ($_SESSION['Mitgliedschaft'] > 2) {
    ?>
	<span class="salon_reservation_span_a">Anzahl gew&uuml;nschter Teilnehmer</span><br>
    <form class="salon_reservation_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />      
      <select name="quantity">
      	<option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>        
      </select> 
      <input class="inputbutton" type="submit" value="Auswählen"><br>     
    </form>
	<span class="salon_reservation_span_b"><?php echo $entry3[price]; ?> Credits pro Teilnehmer</span>
  <?php
  }
?>
			</div>
		</div>		
	</div>
	<div class="salon_seperator">
		<h1>Inhalt und Informationen</h1>
	</div>
	<div class="salon_content">
  <? 
  /* weekdays don't work
    $day=date("w",strtotime($entry3[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */
    
  if ($entry3[text]) echo "<p>$entry3[text]</p>";
  if ($entry3[text2]) echo "<p>$entry3[text2]</p>";
?>
		<p>Unsere Kurse inmitten unserer einzigartigen Bibliothek bieten inhaltliche Vertiefungen abseits des Mainstream-Lehrbetriebs. Wir folgen dabei dem Beispiel der klassischen Akademie &ndash; der Bibliothek im Hain der Mu&szlig;e fern vom Wahnsinn der Zeit, in der Freundschaften durch regen Austausch und gemeinsames Nachdenken gestiftet werden. Alle unsere Lehrangebote zeichnen sich durch geb&uuml;hrende Tiefe bei gleichzeitiger Verst&auml;ndlichkeit, kleine Gruppen und gro&szlig;en Freiraum f&uuml;r Fragen und Diskussionen aus. Tauchen Sie mit uns in intellektuelle Abenteuer, wie sie unsere Zeit kaum noch zul&auml;&szlig;t.</p>
	</div>
	
<?php
}
  else { 
  if ($_SESSION['Mitgliedschaft'] == 1 || $_SESSION['Mitgliedschaft'] == 2) {
  ?>
    <div class="salon_info">    
    	<p>Unsere Kurse inmitten unserer einzigartigen Bibliothek bieten inhaltliche Vertiefungen abseits des Mainstream-Lehrbetriebs. Wir folgen dabei dem Beispiel der klassischen Akademie &ndash; der Bibliothek im Hain der Mu&szlig;e fern vom Wahnsinn der Zeit, in der Freundschaften durch regen Austausch und gemeinsames Nachdenken gestiftet werden. Alle unsere Lehrangebote zeichnen sich durch geb&uuml;hrende Tiefe bei gleichzeitiger Verst&auml;ndlichkeit, kleine Gruppen und gro&szlig;en Freiraum f&uuml;r Fragen und Diskussionen aus. Tauchen Sie mit uns in intellektuelle Abenteuer, wie sie unsere Zeit kaum noch zul&auml;&szlig;t.</p>
    </div> 
    <div class="salon_seperator">
    	<h1>Termine</h1>
   	</div>    
 	<div class="salon_content">
  <?
  } 
  
  $current_dateline=strtotime(date("Y-m-d"));
  
  $sql="SELECT * from produkte WHERE (UNIX_TIMESTAMP(start)>=$current_dateline) and (type='lehrgang' or type='seminar' or type='kurs') and status>0 order by start asc, n asc";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  
  while($entry = mysql_fetch_array($result))
  {
    $found=1;
    $id = $entry[id];
    echo "<h1>";
    echo "<a href='?q=$id'>";
    echo ucfirst($entry[type])." ".$entry[title]."</a></h1>";
     
    echo "<div class='salon_dates'>";
    /* weekdays don't work:
    $day=date("w",strtotime($entry[start]));
    if ($day==0) $day=7;
    echo Phrase('day'.$day).", ";
    */
    echo date("d.m.Y",strtotime($entry[start]));
    echo " %ndash; ";
    echo date("d.m.Y",strtotime($entry3[end]));
    echo "</div>";
    echo "<p>";
    //echo "<img src='$img_url' alt='$id'>";
    echo $entry[text];
    echo "<div class='salon_anmeldung'><a href='?q=$id'>zur Anmeldung</a></div>";
	echo "<div class='centered'><p class='linie'><img src='../style/gfx/linie.png' alt=''></p></div>";
	echo "</div>";
  } 
} 

?>

	</div>

<!-- Modal 1 - Mitgliedschaft == 1 -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Mitgliedschaft 150 - Anmelden</h2>
      </div>
      <div class="modal-body">
        Erklärung 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
        <a href="../upgrade.php"><button type="button" class="btn btn-primary">Anmelden</button></a>
      </div>
    </div>
  </div>
</div>

<!-- Modal 2 - Mitgliedschaft == 2 -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<?php include('_footer.php'); ?>