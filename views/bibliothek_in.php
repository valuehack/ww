<?php 
require_once('../classes/Login.php');
$title="Bibliothek";
include('_header_in.php'); 

?>

<div class="content"></div>
		<div class="medien_info">
<?php
			$bib_info = $general->getStaticInfo('bibliothek');
			echo $bib_info->info;

if ($_SESSION['Mitgliedschaft'] == 1) {
	
	echo $bib_info->info1;
}

?>
	</div>
</div>
<?php include('_footer.php'); ?>