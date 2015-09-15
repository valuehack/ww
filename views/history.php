<?php 
include_once("../down_secure/functions.php");
// require_once('../classes/Login.php');
$title="Ihre K&auml;ufe";
include('_header_in.php'); 

$user_id = $_SESSION['user_id'];

$user_items_query = "SELECT * from registration WHERE `user_id`=$user_id";
$user_items_result = mysql_query($user_items_query) or die("Failed Query of " . $user_items_query. mysql_error());
$userItemsArray = mysql_fetch_array($user_items_result);

?> 
	<div class="content">
		<div class="profil">
			<h1>Ihre K&auml;ufe</h1>
		</div>
		<div class="medien_seperator">
			<h1>Ihre gebuchten Veranstaltungen</h1>
		</div>
		<div class="profil">
			<?php
			echo $userItemsArray;
			
			$n = $n;
			
			$user_events_query = "SELECT * from produkte WHERE `n` LIKE '$n' ORDER BY start DESC";
        	$user_events_result = mysql_query($user_events_query) or die("Failed Query of " . $user_events_query. mysql_error());
        	$userEventsArray = mysql_fetch_array($user_events_result);
			
			$title = $userEventsArray[title];
			$type = $userEventsArray[type];
			$id = $userEventsArray[id];
			$format = $userEventsArray[format];
			
			if ($type == 'seminar' || $type == 'kurs') {
				$url = 'http://scholarium.at/seminare/'.$id.'.jpg';
            	$url2 = 'seminare';
			}
			elseif ($type == 'salon') {
				$url = 'http://scholarium.at/salon/'.$id.'.jpg';
            	$url2 = 'salon';
			}
			
			switch ($format) { //think about - needs work
                case 0: if ($type == 'media-salon' || $type == 'media-vortrag') $extension = '.mp3';
                        if ($type == 'media-vorlesung') $extension = '.zip';
                        break;
                case 1: $extension = '.pdf'; break;
                case 2: $extension = '.epub'; break;
                case 3: $extension = '.mobi'; break;
                default: NULL; break;
            }
						
			$file_path = 'http://scholarium.at/down_secure/content_secure/'.$id.$extension;
			?>
			
			<div class="basket_body">
				<div class="basket_body_col_a">
					<div class="basket_body_col_a_1">
						<img src="<?=$url?>" alt="">
					</div>		
					<div class="basket_body_col_a_2">
						<span class="basket_body_type"><?=ucfirst($type)?></span>
						<span class="basket_body_title"><a href=""../<?=$url2?>/index.php?q=<?$id?>""><?=$title?></a></span>
					</div>
        		</div>	
				<div class="basket_body_col_b">
					<p>Reserviert</p>
					<a href="../tickets/ticket_<?=$user_id?>_<?=$type?>_<?$n?>.pdf">Ihr Ticket</a>
				</div>
				<div class="basket_body_col_c">
				</div>
			</div>
		</div>
		<div class="medien_seperator">
			<h1>Ihre gekauften Schriften und Medien</h1>
		</div>
		<div class="profil">
			<?php
			?>
		</div>	
	</div>
<?php include('_footer.php'); ?>