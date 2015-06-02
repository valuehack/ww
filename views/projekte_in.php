<?php 
require_once('../classes/Login.php');
include ("_header_in.php"); 
$title="Projekte";

?>

<div class="content">

<?php 
if(isset($_POST['add'])){

  $add_id = $_POST['add'];
  $add_quantity = $_POST['quantity'];
  $add_code = $add_id . "0";
  if ($add_quantity==1) $wort = "wurde";
  else $wort = "wurden";
  echo "<div style='text-align:center'><hr><i>".$add_quantity." Credits für das ausgewählte Projekt ".$wort." in Ihren Korb gelegt.</i> &nbsp <a href='../abo/korb.php'>Zum Korb</a><hr><br></div>";

  if (isset($_SESSION['basket'][$add_id])) {
    $_SESSION['basket'][$add_code] += $add_quantity; 
  }
  else {
    $_SESSION['basket'][$add_code] = $add_quantity; 
  }
}


if ($id = $_GET["q"])
{
  $sql="SELECT * from produkte WHERE `type` LIKE 'projekt' AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry = mysql_fetch_array($result);
  $title=$entry[title];
  $avail=$entry[spots]-$entry[spots_sold];
  $text=$entry[text];
  $n = $entry[n];
?>
	<div class="medien_head">
 		<h1><?echo $title?></h1>
 	</div>
	<div class="medien_seperator">
		<h1>Inhalt und Informationen</h1>
	</div>
	<div class="medien_content">

<?php		
  	echo $text;

  if ($_SESSION['Mitgliedschaft'] == 1) { 
    ?>
    <div class="centered">
      	<!-- Button trigger modal -->
     	<input type="button" class="medien_inputbutton" value="Investieren" data-toggle="modal" data-target="#myModal"> 
    </div>
    <?php
    }
    else {
		echo $entry[spots_sold]." von ".$entry[spots]." möglichen Credits zugewiesen"; ?>

      <div class="centered">
      	<form class="projekte_invest" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        	<input type="hidden" name="add" value="<?php echo $n ?>" />
        	<input type="number" name="quantity" value="1" min="1" max="<?php echo $avail;?>">
        	<span>Credits</span>
        	<input type="submit" class="inputbutton" value="Zuweisen">
      	</form>
      </div>
      <div class="medien_anmeldung"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">zur&uuml;ck zu den Projekten</a></div>
    <?php
    }
	echo "</div>";
}

else {
  if ($_SESSION['Mitgliedschaft'] == 1) { 
    echo "<div class='medien_info'>";
    echo "<p>In der Wertewirtschaft finden Sie eine professionelle, seri&ouml;se und realistische Alternative, als B&uuml;rger in den langfristigen Bestand, die Entwicklung und das Gedeihen Ihrer Gesellschaft zu investieren. Ohne dieses b&uuml;rgerliche Engagement bliebe es bei der ewigen Polarisierung von Markt und Staat, die meist zugunsten der Gewalt entschieden wird. Wir &uuml;berlassen Ihnen aber freilich Ausma&szlig; und Verwendung Ihres Beitrages &ndash; bitte w&auml;hlen Sie jene Projekte aus, die Ihnen sinnvoll erscheinen. Je nach H&ouml;he Ihrer Investition profitieren Sie als Anerkennung Ihres Beitrages von den Angeboten der Wertewirtschaft.</p>";
    echo "</div>";
  }

  else {

  echo "<div class='medien_info'>";
  echo '<p>Wir bieten Ihnen durch unsere zahlreichen Angebote stets vollen Gegenwert f&uuml;r Ihre Unterst&uuml;tzung an. Eine wirkliche Unterst&uuml;tzung, die eine Ausweitung unserer T&auml;tigkeit erlaubt, wird es aber freilich erst, wenn Sie &ndash; so wie wir &ndash; einen gewissen Idealismus an den Tag legen und zumindest einen Teil Ihres Beitrages f&uuml;r Angebote widmen, die Ihnen nicht sofort, direkt und exklusiv zugute kommen, sondern Bausteine mit langfristiger Wirkung sind. In der Wertewirtschaft finden Sie eine professionelle, seri&ouml;se und realistische Alternative, als B&uuml;rger in den langfristigen Bestand, die Entwicklung und das Gedeihen Ihrer Gesellschaft zu investieren. Ohne dieses b&uuml;rgerliche Engagement bliebe es bei der ewigen Polarisierung von Markt und Staat, die meist zugunsten der Gewalt entschieden wird. Wir &uuml;berlassen Ihnen aber freilich Ausma&szlig; und Verwendung Ihres Beitrages &ndash; bitte w&auml;hlen Sie jene Projekte aus, die Ihnen sinnvoll erscheinen. Wenn Sie selbst einen gr&ouml;&szlig;eren Beitrag als en Restbetrag Ihres regelm&auml;&szlig;igen Guthabens investieren k&ouml;nnen und Projektvorschl&auml;ge haben, freuen wir uns &uuml;ber <a href="mailto:info@wertewirtschaft.org">Ihre Nachricht</a>. Ab einer Investition von 25.000&euro; k&ouml;nnen Sie Gesellschafter und damit Miteigent&uuml;mer unseres Unternehmens werden.</p>';
  echo '</div>';
  }
?>
	<div class="medien_seperator">
		<h1>Offene Projekte</h1>
	</div>
	<div class="medien_content">
<?php

$sql = "SELECT * from produkte WHERE `type` LIKE 'projekt' AND spots_sold < spots AND status > 0 order by n asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

  while($entry = mysql_fetch_array($result))
  {
    $id = $entry[id];
   ?>
	<div class="projekte">
		<h1><a href='?q=<?php echo $id;?>'><?php echo $entry[title];?></h1></a>
		<?php echo $entry[text]; ?>
		<div class="medien_anmeldung"><a href="?q=<?php echo $id;?>">weitere Informationen</a></div>
		<div class='centered'><p class='linie'><img src='../style/gfx/linie.png' alt=''></p></div>
 	</div>    
    <?php
    }
    ?>
</table>
</div>


<?php 
} 
?>
</div>

<!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title" id="myModalLabel">Investieren</h2>
          </div>
          <div class="modal-body">
            Spendenformular

            </div>
          <div class="modal-footer">
            <button type="button" class="inputbutton_white" data-dismiss="modal">Schließen</button>
          </div>
        </div>
      </div>
    </div>

<?php 
include "_footer.php"; 
?>