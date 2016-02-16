<?php 
include_once("../down_secure/functions.php");
dbconnect();
include("_db.php");
// require_once('../classes/Login.php');
$title="Ihre K&auml;ufe";
include('_header_in.php');

if(isset($_POST['delete'])) {
	$user_id = $_SESSION['user_id'];
	$user_email = $_SESSION['user_email'];
	$n = $_POST['event_id'];
	$quantity = $_POST['quantity'];
	$credits_add = $_POST['creditsadd'];
	$storno_time = $_POST['stornotime'];

	$delete = $pdocon->db_connection->prepare("UPDATE registration SET reg_notes = 'Cancel' WHERE user_id=$user_id and event_id=$n");
	//$delete->execute();

	$update_spots_sold = $pdocon->db_connection->prepare("UPDATE produkte SET spots_sold = spots_sold - $quantity WHERE n=$n");
	//$update_spots_sold->execute();

	$update_user_credit = $pdocon->db_connection->prepare("UPDATE mitgliederExt SET credits_left = credits_left + $credits_add WHERE user_id=$user_id");
	//$update_user_credit->execute();
	
	function sendStornoConfirmation($user_email)
    {
        //consturct email body
        $body = file_get_contents('/home/content/56/6152056/html/production/email_header.html');

        $body = $body.'
                    <img style="" class="" title="" alt="" src="http://scholarium.at/style/gfx/email_header.jpg" align="left" border="0" height="150" hspace="0" vspace="0" width="600">
                    <!--#/image#-->
                    </td>
                    </tr>
                    </tbody>
                    </table>
                    <!--#loopsplit#-->
                    <table class="editable text" border="0" width="100%">
                    <tbody>
                    <tr>
                    <td valign="top">
                    <div style="text-align: justify;">
                    <h2></h2>
                    <!--#html #-->
                    <span style="font-family: times new roman,times;">
                    <span style="font-size: 12pt;">
                    <span style="color: #000000;">
                    <!--#/html#-->
                    <br>            
                    Sie haben Ihre Buchung erfolgreich stoniert. 
                        ';

        $body = $body.'
                    <table cellspacing="0" cellpadding="0"><tr></tr></table> 
                    ';


        $body = $body.file_get_contents('/home/content/56/6152056/html/production/email_footer.html');


        //create curl resource
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_VERBOSE, true);

        curl_setopt($ch,CURLOPT_HTTPHEADER,array(SENDGRID_API_KEY));

        //set url
        curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/api/mail.send.json");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $post_data = array(
            'to' => $user_email,
            //'toname' => $user_profile[Vorname]." ".$user_profile[Nachname],
            'subject' => 'scholarium.at Stornierung Ihrer Veranstaltung',
            'html' => $body,
            'from' => 'info@scholarium.at',
            'fromname' => 'scholarium'
            );

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);

        // $output contains the output string
        $response = curl_exec($ch);

        if($response === '{"message":"success"}')
        {
            $that->messages[] = MESSAGE_STORNO_CONFIRMATION_MAIL_SUCCESSFULLY_SENT;

        }else 
        {
            $that->errors[] = MESSAGE_STORNO_CONFIRMATION_MAIL_FAILED; 
        }


        // //TODO - add here current
        // if(empty($response))
        // {
        //     die("Error: No response.");
        //     $this->errors[] = MESSAGE_PASSWORD_RESET_MAIL_FAILED;
        // }
        // elseif ('{"message":"success"}')
        // {
        //     $json = json_decode($response);
        //     // print_r($json->access_token);
        //     print_r(SENDGRID_API_KEY);
        //     // echo "<br>";
        //     $this->messages[] = MESSAGE_PASSWORD_RESET_MAIL_SUCCESSFULLY_SENT;
        //     file_put_contents('log.txt', $response);
        //     //$this->messages[] = $json;
        // }

        curl_close($ch);
    }
		
	sendStornoConfirmation($user_email);
}

$user_id = $_SESSION['user_id'];

$user_items_query_a = "SELECT * from registration WHERE `user_id`=$user_id";
$user_items_result_a = mysql_query($user_items_query_a) or die("Failed Query of " . $user_items_query_a. mysql_error());

$user_items_query_b = "SELECT * from registration WHERE `user_id`=$user_id";
$user_items_result_b = mysql_query($user_items_query_b) or die("Failed Query of " . $user_items_query_b. mysql_error());

$user_items_query_c = "SELECT * from registration WHERE `user_id`=$user_id";
$user_items_result_c = mysql_query($user_items_query_c) or die("Failed Query of " . $user_items_query_c. mysql_error());

$user_items_query_d = "SELECT * from registration WHERE `user_id`=$user_id";
$user_items_result_d = mysql_query($user_items_query_d) or die("Failed Query of " . $user_items_query_d. mysql_error());

?> 
	<div class="content">
		<div class="history">
			<h1>&Uuml;bersicht Ihrer Bestellungen</h1>
		</div>
		<div class="medien_seperator">
			<h1>Ihre Veranstaltungen</h1>
		</div>
		<div class="history">
			<div class="basket_head">
				<div class="basket_head_col_a"></div>
				<div class="basket_head_col_b">Status</div>
				<div class="basket_head_col_c">Pl&auml;tze</div>
			</div>
			<?php
			while($userItemsArray_a = mysql_fetch_array($user_items_result_a)){
			
			$n = $userItemsArray_a[event_id];
			$quantity = $userItemsArray_a[quantity];
			$format = $userItemsArray_a[format];
			
			$user_events_query = "SELECT * from produkte WHERE `n` LIKE '$n' ORDER BY start DESC";
        	$user_events_result = mysql_query($user_events_query) or die("Failed Query of " . $user_events_query. mysql_error());
        	$userEventsArray = mysql_fetch_array($user_events_result);
			
			$title = $userEventsArray[title];
			$type = $userEventsArray[type];
			$id = $userEventsArray[id];
			$price = $userEventsArray[price];
			
			
				if ($type == 'seminar' || $type == 'kurs' || $type == 'salon' || $type == 'privatseminar'){
			
					if ($type == 'seminar' || $type == 'kurs') {
					$url = 'http://scholarium.at/seminare/'.$id.'.jpg';
            		$url2 = 'seminare';
					}
					elseif ($type == 'salon') {
					$url = 'http://scholarium.at/salon/'.$id.'.jpg';
            		$url2 = 'salon';
					}
					elseif ($type =='privatseminar') {
					$url2 = 'privatseminar';
					}
			
			$event_start = $userEventsArray[start];
			$storno_time = strtotime($event_start)-time();
			$storno_time = $storno_time/86400;
			
			$checkMessage = "Sind Sie sicher? Mit einem Klick auf OK wird Ihre Buchung stoniert.";
			
			if ($storno_time > 14) {$credits_add = $price*$quantity;}
			if ($storno_time <= 14 && $storno_time > 7) {
				$credits_add = ($price*$quantity)*0.7;
				$checkMessage = $checkMessage."\n\nFür die Stornierung fällt eine Gebühr von 30% des Veranstaltungspreises an.";
			}
			if ($storno_time <= 7 && $storno_time > 2) {
				$credits_add = ($price*$quantity)*0.5;
			$checkMessage = $checkMessage."\n\nFür die Stornierung fällt eine Gebühr von 50% des Veranstaltungspreises an.";
			}
			if ($storno_time <= 2) {
				$credits_add = 0;
				$checkMessage = $checkMessage."\n\nFür die Stornierung fällt eine Gebühr von 100% des Veranstaltungspreises an.";
			}
											
			?>

			<div class="basket_body">
				<div class="basket_body_col_a">
					<div class="basket_body_col_a_1">
						<img src="<?=$url?>" style="max-width:75px;max-height:75px;" alt="">
					</div>		
					<div class="basket_body_col_a_2">
						<span class="history_body_type"><?=ucfirst($type)?></span>
						<span class="history_body_title"><a href="../<?=$url2?>/index.php?q=<?=$id?>"><?=$title?></a></span>
						<?php if($type == 'salon') echo '<span class="history_body_format">'.$format.'</span>';?>
					</div>
        		</div>	
				<div class="basket_body_col_b">
					<p>
						<?
						if ($quantity == 1) echo "1 Platz";
						if ($quantity > 1) echo $quantity." Pl&auml;tze";
						?>
					</p>
				</div>
				<div class="basket_body_col_c">
					<span class="history_reservation">Reserviert</span>
					<p>
<?php
					if($format == 'Stream' && $type == 'salon') {
						echo '<a href="../salon/index.php?q='.$id.'&stream=true">Zum Stream</a>';
					}
					elseif ($format == 'Stream' && $type == 'privatseminar') {
						echo '<a href="../privatseminar/index.php?stream=true">Zum Stream</a>';
					}
					else {
						echo '<a href="../tickets/ticket_'.$user_id.'_'.ucfirst($type).'_'.$n.'.pdf">Ihr Ticket</a>';
					}
?>
					</p>
					<p>
						<form action="<?echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
							<input type="hidden" name="delete" value="1">
							<input type="hidden" name="event_id" value="<?=$n?>">
							<input type="hidden" name="quantity" value="<?=$quantity?>">
							<input type="hidden" name="creditsadd" value="<?=$credits_add?>">
							<input type="hidden" name="stornotime" value="<?=$storno_time?>">
							<!--<input class="history-btn--plain" type="submit" value="Reservierung stornieren" onClick="return checkMe()">-->
						</form>
					</p>							
				</div>
			</div>
		<?
			}
		}
		?>
		</div>
		<div class="medien_seperator">
			<h1>Ihre Schriften und Medien</h1>
		</div>
		<div class="history">
			<div class="basket_head">
				<div class="basket_head_col_a"></div>
				<div class="basket_head_col_b"></div>
				<div class="basket_head_col_c">Download</div>
			</div>
			<?php
			while($userItemsArray_b = mysql_fetch_array($user_items_result_b)){
			
			$n = $userItemsArray_b[event_id];
			$format =$userItemsArray_b[format];
			
			$user_products_query = "SELECT * from produkte WHERE `n` LIKE '$n' ORDER BY start DESC";
        	$user_products_result = mysql_query($user_products_query) or die("Failed Query of " . $user_products_query. mysql_error());
        	$userProductsArray = mysql_fetch_array($user_products_result);
			
			$title = $userProductsArray[title];
			$type = $userProductsArray[type];
			$id = $userProductsArray[id];
			
			
				if ($type == 'scholie' || $type == 'analyse' || $type == 'buch' || substr($type,0,5) == 'media'){
			
					if ($type == 'scholie' || $type == 'analyse' || $type == 'buch') {
					$url = 'http://scholarium.at/schriften/'.$id.'.jpg';
            		$url2 = 'schriften';
					if ($format == 'PDF') $extension = '.pdf';
					if ($format == 'Kindle') $extension = '.mobi';
					if ($format == 'ePub') $extension = '.epub';
					}
					elseif (substr($type,0,5) == 'media') {
					$url = 'http://scholarium.at/medien/'.$id.'.jpg';
            		$url2 = 'medien';
					if ($type == 'media-salon' || $type == 'media-vortrag') $extension = '.mp3';							
                    if ($type == 'media-vorlesung') $extension = '.zip';
                    $type = ucfirst(substr($type,6));
					}			
						
					$file_path = 'http://www.scholarium.at/down_secure/content_secure/'.$id.$extension;
			?>
			<div class="basket_body">
				<div class="basket_body_col_a">
					<div class="basket_body_col_a_1">
						<img src="<?=$url?>" style="max-width:75px;max-height:75px;" alt="">
					</div>		
					<div class="basket_body_col_a_2">
						<span class="history_body_type"><?=ucfirst($type)?></span>
						<span class="history_body_title"><a href="../<?=$url2?>/index.php?q=<?=$id?>"><?=$title?></a></span>
						<span class="history_body_format"><?=$format?></span>
					</div>
        		</div>	
				<div class="basket_body_col_b">
					&nbsp;
				</div>
				<div class="basket_body_col_c">
					<?php
					if ($format == 'Druck'){
						echo '&nbsp;';
					}
					elseif ($format == 'Stream') {
						echo '<p><a href="../medien/index.php?q='.$id.'&stream=true">Zur Aufzeichnung</a></p>';
					}
					else {?>					
					<p><a href="<?php downloadurl($file_path,$id);?>" onclick="updateReferer(this.href)";>Herunterladen</a></p>
					<?php
					}
					?>
				</div>
			</div>
		<?
			}
		}
		?>
		</div>
		<div class="medien_seperator">
			<h1>Ihre Spenden und Programme</h1>
		</div>	
		<div class="history">
			<h2>Spenden</h2>			
			<div class="basket_head">
				<div class="basket_head_col_a"></div>
				<div class="basket_head_col_b">Status</div>
				<div class="basket_head_col_c">Ihre Spende</div>
			</div>
			<?php
			while($userItemsArray_c = mysql_fetch_array($user_items_result_c)){
			
			$n = $userItemsArray_c[event_id];
			
			$user_donations_query = "SELECT * from produkte WHERE `n` LIKE '$n' ORDER BY start DESC";
        	$user_donations_result = mysql_query($user_donations_query) or die("Failed Query of " . $user_donations_query. mysql_error());
        	$userDonationsArray = mysql_fetch_array($user_donations_result);
			
			$title = $userDonationsArray[title];
			$type = $userDonationsArray[type];
			$id = $userDonationsArray[id];
			$donation = $userItemsArray_c[quantity];
			$donated = $userDonationsArray[spots_sold];
			$needed = $userDonationsArray[spots];
			
				if ($type == 'projekt') {
					$url2 = 'projekte';
			?>
			<div class="basket_body">
				<div class="basket_body_col_a">
					<div class="basket_body_col_a_1">
					</div>		
					<div class="basket_body_col_a_2">
						<span class="history_body_title"><a href="../<?=$url2?>/index.php?q=<?=$id?>"><?=$title?></a></span>
					</div>
        		</div>	
				<div class="basket_body_col_b">
					<?=$donation?>					
				</div>
				<div class="basket_body_col_c">
					<? 
					if ($donated == $needed) {
						echo $donated." / ".$needed."<br>Projekt in Umsetzung";
					}
					else {
						echo $donated." / ".$needed;
					}
					?>					
				</div>
			</div>
		<?
			}
		}
		?>
			<h2>Programme</h2>
			<div class="basket_head">
				<div class="basket_head_col_a"></div>
				<div class="basket_head_col_b">Status</div>
				<div class="basket_head_col_c">Pl&auml;tze</div>
			</div>
			<?php
			while($userItemsArray_d = mysql_fetch_array($user_items_result_d)){
			
			$n = $userItemsArray_d[event_id];
			$quantity = $userItemsArray_d[quantity];

			$user_programs_query = "SELECT * from produkte WHERE `n` LIKE '$n' ORDER BY start DESC";
        	$user_programs_result = mysql_query($user_programs_query) or die("Failed Query of " . $user_programs_query. mysql_error());
        	$userProgramsArray = mysql_fetch_array($user_programs_result);
			
			$title = $userProgramsArray[title];
			$type = $userProgramsArray[type];
			$id = $userProgramsArray[id];
			
				if ($type == 'programm') {
					$url2 = 'programme';
			?>
			<div class="basket_body">
				<div class="basket_body_col_a">
					<div class="basket_body_col_a_1">
					</div>		
					<div class="basket_body_col_a_2">
						<span class="history_body_title"><a href="../<?=$url2?>/index.php?q=<?=$id?>"><?=$title?></a></span>
					</div>
        		</div>	
				<div class="basket_body_col_b">
					<p>
						<?
						if ($quantity == 1) echo "1 Platz";
						if ($quantity > 1) echo $quantity." Pl&auml;tze";
						?>
					</p>					
				</div>
				<div class="basket_body_col_c">
					Gebucht			
				</div>
			</div>
		<?
			}
		}
		?>
		</div>
	</div>
<?php include('_footer.php'); ?>

<script type="text/javascript">

function checkMe() {
    if (confirm("<?echo $checkMessage;?>")) {
        return true;
    } else {
        return false;
    }
}

</script>