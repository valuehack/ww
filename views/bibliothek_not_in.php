<?php 
require_once('../classes/Login.php');
$title="Bibliothek";
include('_header_not_in.php'); 


?>
<div class="content">
		<div class="medien_info">
			<h1>Bibliothek</h1>
			
			<?php
				$sql = "SELECT * from static_content WHERE (page LIKE 'bibliothek')";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				$entry = mysql_fetch_array($result);
				
				echo $entry[text];			
			?>
			
			<p>Wenn Sie ein Zugang interessiert, hinterlassen Sie uns Ihre E-Mail-Adresse:</p>
  
  			<div class="subscribe">
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform">
        			<input class="inputfield" type="email" placeholder=" E-Mail Adresse" name="user_email" autocomplete="off" required>
        			<input class="inputbutton" id="inputbutton" type="submit" name="eintragen_submit" value="Eintragen">
      			</form>	
			</div>
		</div>
</div>

<? include "_footer.php"; ?>