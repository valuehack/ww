<? 
	include "../config/header1.inc.php";

	$title="Denker";

	include "../page/header2.inc.php";
?>
		<div id="content">
<?php	
if(isset($_GET['thinker']))
{
  $thinker_id = $_GET['thinker'];

  $result = $general->getInfo('denker', $thinker_id);

  $name = $result->name;
  $bio = $result->bio;
  $img = $result->img;
    
?>
<!--Denker-->
<!--Content-->    
      	<div class="container index-link"><p><a href="../index.php">Wiener Schule</a> / <a href="index.php">Denker</a> / <?=$name?></a></p></div>     		
      	<div class="container">
      		<div class="row style-space--bottom">
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
      		<div class="row">
      			<div class="two-thirds column text">
      				<h2>Leben</h2>
      				<p><?=$bio?></p>
      			</div>
      			<div class="one-third column">
      				<h5 class="style-bl--red">Werke</h5>
      				<div class="list">
          				<ul class="list--none">
          				<?php
   						$sql_book = $general->db_connection->prepare('SELECT * FROM buecher WHERE autor = :author ORDER BY jahr DESC');
						$sql_book->bindValue(':author', $name, PDO::PARAM_STR);
						$sql_book->execute();
						$result_book = $sql_book->fetchAll();
		
						for ($m = 0; $m < count($result_book); $m++) {
							$result_book[$m]['type'] = 'Buch';
						}
		
						$sql_art = $general->db_connection->prepare('SELECT * FROM artikel WHERE autor = :author ORDER BY jahr DESC');
						$sql_art->bindValue(':author', $name, PDO::PARAM_STR);
						$sql_art->execute();
						$result_art = $sql_art->fetchAll();
		
						for ($n = 0; $n < count($result_art); $n++) {
							$result_art[$n]['type'] = 'Artikel';
						}
		
						$result_lit = array_merge($result_book, $result_art);
		
						foreach ($result_lit as $key => $row) {
							$id[$key] = $row['id'];
							$year[$key] = $row['jahr'];
						}
																	
						array_multisort($year, SORT_DESC, $id, SORT_ASC, $result_lit);

						if (count($result_lit) >= 10) {$x = 10;}
						else {$x = count($result_lit);}

						for ($i = 0; $i < $x; $i++) {				       		
          					echo '<li>'.$result_lit[$i]['type'].': <a href="'.$result_lit[$i]['link'].'" target="_blank">'.$result_lit[$i]['titel'].'</a> ('.$result_lit[$i]['jahr'].')';
          				}
						?>
          				</ul>
      				</div>
      				<div class="h-centered">
						<p><a class="btn-link h-block" href="../literatur/?author=<?=$thinker_id?>">gesamte Liste</a></p>
					</div>
      			</div>
      		</div>
      	</div>
      	          		          		                		       
<?php
}
else {
	
    $result = $general->getItemList('denker', 'id', 'ASC');
?>
<!--Denkerliste-->	
  	
			<div class="container index-link"><p><a href="../index.php">Wiener Schule</a> / Denker</p></div>						
      		<div class="container">
      			<h1>Denker</h1>
      			<p>Hier finden Sie eine umfassende &Uuml;bersicht der in der Denktradition der klassischen Wiener/ &Ouml;sterreichischen Schulen stehenden Denker.</p>
      		</div>
      
      		<div class="container">
<?php
	for ($i = 0; $i < count($result); $i++) 
	{
		$id = $result[$i]['id'];
        $name = $result[$i]['name'];
  		$bio = $result[$i]['bio'];
  		$img = $result[$i]['img'];
  		
		if (($i % 2) === 0) {
			echo '<div class="row">';
		}
		
		?>						
					<div class="one-half column">
      					<div class="card">
      						<div class="card-head <? if ($img != '') echo 'card-head__overlay';?>">      							
      							<? if ($img != '') echo '<img src="'.$img.'" alt="'.$name.'">';?>
      							<span class="card-title <? if ($img != '') echo 'h-white';?>"><?=$name?></span>      							
      						</div>
      						<div class="card-content">      								
      							<p><?=$general->substr_close_tags($bio,200)?></p>
      						</div>
      						<div class="card-link h-right">
      							<a href="?id=<?=$id?>">Zum Denker</a>
      						</div>
      					</div>
      				</div>
      				
		<?
		if (($i + 1) % 2 === 0 || ($i + 1) === count($result)) {
			echo '</div>';
		}
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