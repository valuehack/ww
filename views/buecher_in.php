<?php 
require_once('../classes/Login.php');
$title="B&uuml;cher";
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

 	echo "<div class='basket_message'><i>".$add_quantity." Artikel ".$wort." in Ihren Korb gelegt.</i> &nbsp <a href='../spende/korb.php'>&raquo; zum Korb</a></div>";

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

  //Product Infos
  $itm_info = $general->getProduct($id);
  
  //User Reg Infos
  //$user_itm = $general->getEventReg($user_id, $event_id);

  $user_items_query = "SELECT * from registration WHERE `user_id`=$user_id and event_id='$itm_info->n'";
  $user_items_result = mysql_query($user_items_query) or die("Failed Query of " . $user_items_query. mysql_error());
  
    //check, if there is an image in the schriften folder
	$img = 'http://www.scholarium.at/schriften/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "";
	}
?>
  	<div class="buecher_head">
  		<h1><?=$itm_info->title?></h1>
  		<div>
  			<?php
  			if ($img_url != "") {
  			?>	
  			<div class="buecher_img">
				<img src="<?=$img_url?>" alt="<?=$id?>">
			</div>
			<?php
			}
			?>
		<div class="buecher_bestellen">
			<?php
			  echo '<span class="schriften_type">'.ucfirst($itm_info->type).'</span>';
			  if ($_SESSION['Mitgliedschaft'] == 1) {
			  	?>     					 
    		<input type="button" value="Bestellen" class="inputbutton" data-toggle="modal" data-target="#myModal">
    		<?  
  			  }
  			  else {
  			  	
  			  	$preis_druck = $itm_info->price_book;
				$preis_digital = $itm_info->price;
    			
    			if ($itm_info->format == '0001') {
    		?>
    			
    			<form action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      					<input type="hidden" name="add" value="<?=$itm_info->n?>">
      					<input type="hidden" name="format" value="4">      
      					<select class="input-select" name="quantity" onchange="changePrice(this.value,'<?=$preis_druck?>')">>
      					<?php
		  					if (($itm_info->spots - $itm_info->spots_sold) == 0){echo '<option value="0">0</option>';}
		  					if (($itm_info->spots - $itm_info->spots_sold) >= 1){echo '<option value="1" selected>1</option>';}
		  					if (($itm_info->spots - $itm_info->spots_sold) >= 2){echo '<option value="2">2</option>';}
		  					if (($itm_info->spots - $itm_info->spots_sold) >= 3){echo '<option value="3">3</option>';}
		  					if (($itm_info->spots - $itm_info->spots_sold) >= 4){echo '<option value="4">4</option>';}
		  					if (($itm_info->spots - $itm_info->spots_sold) >= 5){echo '<option value="5">5</option>';}
							if (($itm_info->spots - $itm_info->spots_sold) >= 6){echo '<option value="6">6</option>';}
							if (($itm_info->spots - $itm_info->spots_sold) >= 7){echo '<option value="7">7</option>';}
							if (($itm_info->spots - $itm_info->spots_sold) >= 8){echo '<option value="8">8</option>';}
							if (($itm_info->spots - $itm_info->spots_sold) >= 9){echo '<option value="9">9</option>';}
							if (($itm_info->spots - $itm_info->spots_sold) >= 10){echo '<option value="10">10</option>';}
		  				?>       
     					</select> 
      					<input class="inputbutton" type="submit" value="Ausw&auml;hlen" <? if(($itm_info->spots - $itm_info->spots_sold) == 0) echo "disabled"?>><br>     
    				</form>
  					<span id="change" class="coin-span"><?=$preis_druck?></span><img class="coin-span__img" src="../style/gfx/coin.png">
			<?php
				}
				else {
			?>
				<form class="buecher_form" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      					<input type="hidden" name="add" value="<?=$itm_info->n?>">
      					<input type="hidden" name="format" value="4">      
      					<select class="input-select" name="quantity" onchange="changePrice(this.value,'<?=$preis_druck?>')">>
      					<?php
		  					if (($itm_info->spots - $itm_info->spots_sold) == 0){echo '<option value="0">0</option>';}
		  					if (($itm_info->spots - $itm_info->spots_sold) >= 1){echo '<option value="1" selected>1</option>';}
		  					if (($itm_info->spots - $itm_info->spots_sold) >= 2){echo '<option value="2">2</option>';}
		  					if (($itm_info->spots - $itm_info->spots_sold) >= 3){echo '<option value="3">3</option>';}
		  					if (($itm_info->spots - $itm_info->spots_sold) >= 4){echo '<option value="4">4</option>';}
		  					if (($itm_info->spots - $itm_info->spots_sold) >= 5){echo '<option value="5">5</option>';}
							if (($itm_info->spots - $itm_info->spots_sold) >= 6){echo '<option value="6">6</option>';}
							if (($itm_info->spots - $itm_info->spots_sold) >= 7){echo '<option value="7">7</option>';}
							if (($itm_info->spots - $itm_info->spots_sold) >= 8){echo '<option value="8">8</option>';}
							if (($itm_info->spots - $itm_info->spots_sold) >= 9){echo '<option value="9">9</option>';}
							if (($itm_info->spots - $itm_info->spots_sold) >= 10){echo '<option value="10">10</option>';}
		  				?>       
     					</select> 
      					<input class="inputbutton" type="submit" value="Druck" <? if(($itm_info->spots - $itm_info->spots_sold) == 0 OR $itm_info->format == "1110" OR $itm_info->format == "1010" OR $itm_info->format == "1100" OR $itm_info->format == "1000" OR $itm_info->format == "0110" OR $itm_info->format == "0100" OR $itm_info->format == "0010") echo "disabled"?>>
      					<span id="change" class="coin-span"><?=$preis_druck?></span><img class="coin-span__img" src="../style/gfx/coin.png">
    				</form>
				<form class="buecher_form" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" method="post">
      			<input type="hidden" name="add" value="<?=$itm_info->n?>">
      			<input type="hidden" name="quantity" value="1">
      			<input type="hidden" name="format" value="1">
     			
     			<input type="submit" class="inputbutton" value="PDF" <?php if ($itm_info->format == "0111" OR $itm_info->format == "0011" OR $itm_info->format == "0101" OR $itm_info->format == "0100" OR $itm_info->format == "0010" OR $itm_info->format == "0110") { ?> disabled <?php } ?> >
    			<span id="change" class="coin-span"><?=$preis_digital?></span><img class="coin-span__img" src="../style/gfx/coin.png">
    		</form>
    		<form class="buecher_form" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" method="post">
      			<input type="hidden" name="add" value="<?=$itm_info->n?>">
      			<input type="hidden" name="quantity" value="1">
      			<input type="hidden" name="format" value="2">
      			
      			<input type="submit" class="inputbutton" value="EPUB" <?php if ($itm_info->format == "1011" OR $itm_info->format == "0011" OR $itm_info->format == "1001" OR $itm_info->format == "1000" OR $itm_info->format == "0010" OR $itm_info->format == "1010") { ?> disabled <?php } ?> >
    			<span id="change" class="coin-span"><?=$preis_digital?></span><img class="coin-span__img" src="../style/gfx/coin.png">
    		</form>
    		<form class="buecher_form" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" method="post">
      			<input type="hidden" name="add" value="<?=$itm_info->n?>">
      			<input type="hidden" name="quantity" value="1">
      			<input type="hidden" name="format" value="3">
      			
      			<input type="submit" class="inputbutton" value="Kindle" <?php if ($itm_info->format == "1101" OR $itm_info->format == "1001" OR $itm_info->format == "0101" OR $itm_info->format == "1100" OR $itm_info->format == "1000" OR $itm_info->format == "0100") { ?> disabled <?php } ?> >
				<span id="change" class="coin-span"><?=$preis_digital?></span><img class="coin-span__img" src="../style/gfx/coin.png">
			</form>
			<?php	
					}
      		}
      	?>
		</div>
		</div>
	</div>
	<div class="medien_seperator">
		<h1>Inhalt</h1>
	</div>
	<div class="medien_content">
<? 
  if ($itm_info->text) echo $itm_info->text;
  if ($itm_info->text2) echo $itm_info->text2;
?>
    	<div class="medien_anmeldung"><a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">zur&uuml;ck zu den B&uuml;chern</a></div>
    </div>
   </div>
<?php 
}

else {
	
  if ($_SESSION['Mitgliedschaft'] == 1) {
  ?>       
  	<div class='medien_info'>
  		<h1>B&uuml;cher</h1>
  		<?php  
			$buecher_info = $general->getStaticInfo('buecher');
			echo $buecher_info->info;
			echo $buecher_info->info2;
		?>
			<div class="centered">
				<a class="blog_linkbutton" href="../spende/">Unterst&uuml;tzen & Zugang erhalten</a>
			</div>	  
  </div>
  <?
  }
  elseif ($_SESSION['Mitgliedschaft'] > 1){
?>
    <div class="buecher_content">
		<h1>B&uuml;cher</h1>
<?php

$sql = "SELECT * from produkte WHERE (type LIKE 'antiquariat' OR type LIKE 'buch') AND status = 1 AND (spots > spots_sold) order by title asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
?>
	<table class='buecher_table'>

<?php
while($entry = mysql_fetch_array($result))
{
  $id = $entry[id];
  
?>
		<tr>		
			<td class="buecher_table_b">
      			<?=$entry[title]?>
			</td>
			<td class="buecher_table_c">
				<span class="coin-span"><?=$entry[price_book]?></span><img class="coin-span__img" src="../style/gfx/coin.png">
			</td>
			<td class="buecher_table_d">
			<?php
			if ($_SESSION['Mitgliedschaft'] == 1) {
			?>     					 
    		<input type="button" value="Bestellen" class="buecher_inputbutton" data-toggle="modal" data-target="#myModal">
    		<?  
  			  }
  			  else {
    			?>
    		<form action="<?php htmlentities($_SERVER['PHP_SELF'])?>" method="post">
      			<input type="hidden" name="add" value="<?=$entry[n]?>">
      			<input type="hidden" name="quantity" value="1">
      			<input type="hidden" name="format" value="4">
     
    		<?php
					echo '<input type="submit" class="buecher_inputbutton" value="Ausw&auml;hlen"><br>';
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
      			if ($entry[format] != '0001') {
      	?>
		<tr>		
			<td class="buecher_table_b">
      			<?php
   					echo substr($entry[title],0,-4)."digital)";
      			?>
			</td>
			<td class="buecher_table_c">
				<span class="coin-span"><?=$entry[price]?></span><img class="coin-span__img" src="../style/gfx/coin.png">
			</td>
			<td class="buecher_table_d">
			<?php
			if ($_SESSION['Mitgliedschaft'] == 1) {
			?>     					 
    		<input type="button" value="Bestellen" class="buecher_inputbutton" data-toggle="modal" data-target="#myModal">
    		<?  
  			  }
  			  else {
    			?>
    		<form class="buecher_digital_form" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" method="post">
      			<input type="hidden" name="add" value="<?=$entry[n]?>">
      			<input type="hidden" name="quantity" value="1">
      			<input type="hidden" name="format" value="1">
     			
     			<input type="submit" class="buecher_digital_inputbutton" value="PDF" <?php if ($entry[format] == "0111" OR $entry[format] == "0011" OR $entry[format] == "0101") { ?> disabled <?php } ?> >
    		</form>
    		<form class="buecher_digital_form" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" method="post">
      			<input type="hidden" name="add" value="<?=$entry[n]?>">
      			<input type="hidden" name="quantity" value="1">
      			<input type="hidden" name="format" value="2">
      			
      			<input type="submit" class="buecher_digital_inputbutton" value="EPUB" <?php if ($entry[format] == "1011" OR $entry[format] == "0011" OR $entry[format] == "1001") { ?> disabled <?php } ?> >
    		</form>
    		<form class="buecher_digital_form" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" method="post">
      			<input type="hidden" name="add" value="<?=$entry[n]?>">
      			<input type="hidden" name="quantity" value="1">
      			<input type="hidden" name="format" value="3">
      			
      			<input type="submit" class="buecher_digital_inputbutton" value="Kindle" <?php if ($entry[format] == "1101" OR $entry[format] == "1001" OR $entry[format] == "0101") { ?> disabled <?php } ?> >
    		<?php } ?>
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
	}
?>
	</table>
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
        <h2 class="modal-title" id="myModalLabel">Bestellen</h2>
      </div>
      <div class="modal-body">
        <p>Wir freuen uns, dass Sie eines unserer B&uuml;cher bestellen m&ouml;chten. Unser Unterst&uuml;tzerbereich, &uuml;ber den alle Schriften entweder bestellt oder in allen digitalen Formaten f&uuml;r Leseger&auml;te heruntergeladen werden k&ouml;nnen, steht nur unseren G&auml;sten zur Verf&uuml;gung, die einen kleinen Kostenbeitrag (mindestens 6,25&euro; im Monat) f&uuml;r das Bestehen des <em>scholarium</em> leisten (und daf&uuml;r die meisten Schriften kostenlos beziehen k&ouml;nnen). K&ouml;nnen Sie sich das leisten? Dann folgen Sie diesem Link und in K&uuml;rze erhalten Sie Zugriff auf unsere B&uuml;cher.</p>
      </div>
      <div class="modal-footer">
        <a href="../spende/"><button type="button" class="inputbutton">Besuchen Sie uns als Gast</button></a>
      </div>
    </div>
  </div>
</div>

<?php include('_footer.php'); ?>