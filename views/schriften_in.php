<?php 
require_once('../classes/Login.php');
include('_header_in.php'); 
$title="Schriften";
?>

<script>
function changeView(price, price2) {
    var x = document.getElementById("change").value;

    if (x == 4) {    
      document.getElementById("quantity").innerHTML = 'Menge: <input type="number" name="quantity" style="width:35px;" onchange="changePrice(this.value,' + price2 + ')" value="1" min="1" max="100">';
      document.getElementById("price").innerHTML = "<span id='total'>" + price2 + " Credits</span>";
    }
    else {
      document.getElementById("quantity").innerHTML = '<input type="hidden" name="quantity" value="1" />';
      document.getElementById("price").innerHTML = price + " Credits";
    }
}

function changePrice(totalQuantity, price2){
    document.getElementById("total").innerHTML = (totalQuantity * price2) + " Credits";
}

function changePrice2(totalQuantity, price2){
    document.getElementById("total2").innerHTML = (totalQuantity * price2) + " Credits";
}
</script>

<div class="content">


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

 	echo "<div style='text-align:center'><hr><i>".$add_quantity." Artikel ".$wort." in Ihren Korb gelegt.</i> &nbsp <a href='../abo/korb.php'>Zum Korb</a><hr><br></div>";

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
  $type=$entry3[type];
  $title=$entry3[title];
  
          	//check, if there is a image in the salon folder
	$img = 'http://test.wertewirtschaft.net/schriften/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/schriften/default.jpg";
	}
?>
  	<div class="medien_head">
  		<h1><?echo $entry3[title]?></h1>
  		  		<div class="centered">
			<img src="<?echo $img;?>" alt="<?echo $id;?>">
		</div>
	</div>
	<div class="medien_seperator">
		<h1>Inhalt und Informationen</h1>
	</div>
	<div class="medien_content">
<? 
  if ($entry3[text]) echo $entry3[text];
  if ($entry3[text2]) echo $entry3[text2];

  if ($_SESSION['Mitgliedschaft'] == 1) {  
    //Button trigger modal
    echo "<div class='centered'>";
    echo '<input type="button" value="Bestellen und Herunterladen" class="inputbutton" data-toggle="modal" data-target="#myModal">';  
	echo '</div>';
  }
  else {
    $pdf = substr($entry3[format],0,1);
    $epub = substr($entry3[format],1,1);
    $kindle = substr($entry3[format],2,1);
    $druck = substr($entry3[format],3,1);

    $price = $entry3[price];
    $price2 = $entry3[price2];

    ?>
    <div class="centered">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />
     
    <?php
      if ($entry3[format] == '0001') {
        echo 'Menge: <input type="number" name="quantity" style="width:35px;" onchange="changePrice2(this.value,'.$price2.')" value="1" min="1" max="100">';
        echo ' Format: <select name="format"><option value="4">Druck</option></select>';
      }

      else { 
      echo '<span id="quantity"><input type="hidden" name="quantity" value="1" /></span>';
      echo ' Format: <select name="format" id="change" onchange="changeView('.$price.','.$price2.')">';
        if ($pdf == 1) echo '<option value="1">PDF</option>';
        if ($epub == 1) echo '<option value="2">ePub</option>';
        if ($kindle == 1) echo '<option value="3">Kindle</option>';
        if ($druck == 1) echo '<option value="4">Druck</option>';   
      echo '</select>';
      }  
    
      if ($entry3[format] == '0001') {
        echo '<input type="submit" value="Auswählen">&nbsp;&nbsp;<i><span id="total2">'.$entry3[price].' Credits</span></i>';
      }
      else { 
    ?>
      <input type="submit" class="inputbutton" value="Auswählen">&nbsp;&nbsp;<i><span id="price"><?echo $entry3[price]?> Credits</span></i>
    
    <?php
      } ?>
    </form>
    </div>
    <div class="medien_anmeldung"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">zur&uuml;ck zu den Schriften</a></div>
   </div>
<?php 
  }

}
     
else {

  if ($_SESSION['Mitgliedschaft'] == 1) {
  ?>       
  	<div class='medien_info'>	
    	<p>Unsere Schriften umfassen derzeit:<br>
      		<ul>
        		<li><b>B&uuml;cher</b> &ndash; teilweise eigene, eher f&uuml;r ein breiteres Publikum, teilweise &Uuml;bersetzungen, meist schwierigere Texte</li>
        		<li><b>Analysen</b> &ndash; besonders effiziente und lesbare Texte f&uuml;r einen schnellen, aber profunden &Uuml;berblick zu einem Thema</li>
        		<li>Restexemplare der gedruckten <b>Scholien</b> bis 2014</li>
        		<li>neue Druckausgaben der <b>Scholien</b></li>
     	  </ul>
		</p>  
  </div>
  <?
  } ?>
  	<div class="medien_seperator">
    	<h1>Schriften</h1>
    </div> 
	<div class="medien_content">
<?php
$sql = "SELECT * from produkte WHERE (type LIKE 'buch' OR type LIKE 'scholien' OR type LIKE 'analyse') AND status > 0 order by title asc, n asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

	echo "<table class='schriften_table'>";

while($entry = mysql_fetch_array($result))
{
  $id = $entry[id];
  
  //check, if there is a image in the salon folder
	$img = 'http://test.wertewirtschaft.net/schriften/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/schriften/default.jpg";
	}
	
?>
		<tr>
			<!--<td>	
				<? echo ucfirst($entry[type]);?>
			</td>-->
			<td>
      			<? echo "<a href='?q=$id'>".$entry[title]." </a>"; ?><br>
      			<? echo ucfirst($entry[type]);?>
			</td>
			<td>
				<img src="<?echo $img_url;?>" alt="Cover <?echo $id;?>">
			</td>
		</tr>

<?php
	}
	echo "</table>";
	echo "</div>";
}
?>

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Bestellen und Herunterladen - Upgrade</h2>
      </div>
      <div class="modal-body">
        <p>Wir freuen uns, dass Sie eine unserer Schriften bestellen m&ouml;chten. Allerdings sind einige Schriften nicht f&uuml;r die &Ouml;ffentlichkeit bestimmt, andere sind im Buchhandel zu erwerben,&nbsp;da ein Vertrieb und Versand f&uuml;r uns nicht wirtschaftlich&nbsp;ist. Unser Webshop, &uuml;ber den alle Schriften entweder bestellt oder in allen digitalen Formaten f&uuml;r Leseger&auml;te heruntergeladen werden k&ouml;nnen, steht nur unseren G&auml;sten zur Verf&uuml;gung, die einen kleinen Kostenbeitrag (6,25&euro;) f&uuml;r das Bestehen der Wertewirtschaft leisten (und daf&uuml;r die meisten Schriften kostenlos beziehen k&ouml;nnen). K&ouml;nnen Sie sich das leisten? Dann folgen Sie diesem Link und in K&uuml;rze erhalten Sie Zugriff auf unsere Schriften:&nbsp;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="inputbutton_white" data-dismiss="modal">Schließen</button>
        <a href="../upgrade.php"><button type="button" class="inputbutton">Jetzt upgraden</button></a>
      </div>
    </div>
  </div>
</div>

<?php include('_footer.php'); ?>