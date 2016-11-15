<? 
	include "../config/header1.inc.php";

	$title="Verlag";

	include "../page/header2.inc.php";
	
	$program_query = $general->db_connection->prepare("SELECT * FROM verlagsprogramm ORDER by id asc");
	$program_query->execute();
    $program = $program_query->fetchAll();	
?>

<!--Content-->

    <div id="content">
      	<div class="container index-link"><p><a href="../index.php">Mises Austria</a> / Verlag</p></div>
      	<div class="container text">
      		<h1>Verlag</h1>
      		<p>Infotext</p>
      	</div> 
      	<div class="container">
      		<h3 class="h-extra-space__bottom">Verlagsprogramm</h3>
<?php

		foreach ($program as $key => $item) {
			
			$img = 'cover/'.$item['id'].'.jpg';
			
			$link = $item['link'];
			
			$authors = $item['author'];
			
			$author_links = "";
			$author_list = explode(", ", $authors);
			

			foreach ($author_list as $key => $author_id) {
				$author_info = $general->getInfo('denker',$author_id);
				if (count($author_list) > 1 && count($author_list) != $key+1) {
					if ($author_info == FALSE) {
						$author_links = $author_links.$author_id.', ';
					}
					else {
						$author_links = $author_links.'<a href="../denker/index.php?denker='.$author_info->id.'">'.$author_info->name.'</a>, ';
					}
				}
				else {
					if ($author_info == FALSE) {
						$author_links = $author_links.$author_id;
					}
					else { 
						$author_links = $author_links.'<a href="../denker/index.php?denker='.$author_info->id.'">'.$author_info->name.'</a>';
					}
				}
		}
?>      		
      		<div class="row list-row">
				<div class="one-third column">
					<div class="list-itm h-white h-centered">
						<a href=<?=$link?>><img class="list-itm_img--big" src="<?=$img?>" alt="."></a>
					</div>
				</div>
				<div class="two-thirds column">
					<div class="list-itm">
						<h5> <a class="title" href=<?=$link?>> <?=$item['title']?></a></h5>
						<p class="text-insert text--raleway"><?=$author_links?></p>
						<p><?=$item['desc']?></p>
					</div>
				</div>
			</div>
<?php
		}
?>			
      	</div>     	      
	</div>
<?	
	include "../page/footer.inc.php";
?>
