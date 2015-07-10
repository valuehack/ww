<?php 
require_once('../classes/Login.php');
$title="Bibliothek";
include('_header_in.php'); 

?>

<div class="content"></div>
		<div class="medien_info">
			<?php
				$sql = "SELECT * from static_content WHERE (page LIKE 'bibliothek')";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				$entry = mysql_fetch_array($result);
				
				echo $entry[info];			

if ($_SESSION['Mitgliedschaft'] == 1) {
	
	echo $entry[info1];
}

?>
	</div>
</div>
<?php include('_footer.php'); ?>