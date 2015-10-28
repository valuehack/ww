<? 
	require_once "../../config/config.php";
	include "../config/db.php";

	$title="B&uuml;cher";

	include "../page/header2.inc.php";
?>

<!--Content-->

    <div id="content">
      <article>
      	
<?
	$sql_buch = $pdocon->db_connection->prepare("SELECT * from buecher order by id asc");
    $sql_buch->execute();
	$result_buch = $sql_buch->fetchAll();
	
	$sql_art = $pdocon->db_connection->prepare("SELECT * from artikel order by id asc");
	$sql_art->execute();	
    $result_art = $sql_art->fetchAll();
	
?>
      	<div class="index"><a class="index-link" href="">Mises Austria</a> / <a class="index-link" href="">B&uuml;cher</a></div>
      
      	<h1>B&uuml;cher</h1>
      	
      		<div class="itm-list">
<?php
	for ($i = 0; $i < count($result_buch); $i++)
	{
		$id_buch = $result_buch[$i]['id']; 
        $title_buch = $result_buch[$i]['titel'];
  		$autor_buch = $result_buch[$i]['autor'];
  		$lang_buch = $result_buch[$i]['sprache'];
		$link_buch = $result_buch[$i]['link'];
  		
		?>      	

				<div class="itm-list__row">
					<div class="itm-list__row-col-4">
						<div class="itm-list__row-col-content">							
							<a href="<?=$link_buch?>"><?=$title_buch?></a>	
							<span class="subinfo"><?=$autor_buch?></span> 
						</div>
					</div>
				</div>
		<?
	}
?>   
			</div>
			<div class="clear"></div>
			
      	<h1>Artikel</h1>
      	
      		<div class="itm-list">
<?php
	for ($i = 0; $i < count($result_art); $i++)
	{
		$id_art = $result_art[$i]['id']; 
        $title_art = $result_art[$i]['titel'];
  		$autor_art = $result_art[$i]['autor'];
  		$lang_art = $result_art[$i]['sprache'];
		$link_art = $result_art[$i]['link'];
  		
		?>      	

				<div class="itm-list__row">
					<div class="itm-list__row-col-4">
						<div class="itm-list__row-col-content">							
							<a href="<?=$link_art?>"><?=$title_art?></a>	
							<span class="subinfo"><?=$autor_art?></span> 
						</div>
					</div>
				</div>
		<?
	}
?>   
			</div>
			<div class="clear"></div>          	
	  </article>
	</div>
<?	
	include "../page/footer.inc.php";
?>