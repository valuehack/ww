<?php 
require_once('../classes/Login.php');
$title="Bibliothek";
include('_header_not_in.php'); 


?>
<div class="content">
		<div class="medien_info">
			<h1>Bibliothek</h1>
			
			<?php
				$bib_info = $general->getStaticInfo('bibliothek');				
				echo $bib_info->info;		
			?>
			
			<p>Wenn Sie ein Zugang interessiert, hinterlassen Sie uns Ihre E-Mail-Adresse:</p>
  
  			<div class="subscribe">
				<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
          	<input class="inputfield" type="email" placeholder=" E-Mail-Adresse" name="user_email" required>
          	<input type=hidden name="first_reg" value="bibliothek">
          	<input class="inputbutton" type="submit" name="eintragen_submit" value="Kostenlos eintragen">
      			</form>	
			</div>
		</div>
</div>

<? include "_footer.php"; ?>