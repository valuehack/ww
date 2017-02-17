<?php
require_once('../classes/Login.php');
$title="Themenwahl";
include ("_header_in.php");

#Post-Redirect-Get Method to prevent double form submission upon page refreshing
# buggy - needs to be fixed: no output before header function!
if (isset($_GET['kommentar-abgeschickt'])) { ?>
	
	<div class='basket_message'>Vielen Dank f&uuml;r Ihren Kommentar!</div>
	
<?php
	
	$latest_comment_id = $general->getIDLatestComment();
	
	header("refresh:0;url=/themenwahl/#kommentar-$latest_comment_id");
}

if (isset($_GET['kommentar-geloescht'])) { ?>
	
	<div class='basket_message'>Ihr Kommentar wurde gel&ouml;scht.</div>

<?php
	
	$latest_deleted_comment_id = $general->getIDLatestDeletedComment();
	
	header("refresh:0;url=/themenwahl/#kommentar-$latest_deleted_comment_id");
}

if (isset($_GET['vorschlag-einreichen'])) {
	
	header("refresh:0;url=?themenvorschlag-eingereicht");
}

if (isset($_GET['abstimmen'])) {
	
	header("refresh:0;url=?abstimmung-erfolgreich");
}

?>
<div class="content">

	<div class="medien_info">
		
<?php
	
# messages appear at the top if suggestion or vote was successful	
	if(isset($_GET['themenvorschlag-eingereicht'])){ ?>
		
		<div class='basket_message'>Vielen Dank f&uuml;r Ihren Themenvorschlag!<br>Wir melden uns bei Ihnen, sobald dieser zur Abstimmung bereitsteht.</div>
<?php
	}
	
	if(isset($_GET['abstimmung-erfolgreich'])){ ?>
		
		<div class='basket_message'>Vielen Dank!<br>Ihre Abstimmung wurde eingetragen.</div>

<?php } ?>
		
		<h1>Themenwahl</h1>

<?php  
		$topic_static = $general->getStaticInfo('themenwahl');
		#show first static_content - text		
		echo "<p>".$topic_static->info."</p>";
		
		$topic_info = $general->getTopic();
		
		#get $weight with amount of support because it is the same
		$mb_info = $general->getMembershipInfo ($mitgliedschaft);
		$weight = $mb_info['price'];
		
		//Userdetails
  		$user_info = $general->getUserInfo($user_id);
		$expired = strtotime($user_info->Ablauf);
		
		//User previous vote
		$previous_vote = $general->getLatestTopicReg ($user_id);
		
if ($_SESSION['Mitgliedschaft'] == 1) {
		
			foreach($topic_info as $row) {
    			$n = $row['n'];
    			$title = $row['title'];
				$amount = $row['amount'];
				$amount_barlength = min($amount, 3000); ?>
			
			<div>
				<dl>
					<dd class="barlength barlength-<?=$amount_barlength?>"><span class="topic_text">
						<?=$title?>: <?=$amount?></span></dd>
				</dl>				
			</div>
			<?php	} ?>
			

		<!--Button trigger modal-->
    		<input class="inputbutton themenwahl_btn" type="button" value="Abstimmen" data-toggle="modal" data-target="#myModal">
    <?php
    }
    else { ?>
    	
    	<!-- js-functions are in ../js/general.js -->
    	<script>
    	openAbstimmung();
    	openVorschlag();
    	</script>
    	
    	<!-- show static_content - texts 2&3 -->
    	<p><?=$topic_static->info1?></p>
    	<p><?=$topic_static->info2?></p>
    		
    	<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']), '?abstimmen'; ?>" name="themenwahl_form">
    	
		<?php foreach($topic_info as $row) {
    			$n = $row['n'];
    			$title = $row['title'];
				$amount = $row['amount'];
				$amount_barlength = min($amount, 3000); ?>
			
			<div>
				<dl>
					<dd class="barlength barlength-<?=$amount_barlength?>"><span class="topic_text">
						<?php if ($amount < 3000) { ?> 
						<input type="radio" class="topic_radio" name="themenwahl[thema_n]" value="<?=$n?>" required>
						<?php } ?>
						<?=$title?>: <?=$amount?></span></dd>
				</dl>				
			</div>
			<?php	} ?>
			<input type="hidden" name="themenwahl[weight]" value="<?=$weight?>">
			<input type="hidden" name="themenwahl[user_id]" value="<?=$user_id?>">
			
			<?php
		if ($expired < time()) { ?>
			
			<p>Ihre letzte Unterst&uuml;tzung liegt bereits l&auml;nger als ein Jahr zurück. Wir w&uuml;rden uns freuen, wenn Sie uns weiter unterst&uuml;tzen.
				Nach einer neuerlichen Spende k&ouml;nnen Sie auch wieder &uuml;ber unsere Forschungsthemen abstimmen, eigene Themenvorschl&auml;ge einreichen
				und einzelne Themen kommentieren. (<a href= "../spende">&rarr; zu den Unterst&uuml;tzungsm&ouml;glichkeiten</a>).</p>
	<?php
		}
		
		elseif ($user_info->Mahnstufe < 1) { ?>
			<p>Sie haben zuletzt f&uuml;r das Thema &bdquo;<?=$previous_vote->title?>&ldquo; abgestimmt. Nach einer neuerlichen Unterst&uuml;tzung
				ist eine Abstimmung wieder m&ouml;glich (<a href= "../spende">&rarr; zu den Unterst&uuml;tzungsm&ouml;glichkeiten</a>).</p>
	<?php
		}
	?>
			
			<div class="inline"><input type="submit" class="inputbutton" id="topic_button" name="themenwahl_submit" value="Mit <?=$weight?> Punkten abstimmen"></div>
			<div class="inline"><button class="inputbutton" id="open_abstimmung" <?if ($expired < time() || $user_info->Mahnstufe < 1) echo 'disabled'?>>F&uuml;r ein Thema abstimmen</button></div>
			<div class="inline"><button class="inputbutton" id="open_vorschlag" <?if ($expired < time()) echo 'disabled'?>>Eigenen Vorschlag einbringen</button></div>
		</form>
		
	
			
		
		
		<div class="suggestion">
		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']), '?vorschlag-einreichen'; ?>" name="themenwahl_suggestion_form">
        	<input id="suggestion_title" type="text" class="suggestion_inputfield" placeholder="Titel des Themenvorschlags" name="suggestion[title]" required><br>
        	<textarea class="suggestion_inputarea" id="suggestion_input" placeholder="Kurze Beschreibung des Themenvorschlags" rows="10" name="suggestion[description]"></textarea>
        	<input type="hidden" name="suggestion[user_id]" value="<?=$user_id?>">
        	<input type="submit" class="inputbutton" id="suggestion_inputbutton" name="suggestion_submit" value="Themenvorschlag abschicken">
		</form>
		</div>
		
<?php
		$comments_info = $general->getTopicComments();
		
			foreach($topic_info as $row) {
				$n = $row['n'];
				$id = $row['id'];
    			$title = $row['title'];
				$description = $row['description']; ?>
				
				<div id="themen_title">	
					<p><b class="fs20pt">Thema: <?=$title?></b><br>
					Beschreibung: <?=$description?></p>
				</div>
				
				<div id="kommentare-<?=$id?>">
<?php
				foreach ($comments_info as $value) {
					$comment = $value['comment'];
					$comment_topic_id = $value['topic_id'];
					$comment_datetime = strftime("%d.%m.%Y, %H:%M Uhr", strtotime($value['comment_datetime']));
					$comment_name = $value['Vorname'].' '.$value['Nachname'];
					$comment_id = $value['id'];
					
					if ($value['status'] == 2) {
						$comment_edited = " (bearbeitet am ".strftime('%d.%m.%Y, %H:%M Uhr', strtotime($value['edit_datetime'])).")";
					}
					else {$comment_edited = '';}
					
					if ($value['status'] == 3) {
						$comment = "<i>Dieser Kommentar wurde am ".strftime('%d.%m.%Y, %H:%M Uhr', strtotime($value['delete_datetime']))." gelöscht.</i>";
					}
					
					if ($comment_topic_id == $n) { ?>
						
					<div class='comments' id="kommentar-<?=$comment_id?>">
						<p id='comments_name_date'><span class='comments_name'><?=$comment_name?></span>
						<br><span class='comments_time'><?=$comment_datetime . $comment_edited?></span></p>
						<p id='comments_comm'><?=nl2br($comment)?></p>
<?php
					if ($user_id == $value['user_id'] && $value['status'] != 3) {
?>					
					<form class="comment_edit_form" method="post" action="<?php echo htmlentities('kommentar-bearbeiten.php');?>" target="editComment">
						<input type="hidden" name="comment_id" value="<?=$value['id']?>">
						<input type="hidden" name="topic_id" value="<?=$id?>">
						<input type="hidden" name="comment" value="<?=$comment?>">
						<button onclick="window.open('kommentar-bearbeiten.php', 'editComment', 'width=900,height=400'); $(this).closest('form').submit();">Bearbeiten</button>
					</form>
					
					<form class="comment_edit_form" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']), '?kommentar-geloescht'; ?>" name="delete_comment_form">
						<input type="hidden" name="deleted_comment[comment_id]" value="<?=$value['id']?>">
						<input type="hidden" name="deleted_comment[comment]" value="">
						<input type="submit" class="delete_comment_inputbutton" name="delete_comment_submit" value="L&ouml;schen" onclick="return checkDelete();">
					</form>
<?php					
					}				
?>				
					</div>
<?php					
				}
			} ?>
					</div>
					
					<form class="comment_input_form" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']), '?kommentar-abgeschickt'; ?>" name="themenwahl_comment_form">
						<textarea class="suggestion_inputarea" id="comment_inputarea" placeholder="Kommentar oder Erg&auml;nzung zum Thema &bdquo;<?=$title?>&ldquo;" rows="3" name="comment[comment]" required></textarea>
						<input type="hidden" name="comment[topic_id]" value="<?=$n?>">
						<input type="submit" class="inputbutton" id="comment_inputbutton" name="comment_submit" value="Kommentar zum Thema &bdquo;<?=$title?>&ldquo; absenden" <?if ($expired < time()) echo 'disabled'?>>
					</form>
<?php		
		}	
	}
?>
	</div>
</div>

<!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog-login modal-form-width">
      <div class="modal-content-login">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h2 class="modal-title" id="myModalLabel">Themenwahl</h2>
        </div>
        <div class="modal-body">
        	<?php
			echo $topic_static->modal;
			?>
        </div>
        <div class="modal-footer">
			<a href="../spende/"><button type="button" class="inputbutton">Unterst&uuml;tzer werden</button></a>
        </div>
      </div>
    </div>
  </div>

<?php
include "_footer.php";
?>
