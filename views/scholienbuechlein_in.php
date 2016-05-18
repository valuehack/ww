<?php 
require_once('../classes/Login.php');
$title="Scholienb&uuml;chlein";
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
    			
    			<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
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
      		<?php			
      					if (strlen("$preis_druck") - strlen("$preis_digital") == "1") {$coin_span = "buecher-coin-span1";}
						elseif (strlen("$preis_druck") - strlen("$preis_digital") == "2") {$coin_span = "buecher-coin-span2";}
						else {$coin_span = "buecher-coin-span";}		
			?>		
      					<span id="change" class="buecher-coin-span"><?=$preis_druck?></span><img class="coin-span__img" src="../style/gfx/coin.png">
    				</form>
				<form class="buecher_form" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" method="post">
      			<input type="hidden" name="add" value="<?=$itm_info->n?>">
      			<input type="hidden" name="quantity" value="1">
      			<input type="hidden" name="format" value="1">
     			
     			<input type="submit" class="inputbutton" value="PDF" <?php if ($itm_info->format == "0111" OR $itm_info->format == "0011" OR $itm_info->format == "0101" OR $itm_info->format == "0100" OR $itm_info->format == "0010" OR $itm_info->format == "0110") { ?> disabled <?php } ?> >
    			<span id="change" class="<?=$coin_span?>"><?=$preis_digital?></span><img class="buecher-coin-span__img" src="../style/gfx/coin.png">
    		</form>
    		<form class="buecher_form" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" method="post">
      			<input type="hidden" name="add" value="<?=$itm_info->n?>">
      			<input type="hidden" name="quantity" value="1">
      			<input type="hidden" name="format" value="2">
      			
      			<input type="submit" class="inputbutton" value="EPUB" <?php if ($itm_info->format == "1011" OR $itm_info->format == "0011" OR $itm_info->format == "1001" OR $itm_info->format == "1000" OR $itm_info->format == "0010" OR $itm_info->format == "1010") { ?> disabled <?php } ?> >
    			<span id="change" class="<?=$coin_span?>"><?=$preis_digital?></span><img class="buecher-coin-span__img" src="../style/gfx/coin.png">
    		</form>
    		<form class="buecher_form" action="<?php htmlentities($_SERVER['PHP_SELF'])?>" method="post">
      			<input type="hidden" name="add" value="<?=$itm_info->n?>">
      			<input type="hidden" name="quantity" value="1">
      			<input type="hidden" name="format" value="3">
      			
      			<input type="submit" class="inputbutton" value="Kindle" <?php if ($itm_info->format == "1101" OR $itm_info->format == "1001" OR $itm_info->format == "0101" OR $itm_info->format == "1100" OR $itm_info->format == "1000" OR $itm_info->format == "0100") { ?> disabled <?php } ?> >
				<span id="change" class="<?=$coin_span?>"><?=$preis_digital?></span><img class="buecher-coin-span__img" src="../style/gfx/coin.png">
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
    	<div class="medien_anmeldung"><a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">zur&uuml;ck zu den Scholienb&uuml;chlein</a></div>
    </div>
   </div>
<?php 
}
  
else {

  if ($_SESSION['Mitgliedschaft'] == 1) {
  ?>       
  	<div class='medien_info'>
  		<h1>Scholienb&uuml;chlein</h1>
  		<?php  
			$scholienbuechlein_info = $general->getStaticInfo('scholienbuechlein');
			echo $scholienbuechlein_info->info1;		
			?>
			<div class="centered">
				<a class="blog_linkbutton" href="../spende/">Unterst&uuml;tzen & Zugang erhalten</a>
			</div>	  
  </div>
  <?
  }
  elseif ($_SESSION['Mitgliedschaft'] > 1){
	if(isset($_GET['type']))
	{
	$type2 =  $_GET['type'];
	
	if ($type2 == 'scholien'){
		$type3 = 'scholie';
	}	
	elseif ($type2 == 'analysen'){
		$type3 = 'analyse';
	}	
	elseif ($type2 == 'buecher'){
		$type3 = 'buch';
	}
	include('../schriften/schriften_data.php');
}	
else {
?>
    <div class="medien_content">

<?php

//Pagination Script found at http://www.phpeasystep.com/phptu/29.html
  $tbl_name="produkte";   //your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;
  
  /* 
     First get total number of rows in data table. 
     If you have a WHERE clause in your query, make sure you mirror it here.
  */
  $query = "SELECT COUNT(*) as num FROM $tbl_name WHERE (type LIKE 'scholie') AND status = 1";
  $total_pages = mysql_fetch_array(mysql_query($query));
  $total_pages = $total_pages[num];
  
  /* Setup vars for query. */
  $targetpage = "index.php";  //your file name  (the name of this file)
  $limit = 10;                //how many items to show per page
  $page = $_GET['page'];
  if($page) 
    $start = ($page - 1) * $limit;      //first item to display on this page
  else
    $start = 0;               //if no page var is given, set start to 0
  
  /* Get data. */
  $sql = "SELECT * from produkte WHERE (type LIKE 'scholie') AND status = 1 order by n desc LIMIT $start, $limit";
  
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  

    /* Setup page vars for display. */
  if ($page == 0) $page = 1;          //if no page var is given, default to 1.
  $prev = $page - 1;              //previous page is page - 1
  $next = $page + 1;              //next page is page + 1
  $lastpage = ceil($total_pages/$limit);    //lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;            //last page minus 1
  
  /* 
    Now we apply our rules and draw the pagination object. 
    We're actually saving the code to a variable in case we want to draw it more than once.
  */
  $pagination = "";
  if($lastpage > 1)
  { 
    $pagination .= "<div class=\"pagination\">";
    //previous button
    if ($page > 1) 
      $pagination.= "<a href=\"$targetpage?page=$prev\">&laquo; zur&uuml;ck</a>";
    else
      $pagination.= "<span class=\"disabled\">&laquo; zur&uuml;ck</span>";  
    
    //pages 
    if ($lastpage < 7 + ($adjacents * 2)) //not enough pages to bother breaking it up
    { 
      for ($counter = 1; $counter <= $lastpage; $counter++)
      {
        if ($counter == $page)
          $pagination.= "<span class=\"current\">$counter</span>";
        else
          $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";         
      }
    }
    elseif($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
    {
      //close to beginning; only hide later pages
      if($page < 1 + ($adjacents * 2))    
      {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
        {
          if ($counter == $page)
            $pagination.= "<span class=\"current\">$counter</span>";
          else
            $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";         
        }
        $pagination.= "...";
        $pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
        $pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";   
      }
      //in middle; hide some front and some back
      elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
      {
        $pagination.= "<a href=\"$targetpage?page=1\">1</a>";
        $pagination.= "<a href=\"$targetpage?page=2\">2</a>";
        $pagination.= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
        {
          if ($counter == $page)
            $pagination.= "<span class=\"current\">$counter</span>";
          else
            $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";         
        }
        $pagination.= "...";
        $pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
        $pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";   
      }
      //close to end; only hide early pages
      else
      {
        $pagination.= "<a href=\"$targetpage?page=1\">1</a>";
        $pagination.= "<a href=\"$targetpage?page=2\">2</a>";
        $pagination.= "...";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
        {
          if ($counter == $page)
            $pagination.= "<span class=\"current\">$counter</span>";
          else
            $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";         
        }
      }
    }
    
    //next button
    if ($page < $counter - 1) 
      $pagination.= "<a href=\"$targetpage?page=$next\">vor &raquo;</a>";
    else
      $pagination.= "<span class=\"disabled\">vor &raquo;</span>";
    $pagination.= "</div>\n";   
  }

//$sql = "SELECT * from produkte WHERE (type LIKE 'scholie') AND status = 1 order by n desc";
//$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

	echo "<table class='schriften_table'>";

while($entry = mysql_fetch_array($result))
{
  $id = $entry[id];
  
  //check, if there is a image in the salon folder
	$img = 'http://www.scholarium.at/schriften/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://www.scholarium.at/schriften/default.jpg";
	}
	
?>
		<tr>
			<td class="schriften_table_a">
				<a href="<? echo "?q=$id";?>"><img src="<?echo $img_url;?>" alt="Cover <?echo $id;?>"></a>
			</td>			
			<td class="schriften_table_b">
				<span><? echo ucfirst($entry[type]);?></span><br>
      			<? echo "<a href='?q=$id'>".$entry[title]." </a>"; ?>
      			<p>
      				<? 	$text1 = wordwrap($entry[text], 500, "\0");
						$short_text = preg_replace('/^(.*?)\0(.*)$/is', '$1', $text1);
      				
      					if (strlen($entry[text]) > 500) {
							echo $short_text;
              echo '...';
						}
						else {
							echo $entry[text];
						}?>
				</p>
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
      
    <tr><td colspan="3"> <div class="centered"><p class='linie'><img style='height: 35px' src='../style/gfx/linie.png' alt=''></p></div></td></tr>


<?php
	}
	echo "</table>";
  	echo $pagination;
  	}
  }
}
?>

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Bestellen und Herunterladen</h2>
      </div>
      <div class="modal-body">
        <p>Wir freuen uns, dass Sie eines unserer Scholienb&uuml;chlein bestellen m&ouml;chten. Unser Webshop, &uuml;ber den alle Scholien entweder bestellt oder in allen digitalen Formaten f&uuml;r Leseger&auml;te heruntergeladen werden k&ouml;nnen, steht allerdings nur unseren G&auml;sten zur Verf&uuml;gung, die einen kleinen Kostenbeitrag (mindestens 6,25&euro; im Monat) f&uuml;r das Bestehen des <i>scholarium</i> leisten (und daf&uuml;r die meisten Schriften kostenlos beziehen k&ouml;nnen). K&ouml;nnen Sie sich das leisten? Dann folgen Sie diesem Link und in K&uuml;rze erhalten Sie Zugriff auf unsere Scholienb&uuml;chlein</p>
      </div>
      <div class="modal-footer">
        <a href="../spende/"><button type="button" class="inputbutton">Besuchen Sie uns als Gast</button></a>
      </div>
    </div>
  </div>
</div>

<?php include('_footer.php'); ?>