
<?
require_once('../classes/Login.php');
$title="Salon";
include "_header_in.php"; 
?>

<script>
function changePrice(totalQuantity, price){
    document.getElementById("change").innerHTML = (totalQuantity * price);
}

</script>

<?
//print_r($_SESSION);

//Inserted from catalog.php
if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}

if(isset($_POST['add'])){

  $add_id = $_POST['add'];
  $add_quantity = $_POST['quantity'];
  $add_code = $add_id . "0";
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

if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Termindetails
  $sql="SELECT * from produkte WHERE type LIKE 'salon' AND id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  $n = $entry3[n];
  $price = $entry3[price];
  $spots_total=$entry3[spots];
  $spots_sold=$entry3[spots_sold];
  $spots_available=$spots_total-$spots_sold;
  
  	//check, if there is a image in the salon folder
	$img = 'http://test.wertewirtschaft.net/salon/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/salon/default.jpg";
	}  
?>
  <div class="content">
  	<div class="salon_head">
  		<h1><?echo $entry3[title]?></h1>
		<p class="salon_date">
      <?
      if ($entry3[start] != NULL && $entry3[end] != NULL)
        {
        $tag=date("w",strtotime($entry3[start]));
        $tage = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
        echo $tage[$tag]." ";
        echo strftime("%d.%m.%Y %H:%M", strtotime($entry3[start]));
        if (strftime("%d.%m.%Y", strtotime($entry3[start]))!=strftime("%d.%m.%Y", strtotime($entry3[end])))
          {
          echo " Uhr &ndash; ";
          $tag=date("w",strtotime($entry3[end]));
          echo $tage[$tag];
          echo strftime(" %d.%m.%Y %H:%M Uhr", strtotime($entry3[end]));
          }
        else echo strftime(" &ndash; %H:%M Uhr", strtotime($entry3[end]));
      }
      elseif ($entry3[start]!= NULL)
        {
        $tag=date("w",strtotime($entry3[start]));
        echo $tage[$tag]." ";
        echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry3[start]));
      }
      else echo "Der Termin wird in K&uuml;rze bekannt gegeben."; ?>
      </p>
  		<!--<img src="<?echo $img_url;?>" alt="<? echo $id;?>">--> 	
  			
  		<div class="centered">
    		<div class="salon_reservation">
<?php
  if ($_SESSION['Mitgliedschaft'] == 1) {  
    //Button trigger modal
    echo '<input class="salon_reservation_inputbutton" type="button" value="Reservieren" data-toggle="modal" data-target="#myModal">';
  }  
  elseif ($spots_available >= 5){
    ?>
    <span class="salon_reservation_span_a">Anzahl gew&uuml;nschter Eintrittskarten</span><br>
    <form class="salon_reservation_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />      
      <select name="quantity" onchange="changePrice(this.value,'<?php echo $price; ?>')">
      	<option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>        
      </select> 
      <input class="inputbutton" type="submit" value="Ausw&auml;hlen"><br>     
    </form>
	<div class='salon_price_list'><li id="change" class="salon_reservation_span_b"><?php echo $price; ?></li><li class='salon_coin'><img src="../style/gfx/coin.png"></li></div>
<?php  
  }	

 elseif ($spots_available >= 4){
    ?>
    <span class="salon_reservation_span_a">Anzahl gew&uuml;nschter Eintrittskarten</span><br>
    <form class="salon_reservation_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />      
      <select name="quantity" onchange="changePrice(this.value,'<?php echo $price; ?>')">
      	<option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>       
      </select> 
      <input class="inputbutton" type="submit" value="Ausw&auml;hlen"><br>     
    </form>
	<div class='salon_price_list'><li id="change" class="salon_reservation_span_b"><?php echo $price; ?></li><li class='salon_coin'><img src="../style/gfx/coin.png"></li></div>
<?php  
  }	
	
	elseif ($spots_available >= 3){
    ?>
    <span class="salon_reservation_span_a">Anzahl gew&uuml;nschter Eintrittskarten</span><br>
    <form class="salon_reservation_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />      
      <select name="quantity" onchange="changePrice(this.value,'<?php echo $price; ?>')">
      	<option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>      
      </select> 
      <input class="inputbutton" type="submit" value="Ausw&auml;hlen"><br>     
    </form>
	<div class='salon_price_list'><li id="change" class="salon_reservation_span_b"><?php echo $price; ?></li><li class='salon_coin'><img src="../style/gfx/coin.png"></li></div>
<?php  
  }
		
	elseif ($spots_available >= 2){
    ?>
    <span class="salon_reservation_span_a">Anzahl gew&uuml;nschter Eintrittskarten</span><br>
    <form class="salon_reservation_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />      
      <select name="quantity" onchange="changePrice(this.value,'<?php echo $price; ?>')">
      	<option value="1">1</option>
        <option value="2">2</option>      
      </select> 
      <input class="inputbutton" type="submit" value="Ausw&auml;hlen"><br>     
    </form>
	<div class='salon_price_list'><li id="change" class="salon_reservation_span_b"><?php echo $price; ?></li><li class='salon_coin'><img src="../style/gfx/coin.png"></li></div>
<?php  
  }

	elseif ($spots_available >= 1){
    ?>
    <span class="salon_reservation_span_a">Anzahl gew&uuml;nschter Eintrittskarten</span><br>
    <form class="salon_reservation_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />      
      <select name="quantity" onchange="changePrice(this.value,'<?php echo $price; ?>')">
      	<option value="1">1</option>     
      </select> 
      <input class="inputbutton" type="submit" value="Ausw&auml;hlen"><br>     
    </form>
	<div class='salon_price_list'><li id="change" class="salon_reservation_span_b"><?php echo $price; ?></li><li class='salon_coin'><img src="../style/gfx/coin.png"></li></div>
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
  <?php
  if ($entry3[text]) echo "<p>$entry3[text]</p>";
  if ($entry3[text2]) echo "<p>$entry3[text2]</p>";


			$sql = "SELECT * from static_content WHERE (page LIKE 'salon')";
			$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
			$entry4 = mysql_fetch_array($result);
	
				echo $entry4[info];			
			?>
			
  			<div class="medien_anmeldung"><a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">zur&uuml;ck zu den Salons</a></div>
		</div>
	</div>
<?php
}

else {
?>		
	<div class="content">
		<?
//für Interessenten (Mitgliedschaft 1) Erklärungstext oben
  if ($_SESSION['Mitgliedschaft'] == 1) {
  	echo "<div class='salon_info'>";
			$sql = "SELECT * from static_content WHERE (page LIKE 'salon')";
			$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
			$entry4 = mysql_fetch_array($result);
	
				echo $entry4[info];	
	?>
			<div class="centered">
				<a class="blog_linkbutton" href="../abo/">Unterst&uuml;tzen & Zugang erhalten</a>
			</div>		
   </div>
   <?
  }
  elseif ($_SESSION['Mitgliedschaft'] > 1) {
?>
		<div class="salon_content">
<?	
  $sql = "SELECT * from produkte WHERE type LIKE 'salon' AND start > NOW() AND spots > spots_sold AND status = 1 order by start asc, n asc";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

  while($entry = mysql_fetch_array($result))
  {
    $id = $entry[id];
      ?>
      
<?php echo "<h1><a href='?q=$id'>".$entry[title]; ?></a></h1>
		<div class="salon_dates">
      <? if ($entry[start] != NULL && $entry[end] != NULL)
        {
        $tag=date("w",strtotime($entry[start]));
        $tage = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
        echo $tage[$tag]." ";
        echo strftime("%d.%m.%Y %H:%M", strtotime($entry[start]));
        if (strftime("%d.%m.%Y", strtotime($entry[start]))!=strftime("%d.%m.%Y", strtotime($entry[end])))
          {
          echo " Uhr &ndash; ";
          $tag=date("w",strtotime($entry[end]));
          echo $tage[$tag];
          echo strftime(" %d.%m.%Y %H:%M Uhr", strtotime($entry[end]));
          }
        else echo strftime(" &ndash; %H:%M Uhr", strtotime($entry[end]));
      }
      elseif ($entry[start]!= NULL)
        {
        $tag=date("w",strtotime($entry[start]));
        echo $tage[$tag]." ";
        echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry[start]));
      }
      else echo "Der Termin wird in K&uuml;rze bekannt gegeben."; ?>
		</div>
		<?php echo $entry[text]; ?> 
			<!--<div class="salon_anmeldung"><a href="<? echo "?q=$id";?>">zur Anmeldung</a></div>-->
			<div class="centered"><p class='linie'><img src='../style/gfx/linie.png' alt=''></p></div>
  <?php
  }
  ?>
  	</div>
  </div>
  	<?php
  }
}    
  ?> 

 <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h2 class="modal-title" id="myModalLabel">Reservieren</h2>
        </div>
        <div class="modal-body">
        	<?php  
			$sql = "SELECT * from static_content WHERE (page LIKE 'salon')";
			$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
			$entry4 = mysql_fetch_array($result);
	
				echo $entry4[modal];			
			?>
        </div>
        <div class="modal-footer">
          <a href="../abo/"><button type="button" class="inputbutton">Besuchen Sie uns als Gast</button></a>
        </div>
      </div>
    </div>
  </div>


<? include "_footer.php"; ?>