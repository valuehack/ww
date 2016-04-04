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
      	<div class="container index-link"><p><a href="../index.php">Wiener Schule</a> / <a href="index.php">Denker</a> / <?=$name?></a></p></div>      		<div class="container">
      		<div class="row">
      			<div class="two-thirds column">
      				<h1><?=$name?></h1>
      			</div>
      			<div class="one-third column h-white">
      				<?php
      					if ($img !== "" OR $img !== 0) { 
      					echo '<img src="'.$img.'" class="img--portrait" alt=".">';
			}
      	?>
      			</div>
      		</div>
      	</div>
      	<div class="container text">      	  
      		<h2>Leben</h2>      		    
      		<p><?=$bio?></p>    	
      	</div>
      	<div class="container">
			<h2>Werke</h2>

			<div class="row">
				<div class="one-half column">
					<h5 class="style-bl--red">B&uuml;cher</h5>
					<div class="list list--none">
          				<ul>
          				<?php
   						$sql_buch = $pdocon->db_connection->prepare("SELECT * from buecher WHERE autor='$name' ORDER by n asc LIMIT 10");
						$sql_buch->execute();
		        		$result_buch = $sql_buch->fetchAll();

						for ($i = 0; $i < count($result_buch); $i++) {				       		
          					echo '<li><a href="'.$result_buch[$i]['link'].'" target="_blank">'.$result_buch[$i]['titel'].'</a>';
          				}
						?>
          				</ul>
      				</div>
				</div>
				<div class="one-half column">
					<h5 class="style-bl--red">Artikel</h5>
          			<div class="list list--none">
            			<ul>
          				<?php
   						$sql_art = $pdocon->db_connection->prepare("SELECT * from artikel WHERE autor='$name' ORDER by n asc LIMIT 10");
						$sql_art->execute();
						$result_art = $sql_art->fetchAll();
						
        				for ($i = 0; $i < count($result_art); $i++) {
          					echo '<li><a href="'.$result_art[$i]['link'].'" target="_blank">'.$result_art[$i]['titel'].'</a>';
          				}
						?>
            			</ul>
       				</div>
				</div>
			</div>          		          		                		        
       	</div>

<?php
}
else {
	
    $sql = $pdocon->db_connection->prepare("SELECT * from denker order by id asc");
	$sql->execute();
    $result = $sql->fetchAll();
?>
<!--Denkerliste-->	
  	
			<div class="container index-link"><p><a href="../index.php">Wiener Schule</a> / Denker</p></div>
      		<div class="container">
      			<h1>Autoren&uuml;bersicht</h1>
      		</div>
      
      		<div class="container">
<?php
	for ($i = 0; $i < count($result); $i++) 
	{
		$id = $result[$i]['id'];
        $name = $result[$i]['name'];
  		$bio = $result[$i]['bio'];
  		$img = $result[$i]['img'];
  		
		?>
		
				<div class="row list-row">
					<div class="one-third column">
						<div class="list-itm h-white">
							<img class="list-itm_img--small" src="<?=$img?>" alt=".">
						</div>
					</div>
					<div class="two-thirds column">
						<div class="list-itm">
							<a class="title-link" href="index.php?q=<?=$id?>"><?=$name?></a>
							<p><? echo substr(strip_tags($bio), 0, 200)?> ... <a href="index.php?q=<?=$id?>">Mehr</a></p>
						</div>
					</div>
				</div>
		<?
	}
?>   
			</div>  
<?	
}
?>
		</div>
<?php
	include "../page/footer.inc.php";
?>