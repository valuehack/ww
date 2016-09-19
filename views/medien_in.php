<?
include_once("../down_secure/functions.php");
require_once('../classes/Login.php');

#####################################
#        Redirect to stream         #
#####################################

# if the user has bought the stream, directly redirect him to the stream view

if($_GET['stream'] != true) {
	
$id = $_GET['q'];

$product_info = $general->getProduct($id);
$event_id = $product_info->n;
$event_reg = $general->getEventReg($_SESSION['user_id'],$event_id);

	if($event_reg->format == 'Stream') {
		header('Location: index.php?q='.$id.'&stream=true');
	}
}

$title="Medien";
include "_header_in.php";

echo '<div class="content">';

if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}

if(isset($_POST['add'])){

  $add_id = $_POST['add'];
  $add_quantity = $_POST['quantity'];
  $add_code = $add_id . "0";
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

#####################################
# Single Event View + Registration  #
#####################################

if(isset($_GET['q']) && !isset($_GET['stream']))
{
  $id = $_GET['q'];

  //Mediendetails
  $product_info = $general->getProduct($id);
  
  if ($product_info->price_book != '' && $product_info->livestream != '') {
  	$price = $product_info->price_book;
  }
  else {
  	$price = $product_info->price;
  }

  //Userdetails
  $user_info = $general->getUserInfo($user_id);
  
  //Registration details
  $reg_info = $general->getEventReg($user_id, $product_info->n);

  $expired = strtotime($user_info->Ablauf);
  	
	################## No valid product ##################
    
	if ($product_info->status == 0) {
  	echo '<div class="salon_head"><p class="salon_date">Diese Aufzeichnung wurde nicht gefunden.</p></div>';
    }
	
	################### Valid product ####################
	
	else {
	
?>
  	<div class="content-area centered">
  		<h2><?=$product_info->title?></h2>
  	</div>	
		
	<div class="medien_seperator">
		<h1>Inhalt</h1>
	</div>
	<div class="medien_content">
<?php 
  		if ($product_info->text) echo "<p>".$product_info->text."</p>";
  		if ($product_info->text2) echo "<p>".$product_info->text2."</p>";
?>		
		<div class="sinfo centered">
			<?
			if ($_SESSION['Mitgliedschaft'] == 1) {
				if ($reg_info->quantity >= 1) {
    					echo '<p class="content-elm">Sie haben diesen Artikel bereits erworben. In <a href="../spende/bestellungen.php">Ihrer Bestell&uuml;bersicht</a> k&ouml;nnen Sie Ihre vergangenen Bestellungen einsehen und gegebenenfalls nochmals herunterladen.</p>';
    				}
			?>
				<input type="button" value="Herunterladen" class="inputbutton" data-toggle="modal" data-target="#myModal" <?if ($reg_info->quantity >= 1) echo 'disabled'?>>
			<?
			}
			else { 
		         if ($reg_info->quantity >= 1){
		    ?>
		    		<p class="content-elm">Sie haben diesen Artikel bereits erworben. In <a href="../spende/bestellungen.php">Ihrer Bestell&uuml;bersicht</a> k&ouml;nnen Sie Ihre Bestellungen einsehen und gegebenenfalls nochmals herunterladen.</p>
		    <?     	
		         }				 
				 if ($product_info->type === 'media-privatseminar' || $product_info->livestream != '') {
				 	if ($expired < time()) {
?>
						<p class="content-elm error">
							Ihre letzte Unterst&uuml;tzung ist mehr als ein Jahr her. <a href="../spende/">Bitte unterst&uuml;tzen Sie uns erneut.</a> Anschlie&szlig;end k&ouml;nnen Sie diesen Stream buchen.
						</p>
<?php
					}
					elseif ($user_info->credits_left < $price) {
?>
						<p class="content-elm error">
							Leider reicht Ihr Guthaben nicht aus, um diese Aufzeichnung zu erwerben. <a href="../spende/">Bitte unterst&uuml;tzen Sie uns erneut, um weiteres Guthaben zu erhalten.</a>
						</p>
<?php
				 }
?>
				 <form method="post" action="<?echo htmlentities('index.php?q='.$id)?>">
					<input type="hidden" name="product[format]" value="Stream">
					<input type="hidden" name="product[event_id]" value="<?=$product_info->n?>">
					<input type="hidden" name="product[quantity]" value="1">			 
					<input type="submit" class="inputbutton" name="oneClickReg" value="Aufzeichnung ansehen und/oder MP3-Datei herunterladen (<?=$price?> Guthabenpunkte)" <?if ($user_info->credits_left < $price || $expired < time()) echo 'disabled'?>>
				 </form>
<?php
				 }
				 else {
			?>
				<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      				<input type="hidden" name="add" value="<?=$product_info->n?>">
      				<input type="hidden" name="quantity" value="1">
              		<input type="submit" class="inputbutton" value="Herunterladen" <? if($reg_info->quantity >= 1) echo "disabled"?>>
    			</form>   			    			
    		<?
				}
?>
				<span class="coin-span"><?=$price?></span><img class="coin-span__img" src="../style/gfx/coin.png">
<?php
			}
			?>
		</div>
  		<div class="medien_anmeldung"><a href='<?echo htmlentities($_SERVER['PHP_SELF']);?>'>zur&uuml;ck zu den Medien</a></div>
	</div>
<?php
	}
}

#####################################
#           Stream View             #
#####################################

elseif(isset($_GET['q']) && $_GET['stream'] === 'true') {
	
	$id = $_GET['q'];
	$product_info = $general->getProduct($id);
	$reg_info = $general->getEventReg($_SESSION['user_id'], $product_info->n);
	$file_path = 'http://www.scholarium.at/down_secure/content_secure/'.$product_info->id.'.mp3';
	
	if ($product_info->livestream) {
	
		if ($reg_info->format === 'Stream') {
			
			$livestream = substr($product_info->livestream,32);
			$begleit_pdf = '../privatseminar/'.$product_info_info->id.'.pdf';
?>	
	<div class="content-area">
		<div class="centered">
			<h2><?=$product_info->title?></h2>
		</div>
		<div class="centered">
			<iframe width="100%" height="500" src="https://www.youtube.com/embed/<?=$livestream?>?rel=1&modestbranding=1" frameborder="0" allowfullscreen></iframe>
		</div>
		<div class="centered">
			<a href="<?php downloadurl($file_path,$product_info->id);?>" onclick="updateReferer(this.href);"> <button type="button" class="inputbutton">Audio-Aufzeichnung des Salons als MP3-Datei herunterladen</button></a>
		</div>
<?php
		if (file_exists($begleit_pdf)) {
?>
		<div class="sinfo">
			<a class="sinfo-link" href="<?=$begleit_pdf?>" onclick="openpopup(this.href); return false">Unterlagen zur Veranstaltung</a> 
		</div>
<?php
		}
?>
	</div>
<?php
		}
		else {
?>
	<div class="content-area">
		<div class="centered content-elm">
			<h2><?=$product_info->title?></h2>
		</div>
		<div class="centered content-elm">
			<p>Wir freuen uns &uuml;ber Ihr Interesse an dieser Aufzeichnung. Diese steht Ihnen, <a href="index.php?q=<?=$id?>">nachdem Sie sie erworben haben</a>, an dieser Stelle zur Verf&uuml;gung.</p>
		</div>
	</div>
<?php	
		}
	}
	else {
?>
		<div class="salon_head"><p class="salon_date">F&uuml;r diese Aufzeichnung gibt es keinen Livestream.</p></div>
<?php
		
	}
}    
else {
	
  if ($_SESSION['Mitgliedschaft'] == 1) {
  ?>       
  	<div class='medien_info'>
  		<?php
				$static_info = $general->getStaticInfo('medien');

				echo $static_info->info;		
			?>
		<div class="centered">
			<a class="blog_linkbutton" href="../spende/">Unterst&uuml;tzen & Zugang erhalten</a>
		</div>
   </div>

  <?
  } 
  elseif ($_SESSION['Mitgliedschaft'] > 1) {
  
	if(isset($_GET['type']))
	{	
	include('../medien/medien_data.php');
	}
	else {
  ?>
	<div class="medien_content">

<?php
	//Pagination Script found at http://www.phpeasystep.com/phptu/29.html
	$tbl_name="produkte";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 4;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE (type LIKE 'media%') AND status = 1";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	$targetpage = "index.php"; 	//your file name  (the name of this file)
	$limit = 8; 								//how many items to show per page
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$sql = "SELECT * from produkte WHERE (type LIKE 'media%') AND status = 1 order by n desc LIMIT $start, $limit";
	
	$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
	

	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
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
		if ($lastpage < 4 + ($adjacents * 2))	//not enough pages to bother breaking it up -7
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";
			}
		}
		elseif($lastpage > 2 + ($adjacents * 2))	//enough pages to hide some -5
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

echo "<table class='schriften_table'>";

while($entry = mysql_fetch_array($result))
{
  $id = $entry[id];    	
?>
		<tr>		
			<td class="schriften_table_b">
				<span><? echo ucfirst(substr($entry[type],6));?></span><br>
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
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Herunterladen</h2>
      </div>
      <div class="modal-body">
      	
      		<p>Wir freuen uns, dass Sie eine unserer Medien bestellen m&ouml;chten. Allerdings sind einige Aufnahmen nicht f&uuml;r die &Ouml;ffentlichkeit bestimmt. Unser Webshop, &uuml;ber den alle Medien heruntergeladen werden k&ouml;nnen, steht nur unseren G&auml;sten zur Verf&uuml;gung, die einen kleinen Kostenbeitrag (6,25&euro; im Monat) f&uuml;r das Bestehen des <i>scholarium</i> leisten (und daf&uuml;r die meisten Medien kostenlos beziehen k&ouml;nnen). K&ouml;nnen Sie sich das leisten? Dann folgen Sie diesem Link und in K&uuml;rze erhalten Sie Zugriff auf unsere Schriften:&nbsp;</p>
		
      </div>
      <div class="modal-footer">
         <a href="../spende/"><button type="button" class="inputbutton">Besuchen Sie uns als Gast</button></a>
      </div>
    </div>
  </div>
</div>

<? include "_footer.php"; ?>