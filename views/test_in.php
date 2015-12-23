<?php 
	//require_once('../classes/Login.php');
	$title="Test";
	include('_header_in.php'); 
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
			$event_title = $event_result->Titel;
			$event_type = $event_result->type;
			$event_start = $event_result->start;
			$event_end = $event_result->end;
			$event_price = $event_result->price;
			$event_spots = $event_result->spots;
			$event_spots_sold = $event_result->spots_sold;
			
			$event_spots_avaiable = $event_spots - $event_spots_sold;
			$event_date = $general->getDate($event_start, $event_end);
		?>
		
		<div>
			<h1><?=$event_title?></h1>
			<p><?=$event_date?></p>
			<p>
				<?=$event_price?><br><br>
				<?=$event_spots_avaiable?> = <?=$event_spots?> - <?=$event_spots_sold?>
			</p>
		</div>
		
<?php
			$pass_to = 'submit_full_info';
		
			if ($event_type === 'seminar') {
				$passed_from = 'seminar';
			}
			if ($event_type === 'projekt') {
				$passed_from = 'projekt';
			}
				
			include('../tools/form.php');
		}
		
		else {
			
			$events_query = $general->db_connection->prepare('SELECT * FROM produkte WHERE status = :status');
			$events_query->bindValue(':status', 2, PDO::PARAM_INT);
			$events_query->execute();
			
			$events_result = $events_query->fetchAll();
			
			for ($i = 0; $i < count($events_result); $i++) {
				
				$event_title = $events_result[$i]['Titel'];
				$event_id	= $events_result[$i]['id'];
				
				?>
				
				<div>
					<h1><a href="index.php?q=<?=$event_id?>"><?=$event_title?></a></h1>
				</div>
				
				<?php
			}
		}
?>
		
	</div>

<?php
	include('_footer.php');
?>