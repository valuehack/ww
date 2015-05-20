<!-- Bootstrap -->
<link href="../style/modal.css" rel="stylesheet">

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../tools/bootstrap.js"></script>

<?php 
require_once('../classes/Login.php');
include ("_header.php"); 
$title="Projekte";

?>

<!--Content-->
<div id="center">
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a> <a class="content" href="index.php">Projekte</a>
<div id="tabs-wrapper-lower"></div>


<?php 
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


if ($id = $_GET["id"])
{
  $sql="SELECT * from produkte WHERE `type` LIKE 'projekt' AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry = mysql_fetch_array($result);
  $title=$entry[title];
  $avail=$entry[spots]-$entry[spots_sold];
  $text=$entry[text];
  $n = $entry[n];

  echo '<h3>'.$title.'</h3>';

  echo "<p>".$text."</p>";

  if ($_SESSION['Mitgliedschaft'] == 1) { 
    ?>
      <!-- Button trigger modal -->
     <input type="button" value="Investieren" data-toggle="modal" data-target="#myModal"> 

    
    <?php
    }
    else {
      ?>
      <i><?php echo $entry[spots_sold]." von ".$entry[spots]." möglichen Credits zugewiesen"; ?></i><br>

      <div><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <i>Credits: </i>
        <input type="hidden" name="add" value="<?php echo $n ?>" />
        <input type="number" name="quantity" style="width:50px;" value="1" min="1" max="<?php echo $avail;?>">
        <input type="submit" value="Add to Basket">
      </form></div>
    <?php
    }

}

else {

  echo "<h2>Projekte</h2>";  

  if ($_SESSION['Mitgliedschaft'] == 1) { 
    echo "<div>";
    echo "<p>In der Wertewirtschaft finden Sie eine professionelle, seri&ouml;se und realistische Alternative, als B&uuml;rger in den langfristigen Bestand, die Entwicklung und das Gedeihen Ihrer Gesellschaft zu investieren. Ohne dieses b&uuml;rgerliche Engagement bliebe es bei der ewigen Polarisierung von Markt und Staat, die meist zugunsten der Gewalt entschieden wird. Wir &uuml;berlassen Ihnen aber freilich Ausma&szlig; und Verwendung Ihres Beitrages &ndash; bitte w&auml;hlen Sie jene Projekte aus, die Ihnen sinnvoll erscheinen. Je nach H&ouml;he Ihrer Investition profitieren Sie als Anerkennung Ihres Beitrages von den Angeboten der Wertewirtschaft.</p>";
    echo '</div><div id="tabs-wrapper-sidebar"></div>';
  }

  else {

  echo "<div>";
  echo '<p>Wir bieten Ihnen durch unsere zahlreichen Angebote stets vollen Gegenwert f&uuml;r Ihre Unterst&uuml;tzung an. Eine wirkliche Unterst&uuml;tzung, die eine Ausweitung unserer T&auml;tigkeit erlaubt, wird es aber freilich erst, wenn Sie &ndash; so wie wir &ndash; einen gewissen Idealismus an den Tag legen und zumindest einen Teil Ihres Beitrages f&uuml;r Angebote widmen, die Ihnen nicht sofort, direkt und exklusiv zugute kommen, sondern Bausteine mit langfristiger Wirkung sind. In der Wertewirtschaft finden Sie eine professionelle, seri&ouml;se und realistische Alternative, als B&uuml;rger in den langfristigen Bestand, die Entwicklung und das Gedeihen Ihrer Gesellschaft zu investieren. Ohne dieses b&uuml;rgerliche Engagement bliebe es bei der ewigen Polarisierung von Markt und Staat, die meist zugunsten der Gewalt entschieden wird. Wir &uuml;berlassen Ihnen aber freilich Ausma&szlig; und Verwendung Ihres Beitrages &ndash; bitte w&auml;hlen Sie jene Projekte aus, die Ihnen sinnvoll erscheinen. Wenn Sie selbst einen gr&ouml;&szlig;eren Beitrag als en Restbetrag Ihres regelm&auml;&szlig;igen Guthabens investieren k&ouml;nnen und Projektvorschl&auml;ge haben, freuen wir uns &uuml;ber <a href="mailto:info@wertewirtschaft.org">Ihre Nachricht</a>. Ab einer Investition von 25.000&euro; k&ouml;nnen Sie Gesellschafter und damit Miteigent&uuml;mer unseres Unternehmens werden.</p>';
  echo '</div><div id="tabs-wrapper-sidebar"></div>';
  }


$sql = "SELECT * from produkte WHERE `type` LIKE 'projekt' AND spots_sold < spots AND status > 0 order by n asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

?>
<br>

<table style="width:100%;border-collapse: collapse">


<?php

  while($entry = mysql_fetch_array($result))
  {
    $id = $entry[id];
   ?>

    <tr>
        <td class="bottomline"><a href='?id=<?php echo $id;?>'><b><?php echo $entry[title];?></b></a>
    </tr>
    <tr>
        <td><?php echo $entry[text]; ?></td>
    </tr>      
    <tr><td>&nbsp;</td><td></td></tr>
    
    <?php
    }
    ?>
</table>



<?php 
} 
?>

<br><br><br><br><br><br><br><br><br>

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
            <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
          </div>
        </div>
      </div>
    </div>


</div>
<?php include "_side_in.php"; ?>
</div>


<?php 
include "_footer.php"; 
?>
