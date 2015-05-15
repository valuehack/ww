
<?php 
require_once('../classes/Login.php');
include ("_header.php"); 
$title="Spenden";

/* Single page view??
if ($id = $_GET["id"])
{
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
}
*/
?>

<!--Content-->
<div id="center">
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a> <a class="content" href="index.php">Spenden</a>
<div id="tabs-wrapper-lower"></div>

<h2>Spenden</h2>  

<?php if (!$_SESSION['Mitgliedschaft'] == 1) { 

echo "<div>";
echo '<p>Wir bieten Ihnen durch unsere zahlreichen Angebote stets vollen Gegenwert f&uuml;r Ihre Unterst&uuml;tzung an. Eine wirkliche Unterst&uuml;tzung, die eine Ausweitung unserer T&auml;tigkeit erlaubt, wird es aber freilich erst, wenn Sie &ndash; so wie wir &ndash; einen gewissen Idealismus an den Tag legen und zumindest einen Teil Ihres Beitrages f&uuml;r Angebote widmen, die Ihnen nicht sofort, direkt und exklusiv zugute kommen, sondern Bausteine mit langfristiger Wirkung sind. In der Wertewirtschaft finden Sie eine professionelle, seri&ouml;se und realistische Alternative, als B&uuml;rger in den langfristigen Bestand, die Entwicklung und das Gedeihen Ihrer Gesellschaft zu investieren. Ohne dieses b&uuml;rgerliche Engagement bliebe es bei der ewigen Polarisierung von Markt und Staat, die meist zugunsten der Gewalt entschieden wird. Wir &uuml;berlassen Ihnen aber freilich Ausma&szlig; und Verwendung Ihres Beitrages &ndash; bitte w&auml;hlen Sie jene Projekte aus, die Ihnen sinnvoll erscheinen. Wenn Sie selbst einen gr&ouml;&szlig;eren Beitrag als en Restbetrag Ihres regelm&auml;&szlig;igen Guthabens investieren k&ouml;nnen und Projektvorschl&auml;ge haben, freuen wir uns &uuml;ber <a href="mailto:info@wertewirtschaft.org">Ihre Nachricht</a>. Ab einer Investition von 25.000&euro; k&ouml;nnen Sie Gesellschafter und damit Miteigent&uuml;mer unseres Unternehmens werden.</p>';
echo "</div>";


if(isset($_POST['add'])){

  $add_id = $_POST['add'];
  //$actual_quantity = $_SESSION['basket'][$add_id];
  $add_quantity = $_POST['quantity'];
  //$new_quantity = $add_quantity + $actual_quantity;
  echo "<div style='text-align:center'><hr><i>You added the project (ID: ".$add_id.", Credits: ".$add_quantity.") to your basket.</i> &nbsp <a href='basket.php'>Go to Basket</a><hr><br></div>";

  $_SESSION['basket'][$add_id] = $add_quantity; 
}


$sql = "SELECT * from termine WHERE `type` LIKE 'project'";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

?>


<br>

<table style="width:100%;border-collapse: collapse">

  <tr>
    <td style="width:60%"><b>Titel</b></td>
    <td style="width:20%"><b>Credits</b></td>
  </tr>

<?php

  while($entry = mysql_fetch_array($result))
  {
    $event_id = $entry[id];
   ?>

    <tr>
        <td class="bottomline" style="width:60%"><?php echo $event_id." <i>".ucfirst($entry[type])."</i> ".$entry[title];?></a>
        <td style="width:20%">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="add" value="<?php echo $event_id ?>" />
            <input type="number" name="quantity" size="4">
            <input type="submit" value="Add to Basket"></form>
        </td>
    </tr>
    <tr>
        <td class="bottomline"><?php echo $entry[text]; ?></td>
        <td></td>
    </tr>       

    <?php
    }
    ?>
</table>



<?php 
} 
?>



</div>
<?php include "_side_in.php"; ?>
</div>


<?php 
include "_footer.php"; 
?>
