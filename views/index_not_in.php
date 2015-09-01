<?php
include ("_db.php");
$title="Willkommen";
include ("_header_not_in.php"); 
?>
<div class="content">
	<div class="blog">
		<div class="blog_text">
			
			<?php
				$sql = "SELECT * from static_content WHERE (page LIKE 'buerger')";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				$entry = mysql_fetch_array($result);
				
				echo $entry[info];			
			?>
		
			<div class="centered">
				<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name="registerform">
  					<input class="inputfield" id="user_email" type="email" placeholder=" E-Mail-Adresse" name="user_email" required>
  					<!-- make sure that value is changed in here if form is copied/ captures the place of first reg -->
  					<input type="hidden" name="first_reg" value="landing">
  					<input class="inputbutton" type="submit" name="eintragen_submit" value="Eintragen">
				</form>
			</div>
		</div>		
	</div>
</div>

<?php include('views/_footer.php'); ?>