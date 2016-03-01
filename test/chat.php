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
			<iframe src="../tools/chat.php?title=Salon2" width="100%" height="600"></iframe>
		</div>
	</div>