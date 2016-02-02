<?php 
	//require_once('../classes/Login.php');
	$title="Test";
	include('_header_not_in.php'); 
?>

	<div class="content">
		
<?php
		if(isset($_GET['q'])) 
		{
  			$id = $_GET['q'];
			
			$event_query = $general->db_connection->prepare('SELECT * FROM produkte WHERE id LIKE :id AND status = :status');
			$event_query->bindValue(':id', $id, PDO::PARAM_STR);
			$event_query->bindValue(':status', 2, PDO::PARAM_INT);
			$event_query->execute();
			
			$event_result = $event_query->fetchObject();
			
			$event_id = $event_result->n;
			$event_title = $event_result->title;
			$event_type = $event_result->type;
			$event_start = $event_result->start;
			$event_end = $event_result->end;
			$event_price = $event_result->price;
			$event_spots = $event_result->spots;
			$event_spots_sold = $event_result->spots_sold;
			
			$spots_available = $event_spots - $event_spots_sold;
			$event_date = $general->getDate($event_start, $event_end);
		?>
		
		<div>
			<h1><?=$event_title?></h1>
			<p><?=$event_date?></p>
			<p>
				<?=$event_price?><br><br>
				<?=$spots_available?> = <?=$event_spots?> - <?=$event_spots_sold?>
			</p>
		</div>
		
<?php
			$pass_to = 'submit_full_info';
			$action = htmlentities($_SERVER['PHP_SELF']);
		
			if ($event_type === 'seminar') {
				$passed_from = 'seminar';
			}
			if ($event_type === 'projekt') {
				$passed_from = 'projekt';
			}
				
			include('../tools/form.php');
			
?>
		<div class="profil">
		<form method="post" action="<?=htmlspecialchars('../abo/zahlung_neu.php?q=userinfo');?>">
<?php			
		if ($event_type === 'seminar') {
?>		
			<label for="quantity">Tickets</label>
		  	<select id="quantity" name="product[quantity]">
		  		<?php
		  		if ($spots_available == 0){echo '<option value="0" disabled>0</option>';}
		  		if ($spots_available >= 1){echo '<option value="1" selected>1</option>';}
		  		if ($spots_available >= 2){echo '<option value="2">2</option>';}
		  		if ($spots_available >= 3){echo '<option value="3">3</option>';}
		  		if ($spots_available >= 4){echo '<option value="4">4</option>';}
		  		if ($spots_available >= 5){echo '<option value="5">5</option>';}
		  		?>
		  	</select>
<?php
		}
		if ($event_type === 'projekt') {
?>
			<div class="projekte_investment">
            	<input type="radio" class="projekte_investment_radio" name="profile[level]" value="3" required>
              	150&euro;: Sie erhalten Zugriff auf die Scholien und andere Inhalte.<br><br>
              	<input type="radio" class="projekte_investment_radio" name="profile[level]" value="4">
              	300&euro;: Ab diesem Beitrag haben Sie als Scholar vollen Zugang zu allen unseren Inhalten und Veranstaltungen.<br><br>
              	<input type="radio" class="projekte_investment_radio" name="profile[level]" value="5">
              	600&euro;: Ab diesem Beitrag werden Sie Partner, wir f&uuml;hren Sie (au&szlig;er anders gew&uuml;nscht) pers&ouml;nlich mit Link auf unserer Seite an und laden Sie zu einem exklusiven Abendessen ein (oder Sie erhalten einen Geschenkkorb)<br><br>
              	<input type="radio" class="projekte_investment_radio" name="profile[level]" value="6">
              	1200&euro;: Ab diesem Beitrag nehmen wir Sie als Beirat auf und laden Sie zu unserer Strategieklausur ein.<br><br>
              	<input type="radio" class="projekte_investment_radio" name="profile[level]" value="7">
              	2400&euro;: Ab diesem Beitrag werden Sie Ehrenpr&auml;sident und bestimmen bis zu zweimal im Jahr ein Thema f&uuml;r das <i>scholarium</i>.<br>  
          	</div>
<?php
		}	  
?>	
			<input type="hidden" name="event_id" value="<?=$event_id?>">
			<input type="hidden" name="passed_from" value="<?=$passed_from?>">
			<input type="submit" class="profil_inputbutton" name="zahlung" value="Zur Zahlung">
		</form>
		</div>
<?php
		}

		elseif ($_GET['r'] == 'upgrade') {
			
			$pass_to = 'submit_full_info';
			$spots_available = 1;
			$passed_from = 'upgrade';
			
			$level[level] = $_GET['level'];
			
			echo $level[level];
			
			include('../tools/form.php');
		}
		
		else {
			
			$events_query = $general->db_connection->prepare('SELECT * FROM produkte WHERE status = :status');
			$events_query->bindValue(':status', 2, PDO::PARAM_INT);
			$events_query->execute();
			
			$events_result = $events_query->fetchAll();
			
			for ($i = 0; $i < count($events_result); $i++) {
				
				$event_title = $events_result[$i]['title'];
				$event_id	= $events_result[$i]['id'];
				
				?>
				
				<div>
					<h1><a href="index.php?q=<?=$event_id?>"><?=$event_title?></a></h1>
				</div>
				
				<?php
			}
			?>
			<div>
				<h1><a href="index.php?r=upgrade">Upgrade</a></h1>
			</div>
			<?php
		}
?>
		
	</div>

<?php
	include('_footer.php');
?>