<?php
require_once('../classes/Login.php');

#####################################
#        Redirect to stream         #
#####################################

# if the user has alreday registered for the stream, directly redirect him to the stream view

if($_GET['stream'] != true) {
	
$id = $_GET['q'];

$salon_info = $general->getProduct($id);
$event_id = $salon_info->n;
$event_reg = $general->getEventReg($_SESSION['user_id'],$event_id);

	if($event_reg->format == 'Stream') {
		header('Location: index.php?q='.$id.'&stream=true');
	}
}

$title="Salon";
include "_header_in.php";

if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}

if(isset($_POST['add'])){

  $add_id = $_POST['add'];
  $add_quantity = $_POST['quantity'];
  $add_format = $_POST['sformat'];
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

#####################################
# Single Event View + Registration  #
#####################################

if(isset($_GET['q']) && !isset($_GET['stream']))
{
  $id = $_GET['q'];
  $test = $_GET['test'];

  //Termindetails  	
  $salon_info = $general->getProduct($id);
  
  $event_id = $salon_info->n;
  $title = $salon_info->title;
  $price = $salon_info->price;
  $price2 = $salon_info->price_book;
  $spots_total = $salon_info->spots;
  $spots_available = $spots_total - $salon_info->spots_sold;
  $livestream = $salon_info->livestream;
  $status = $salon_info->status;
  
  $date = $general->getDate($salon_info->start, $salon_info->end);
  if($price2 != '') {
  	$streamprice = $price2;
  }
  else {
	$streamprice = $price;
  }
  
  //Userdetails
  $user_id = $_SESSION['user_id'];
  $user_itm_info = $general->getEventReg($user_id, $event_id);
  $quantity = $user_itm_info->quantity;
  $format = $user_itm_info->format;
  
  
    ################## No valid Event ##################
    
	if ($status == 0) {
  	echo '<div class="salon_head"><p class="salon_date">Es wurde keine Veranstaltung gefunden.</p></div>';
    }
	
	################### Valid Event ####################
	
    else {  
?>
    <div class="content">
  		<div class="salon_head">
  			<h1><?=$title?></h1>
			<p class="salon_date">
      			<?=$date?>
      		</p>
      	</div>
      	
      	<?php
	##################### Event Info ###################
?>	

  		<div class="salon_seperator">
			<h1>Inhalt und Informationen</h1>
		</div>
		<div class="salon_content">
  		<?php
  			if ($salon_info->text) echo "<p>$salon_info->text</p>";
  			if ($salon_info->text2) echo "<p>$salon_info->text2</p>";

			$static_info = $general->getStaticInfo('salon');
			echo $static_info->info			
			?>
			
  			<div class="medien_anmeldung"><a href="<?php htmlentities($_SERVER['PHP_SELF'])?>">zur&uuml;ck zu den Salons</a></div>
	
  			<div class="centered">
    			<div class="salon_reservation">
<?php

		###################### Reg Form ####################
		
		# Offener Salon
		
		if($spots_total > 59) {
			
			if(isset($livestream)) {
?>
				<div class="sinfo">
					<h5>Im Stream</h5>
					
					<p>
<?php		
						if($quantity >= 1 && $format == 'Stream') {
							echo 'Sie haben sich f&uuml;r diese Veranstaltung bereits registriert.<br><br>';
						}
?>						
					</p>	
								
					<form action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" method="post">
      					<input type="hidden" name="profile[event_id]" value="<?=$event_id?>">      
						<input type="hidden" name="profile[quantity]" value="1"> 
						<input type="hidden" name="sformat" value="2">
      					<input class="inputbutton" type="submit" name="register_open_salon" value="Reservieren" <? if($quantity >= 1) echo "disabled"?>><br>     
    				</form>
					<span class="coin-span"><?=$streamprice?></span> &euro;

    			</div>
<?php
			}
?>
			<div class="sinfo">
				<h5>Vor Ort</h5>
					
					<p>
<?php		
						echo 'F&uuml;r unseren Offenen Salon ist nur Barzahlung vor Ort m&ouml;glich. Der Eintritt kostet 5&euro; pro Teilnehmer. Mit dem Klick auf &quot;Reservieren&quot; werden Sie unmittelbar eingetragen.<br><br>';

						if($quantity >= 1 && $format == 'vorOrt') {
							echo 'Sie haben bereits sich f&uuml;r diese Veranstaltung bereits registriert ('.$quantity.' Ticket(s)).<br><br>';
						}
						if($spots_available == 0) {
  							echo 'Die Pl&auml;tze vor Ort sind leider ausgebucht, sie k&oumlnnen stattdessen per Livestream dazu kommen.';
						}
?>					
					</p>
					<p>Anzahl gew&uuml;nschter Teilnehmer:</p>
					
			    	<form action="<?php htmlentities($_SERVER['PHP_SELF'])?>" method="post">
      					<input type="hidden" name="profile[event_id]" value="<?=$event_id?>">
      					<input type="hidden" name="profile[sformat]" value="1">      
      					<select class="input-select" name="profile[quantity]" onchange="changePrice(this.value,'<?=$price?>')">>
      					<?php
		  					if ($spots_available == 0){echo '<option value="0">0</option>';}
		  					if ($spots_available >= 1){echo '<option value="1" selected>1</option>';}
		  					if ($spots_available >= 2){echo '<option value="2">2</option>';}
		  					if ($spots_available >= 3){echo '<option value="3">3</option>';}
		  					if ($spots_available >= 4){echo '<option value="4">4</option>';}
		  					if ($spots_available >= 5){echo '<option value="5">5</option>';}
		  				?>       
     					</select> 
      					<input class="inputbutton" type="submit" name="register_open_salon" value="Reservieren" <? if($spots_available == 0) echo "disabled"?>><br>     
    				</form>
  					<span id="change" class="coin-span"><?=$streamprice?></span> &euro;
  				</div>						
		<?php 
		}

		# Normal Form

		else {
						
			########## Reg Options For level 1 members #########
	
  			if ($_SESSION['Mitgliedschaft'] == 1) {
  	
			if ($quantity >= 1) {
				echo '<span class="salon_reservation_span_a">Sie haben sich f&uuml;r diese Veranstaltung bereits registriert.</span><br>';
			}	
  			if ($spots_available == 0){
  				echo '<span class="salon_reservation_span_a">Diese Veranstaltung ist leider ausgebucht.</span><br>';
  			}
			?>  
    		<!--Button trigger modal-->
    		<input class="salon_reservation_inputbutton" type="button" value="Reservieren" data-toggle="modal" data-target="#myModal" <?if($spots_available == 0){echo 'disabled';}?>>
    	
<?php
  			}
			
			######### Reg Options For level > 1 members ########
				
			else {	

			if(isset($livestream)) {
?>
				<div class="sinfo">
					<h5>Im Stream</h5>
					
					<p>
<?php		
						if($quantity >= 1 && $format == 'Stream') {
							echo 'Sie haben sich f&uuml;r diese Veranstaltung bereits registriert.<br><br>';
						}
?>						
					</p>	
								
					<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      					<input type="hidden" name="add" value="<?=$event_id?>">      
						<input type="hidden" name="quantity" value="1"> 
						<input type="hidden" name="sformat" value="2">
      					<input class="inputbutton" type="submit" value="Ausw&auml;hlen" <? if($quantity >= 1) echo "disabled"?>><br>     
    				</form>
					<span class="coin-span"><?=$streamprice?></span><img class="coin-span__img" src="../style/gfx/coin.png">

    			</div>
<?php
			}
?>
				<div class="sinfo">
					<h5>Vor Ort</h5>
					
					<p>
<?php		
						if($quantity >= 1 && $format == 'vorOrt') {
							echo 'Sie haben bereits sich f&uuml;r diese Veranstaltung bereits registriert ('.$quantity.' Ticket(s)).<br><br>';
						}
						if($spots_available == 0) {
  							echo 'Die Pl&auml;tze vor Ort sind leider ausgebucht, sie k&oumlnnen stattdessen per Livestream dazu kommen.';
						}
?>					
					</p>
					<p>Anzahl gew&uuml;nschter Teilnehmer:</p>
					
			    	<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      					<input type="hidden" name="add" value="<?=$event_id?>">
      					<input type="hidden" name="sformat" value="1">      
      					<select class="input-select" name="quantity" onchange="changePrice(this.value,'<?=$price?>')">>
      					<?php
		  					if ($spots_available == 0){echo '<option value="0">0</option>';}
		  					if ($spots_available >= 1){echo '<option value="1" selected>1</option>';}
		  					if ($spots_available >= 2){echo '<option value="2">2</option>';}
		  					if ($spots_available >= 3){echo '<option value="3">3</option>';}
		  					if ($spots_available >= 4){echo '<option value="4">4</option>';}
		  					if ($spots_available >= 5){echo '<option value="5">5</option>';}
		  				?>       
     					</select> 
      					<input class="inputbutton" type="submit" value="Ausw&auml;hlen" <? if($spots_available == 0) echo "disabled"?>><br>     
    				</form>
  					<span id="change" class="coin-span"><?=$price?></span><img class="coin-span__img" src="../style/gfx/coin.png">							
  				</div>
<?php
		}
  	}
?>
			</div>
			</div>		
		</div>	

<?php
	}
}

#####################################
#           Stream View             #
#####################################

elseif($_GET['stream'] === 'true') {
	
	$now = date('d.m.Y H:M', time());
	
	$ps_query = $general->db_connection->prepare('SELECT * FROM producte WHERE type LIKE :type AND end > :end');
	$ps_query->bindValue(':type', 'privatseminar', PDO::PARAM_STR);
	$ps_query->bindValue(':end', $now, PDO::PARAM_STR);
	$ps_query->execute();
	$ps_info = $ps_query->fetchObject();
	
	$getEventReg = $general->getEventReg($_SESSION['user_id'], $ps_info->event_id);
	
	if ($getEventReg->format === 'Stream') {
		
		$ps_info = $general->getProduct($id);
	
		$livestream = substr($ps_info->livestream,32);

		$begleit_pdf = 'http://www.scholarium.at/privatseminar/'.$id.'.pdf';

?>	
	<div class="content-area">
		<div class="centered">
			<h2><?=$ps_info->title?></h2>
		</div>
		<div class="centered">
			<iframe width="100%" height="500" src="https://www.youtube.com/embed/<?=$livestream?>" frameborder="0" allowfullscreen></iframe>
		</div>
<?php
		if (file_exists($begleit_pdf)) {
?>
		<div class="sinfo">
			<a href="<?=$begleit_pdf?>" target="_blank">Unterlagen zur Veranstaltung</a> 
		</div>
<?php
		}
?>
		<div class="chat-wrapper">
			<div id="mychat"><a href="http://www.phpfreechat.net">Creating chat rooms everywhere - phpFreeChat</a></div>
			<script type="text/javascript">
 				 $('#mychat').phpfreechat({ serverUrl: '../phpfreechat/server' });
			</script>
		</div>
	</div>
<?php
	}
	else {
		header('Loaction: index.php');
	}	
}

#####################################
#            Event List             #
#####################################

else {
?>		
	<div class="content">
		<?
		$static_info = $general->getStaticInfo('privatseminar');
	#für Interessenten (Mitgliedschaft 1) Erklärungstext oben
  	if ($_SESSION['Mitgliedschaft'] == 1) {
  		echo "<div class='salon_info'>";
			echo $static_info->info;	
	?>
			<div class="centered">
				<a class="blog_linkbutton" href="../abo/">Unterst&uuml;tzen & Zugang erhalten</a>
			</div>		
   		</div>
   <?
  }
  elseif ($_SESSION['Mitgliedschaft'] > 1) {
?>
		<div class="salon_info">
			<?=$static_info->info?>
		</div>
		<div class="salon_content">
			<div class="centered content-elm">
<?php
			#Think about best way to show and secure the stream
			if($ps_info->event_id && $format === 'Stream') {
?>
				<a href="index.php?stream=true">Zum Stream</a>
<?php
			}
			else {
?>
				<input type="submit" class="inputbutton" name="" value="F&uuml;r den n&auml;chsten Stream anmelden (10 Coins)">
<?php
			}
?>
			</div>
			<div>
				<div class="centered">
					<h3>Semester&uuml;bersicht</h3>
				</div>
				<ul class="list--none list">
<?
	$pss_query = $general->db_connection->prepare('SELECT * FROM produkte WHERE type LIKE :type AND start > NOW() AND status = :status ORDER by start asc');
	$pss_query->bindValue(':type', 'privatseminar', PDO::PARAM_STR);
	$pss_query->bindValue(':status', 1, PDO::PARAM_INT);
	$pss_query->execute();
	$pss_result = $pss_query->fetchAll();
		
	for ($i = 0; $i < count($pss_result); $i++) 
	{	
		$date = $general->getDate($pss_result[$i]['start'], $pss_result[$i]['end']);
      ?>
      				<li class="list-itm">
      					<?=$date?>: <b><?=$pss_result[$i]['title']?></b>
      				</li>
<?php
  	}
?>
				</ul>
  			</div>
  		</div>
  	<?php
  }
}    
?> 

<? include "_footer.php"; ?>