<?php

include('../views/_header_in.php');
?>
<div class="content-area">
		<div class="centered">
			<h2>Testchat</h2>
		</div>
		<div class="centered">
			<iframe width="100%" height="500" src="https://www.youtube.com/embed/<?=$livestream?>" frameborder="0" allowfullscreen></iframe>
		</div>
		<div class="chat-wrapper">
			<iframe src="../phpfreechat/chat/default.html" width="100%" height="500"></iframe>
			<!--<div class="pfc-hook"><a href="http://www.phpfreechat.net">Creating chat rooms everywhere - phpFreeChat</a></div>
    			<script type="text/javascript">
      				$('.pfc-hook').phpfreechat({ serverUrl: '../phpfreechat/server' });
   				</script>-->
		</div>
	</div>