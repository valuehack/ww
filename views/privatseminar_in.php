<?php
require_once('../classes/Login.php');

$title="Privatseminar";
include "_header_in.php";

#get event info right away to choose the right (next) event in the list and stream view
$ps_query = $general->db_connection->prepare('SELECT * FROM produkte WHERE type LIKE :type AND status = :status AND end >= NOW() ORDER by end asc LIMIT 0,1');
$ps_query->bindValue(':type', 'privatseminar', PDO::PARAM_STR);
$ps_query->bindValue(':status', 1, PDO::PARAM_INT);
$ps_query->execute();
$ps_info = $ps_query->fetchObject();

$getEventReg = $general->getEventReg($_SESSION['user_id'], $ps_info->n);

$user_info = $general->getUserInfo($_SESSION['user_id']);

//$expired = strtotime($user_info->Ablauf);

#####################################
#           Stream View             #
#####################################

if($_GET['stream'] === 'true') {
	
	if ($getEventReg->format === 'Stream') {		
	
		$livestream = substr($ps_info->livestream,32);

		$begleit_pdf = '../privatseminar/'.$ps_info->id.'.pdf';

?>	
	<div class="content-area">
		<div class="centered">
			<h2><?=$ps_info->title?></h2>
		</div>
		<div class="centered">
			<iframe width="100%" height="500" src="https://www.youtube.com/embed/<?=$ps_info->livestream?>" frameborder="0" allowfullscreen></iframe>
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
		<div class="chat-wrapper">
			<iframe src="../tools/chat.html" width="100%" height="600"></iframe>
			<!--<div id="mychat"><a href="http://www.phpfreechat.net">Creating chat rooms everywhere - phpFreeChat</a></div>
			<script type="text/javascript">
 				 $('#mychat').phpfreechat({ serverUrl: '../phpfreechat/server' });
			</script>-->
		</div>
	</div>
<?php
	}
	else {
?>
	<div class="content-area">
		<div class="centered">
			<h2><?=$ps_info->title?></h2>
		</div>
		<div class="centered content-elm">
<?php
		if ($ps_info->livestream == '') {
?>
			<p class="content-elm">F&uuml;r diesen Salon wird es leider keinen Stream geben.</p>
<?php
		}
		else {
?>
			<p class="content-elm">Bitte reservieren Sie einen Platz um diesen Stream zu sehen.</p>
<?php			
			if ($expired < time()) {
?>
				<p class="content-elm error">
					Ihre Mitgliedschaft ist abgelaufen. <a href="../abo/index.php">Bitte eneuern Sie Ihre Mitgliedschaft.</a> Anschließend k&ouml;nnen Sie diesen Stream buchen.
				</p>				
<?php
			}
			elseif ($user_info->credits_left < $ps_info->price) {
?>
				<p class="content-elm error">
					Leider reicht Ihr Guthaben nicht aus um an dieser Veranstaltung teilzunehmen. <a href="../abo/index.php">Bitte eneuern Sie Ihre Mitgliedschaft um weiteres Guthaben zu erhalten.</a>
				</p>
<?php				
			}
?>
			<form method="post" action="<?echo htmlentities('index.php')?>">
				<input type="hidden" name="product[format]" value="Stream">
				<input type="hidden" name="product[event_id]" value="<?=$ps_info->n?>">
				<input type="hidden" name="product[quantity]" value="1">			 
				<input type="submit" class="inputbutton" name="oneClickReg" value="F&uuml;r diesen Stream anmelden (<?=$ps_info->price?> Guthabenpunkte)" <?if ($user_info->credits_left < $ps_info->price || $expired < time()) echo 'disabled'?>>
			</form>
<?php
		}
?>
		</div>
	</div>
<?php		
	}
}

#####################################
#            Event List             #
#####################################

else {
?>		
	<div class="content">
<?php
		$static_info = $general->getStaticInfo('privatseminar');
?>		
		<div class="content-area">
			<div class="content-elm em">
				<?=$static_info->info?>
			</div>
<?php
  	if ($_SESSION['Mitgliedschaft'] == 1) {
?>
			<div class="centered">
				<a class="blog_linkbutton" href="../abo/">Unterst&uuml;tzen & Zugang erhalten</a>
			</div>		
   		</div>
   		
   <?
  }
  elseif ($_SESSION['Mitgliedschaft'] > 1) {
?>
		</div>
		<div class="content-area">
			<div class="content-elm">
				<p><b>N&auml;chstes Privatseminar:</b></p>
			</div>
			<div class="centered content-elm">
				<h2><?=$ps_info->title?></h2>
<?php
			if($ps_info->n === $getEventReg->event_id && $getEventReg->format === 'Stream') {
?>
			<form action="<?echo htmlentities('index.php?stream=true')?>" method="post">
				<input type="submit" class="inputbutton" href="index.php?stream=true" value="Zum Stream">
			</form>
<?php
			}
			else {
				if ($ps_info->livestream == '') {
?>
				<p class="content-elm">
					F&uuml;r dieses Privatseminar wird es leider keinen Livestream geben.
				</p>
<?php
				}
				else {
			
					if ($expired < time()) {
?>
						<p class="content-elm error">
							Ihre Mitgliedschaft ist abgelaufen. <a href="../abo/index.php">Bitte eneuern Sie Ihre Mitgliedschaft.</a> Anschließend k&ouml;nnen Sie diesen Stream buchen.
						</p>				
<?php
					}
					elseif ($user_info->credits_left < $ps_info->price) {
?>
						<p class="content-elm error">
							Leider reicht Ihr Guthaben nicht aus um an dieser Veranstaltung teilzunehmen. <a href="../abo/index.php">Bitte eneuern Sie Ihre Mitgliedschaft um weiteres Guthaben zu erhalten.</a>
						</p>
<?php				
					}
?>										
					<form method="post" action="<?echo htmlentities('index.php?stream=true')?>">
						<input type="hidden" name="product[format]" value="Stream">
						<input type="hidden" name="product[event_id]" value="<?=$ps_info->n?>">
						<input type="hidden" name="product[quantity]" value="1">			 
						<input type="submit" class="inputbutton" name="oneClickReg" value="F&uuml;r den n&auml;chsten Stream anmelden (<?=$ps_info->price?> Guthabenpunkte)." <?if ($user_info->credits_left < $ps_info->price || $expired < time()) echo 'disabled'?>>
					</form>
<?php
				}
			}
?>
			</div>
		</div>
		<div class="content-area">
			<div class="centered content-elm">
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
  	<?php
  }
}    
?> 

<? include "_footer.php"; ?>