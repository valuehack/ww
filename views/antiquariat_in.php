<?php 
require_once('../classes/Login.php');
$title="Antiquariat";
include('_header_in.php'); 

?>

<script>
function changeView(price, price_book) {
    var x = document.getElementById("change").value;

    if (x == 4) {    
      document.getElementById("quantity").innerHTML = '<input type="number" name="quantity" onchange="changePrice(this.value,' + price_book + ')" value="1" min="1" max="100">';
      document.getElementById("price").innerHTML = "<span id='total'>" + price_book + " </span>";
    }
    else {
      document.getElementById("quantity").innerHTML = '<input type="hidden" name="quantity" value="1"><input type="number" name="quantity2" value="1" disabled>';
      document.getElementById("price").innerHTML = price;
    }
}

function changePrice(totalQuantity, price_book){
    document.getElementById("total").innerHTML = (totalQuantity * price_book);
}

function changeprice_book(totalQuantity, price_book){
    document.getElementById("price").innerHTML = (totalQuantity * price_book);
}
</script>

<?php 
if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}

if(isset($_POST['add'])){

	$add_id = $_POST['add'];
  $add_quantity = $_POST['quantity'];
  $add_format = $_POST['format'];
  $add_code = $add_id . $add_format;
  if ($add_quantity==1) $wort = "wurde";
  else $wort = "wurden";

 	echo "<div class='basket_message'><i>".$add_quantity." Artikel ".$wort." in Ihren Korb gelegt.</i> &nbsp <a href='../abo/korb.php'>&raquo; zum Korb</a></div>";

 	if (isset($_SESSION['basket'][$add_code])) {
    $_SESSION['basket'][$add_code] += $add_quantity; 
  }
  else {
    $_SESSION['basket'][$add_code] = $add_quantity; 
  }
}


  if ($_SESSION['Mitgliedschaft'] == 1) {
  ?>       
  	<div class='medien_info'>
  		<?php  
			$bib_info = $general->getStaticInfo('schriften');
			echo $bib_info->info;
		?>
			<div class="centered">
				<a class="blog_linkbutton" href="../spende/">Unterst&uuml;tzen & Zugang erhalten</a>
			</div>	  
  </div>
  <?
  }
  elseif ($_SESSION['Mitgliedschaft'] > 1){
?>
    <div class="medien_content">
		<h1>Antiquariat</h1>
<?php

$sql = "SELECT * from produkte WHERE (type LIKE 'antiquariat') AND status = 1 AND (spots > spots_sold) order by title asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

	echo "<table class='schriften_table'>";

while($entry = mysql_fetch_array($result))
{
  $id = $entry[id];
  
?>
		<tr>		
			<td class="antiquariat_table_b">
      			<?=$entry[title]?>
			</td>
			<td class="antiquariat_table_c">
				<span class="coin-span"><?=$entry[price_book]?></span><img class="coin-span__img" src="../style/gfx/coin.png">
			</td>
			<td class="antiquariat_table_d">
			<?php
			if ($_SESSION['Mitgliedschaft'] == 1) {
			?>     					 
    		<input type="button" value="Bestellen" class="antiquariat_inputbutton" data-toggle="modal" data-target="#myModal">
    		<?  
  			  }
  			  else {
    			?>
    		<form action="<?php htmlentities($_SERVER['PHP_SELF'])?>" method="post">
      			<input type="hidden" name="add" value="<?=$entry[n]?>">
      			<input type="hidden" name="quantity" value="1">
      			<input type="hidden" name="format" value="4">
     
    		<?php
					echo '<input type="submit" class="antiquariat_inputbutton" value="Ausw&auml;hlen"><br>';
      		} ?>
    		</form>
    		</td>
			<!--<td class="schriften_table_c">
				<?php
					/*if 	($_SESSION['Mitgliedschaft'] == 1) { 
						echo '<input type="button" class="inputbutton" value="Bestellen / Herunterladen" data-toggle="modal" data-target="#myModal">';
					}
					else {
						
						echo "<a href='?q=$id'><button class='inputbutton' type='button'>Bestellen</button></a>";
      					}     									
					*/?>
			</td>-->
		</tr>

<?php
	}
	echo "</table>";
	echo '</div>';
  }
?>



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Bestellen und Herunterladen</h2>
      </div>
      <div class="modal-body">
        <p>Wir freuen uns, dass Sie eine unserer Schriften bestellen m&ouml;chten. Allerdings sind einige Schriften nicht f&uuml;r die &Ouml;ffentlichkeit bestimmt, andere sind im Buchhandel zu erwerben,&nbsp;da ein Vertrieb und Versand f&uuml;r uns nicht wirtschaftlich&nbsp;ist. Unser Webshop, &uuml;ber den alle Schriften entweder bestellt oder in allen digitalen Formaten f&uuml;r Leseger&auml;te heruntergeladen werden k&ouml;nnen, steht nur unseren G&auml;sten zur Verf&uuml;gung, die einen kleinen Kostenbeitrag (6,25&euro; im Monat) f&uuml;r das Bestehen des <i>scholarium</i> leisten (und daf&uuml;r die meisten Schriften kostenlos beziehen k&ouml;nnen). K&ouml;nnen Sie sich das leisten? Dann folgen Sie diesem Link und in K&uuml;rze erhalten Sie Zugriff auf unsere Schriften:&nbsp;</p>
      </div>
      <div class="modal-footer">
        <a href="../spende/"><button type="button" class="inputbutton">Besuchen Sie uns als Gast</button></a>
      </div>
    </div>
  </div>
</div>

<?php include('_footer.php'); ?>