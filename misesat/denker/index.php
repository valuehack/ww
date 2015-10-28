<? 
	require_once "../../config/config.php";
	include "../config/db.php";

	$title="Denker";

	include "../page/header2.inc.php";
?>
		<div id="content">
<?php	
if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Autorendetails
  $sql = $pdocon->db_connection->prepare("SELECT * from denker WHERE id='$id'");
  $sql->execute();
  $result = $sql->fetchAll();

  $name = $result[0]['name'];
  $bio = $result[0]['bio'];
  $img = $result[0]['img'];
    
?>
<!--Denker-->
<!--Content-->    
      <article>
      	<div class="index"><p><a class="index-link" href="../index.php">Wiener Schule</a> / <a class="index-link" href="index.php">Denker</a> / <a class="index-link" href=""><?=$name?></a></p></div>
      
      	<h1><?=$name?></h1>
      	
      	<?php
      		if ($img !== "" OR $img !== 0) { 
      			echo '<div class="centered greybg"><img src="'.$img.'" class="img" alt="Portr&auml;t von '.$name.'"></div>';
			}
      	?>
      	  
      	<section class="text">
      		<h2>Leben</h2>      		    
      		<p><?=$bio?></p>
      	</section>      	
      	
     	<section class="text">
			<h2>Werke</h2>

          		<h5>B&uuml;cher</h5>
          		<div class="list list--none">
          			<ul>
          		<?php
   				$sql_buch = $pdocon->db_connection->prepare("SELECT * from buecher WHERE autor='$name' order by n asc");
				$sql_buch->execute();
		        $result_buch = $sql_buch->fetchAll();
				
				for ($i = 0; $i < count($result_buch); $i++) {				       		
          			echo '<li><a href="'.$result_buch[$i]['link'].'" target="_blank">'.$result_buch[$i]['titel'].'</a>';
          		}
				?>
          			</ul>
      			</div>
        
          		<h5>Artikel</h5>
          		<div class="list list--none">
            		<ul>
          		<?php
   				$sql_art = $pdocon->db_connection->prepare("SELECT * from artikel WHERE autor='$name' order by n asc");
				$sql_art->execute();
				$result_art = $sql_art->fetchAll();

        		for ($i = 0; $i < count($result_art); $i++) {
          			echo '<li><a href="'.$result_art[$i]['link'].'" target="_blank">'.$result_art[$i]['titel'].'</a>';
          		}
				?>
            		</ul>
       			</div>        
        </section>
        <div class="clear"></div>
       </article>
    </div>
<?php
}
else {
	
    $sql = $pdocon->db_connection->prepare("SELECT * from denker order by id asc");
	$sql->execute();
    $result = $sql->fetchAll();
?>
<!--Denkerliste-->	
  	
			<div class="index"><a class="index-link" href="../index.php">Wiener Schule</a> / <a class="index-link" href="">Denker</a></div>
      
      		<h1>Autoren&uuml;bersicht</h1>
      
      		<div class="itm-list">
<?php
	for ($i = 0; $i < count($result); $i++) 
	{
		$id = $result[$i]['id']; 
        $name = $result[$i]['name'];
  		$bio = $result[$i]['bio'];
  		$img = $result[$i]['img'];
  		
		?>
		
				<div class="itm-list__row">
					<div class="itm-list__row-col-1">
						<div class="itm-list__row-col-content">
							<img src="<?=$img?>" alt="">
						</div>
					</div>
					<div class="itm-list__row-col-3">
						<div class="itm-list__row-col-content">
							<a href="index.php?q=<?=$id?>"><?=$name?></a>
							<p><? echo substr(strip_tags($bio), 0, 200)?></p>
						</div>
					</div>
				</div>
		<?
	}
?>   
			</div>
			<div class="clear"></div>   
<?	
}
?>
		</div>
<?php
	include "../page/footer.inc.php";
?>