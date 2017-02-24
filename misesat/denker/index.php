<?
	include "../config/header1.inc.php";

	$title="Denker";

	include "../page/header2.inc.php";
?>
		<div id="content">
<?php
if(isset($_GET['denker']))
{
  $thinker_id = $_GET['denker'];

  $result = $general->getInfo('denker', $thinker_id);

  $name = $result->name;
  $bio = $result->bio;
  $gen = $result->gen;
	$img_url = 'http://www.mises.at/denker/'.$thinker_id.'.jpg';
	if (@getimagesize($img_url)) {
			$img = $img_url;
	} else {
			$img = "http://www.mises.at/denker/ma_logo.jpg";
	}

?>
<!--Denker-->
<!--Content-->
      	<div class="container index-link"><p><a href="../index.php">mises.at</a> / <a href="index.php">Denker</a> / <?=$name?></a></p></div>
      	<div class="container">
      		<div class="row style-space--bottom">
      			<div class="two-thirds column">
      				<h1><?=$name?></h1>
      			</div>
      			<div class="one-third column h-centered">
      				<?php
      					if ($img !== "" OR $img !== 0) {
      					echo '<img src="'.$img.'" class="img--portrait" alt="'.$name.'">';
			}
			
			include "../classes/link.php";
			$bio = addlinks($bio, $name);
			
      	?>
      			</div>
      		</div>
      		<div class="row">
      			<div class="two-thirds column text">
      				<h2>Leben</h2>
      				<p><?=$bio?></p>
      			</div>
      			<div class="one-third column">
      				<?php
   						$sql_book = $general->db_connection->prepare('SELECT * FROM buecher WHERE autor = :autor ORDER BY jahr DESC');
						$sql_book->bindValue(':autor', $name, PDO::PARAM_STR);
						$sql_book->execute();
						$result_book = $sql_book->fetchAll();

						for ($m = 0; $m < count($result_book); $m++) {
							$result_book[$m]['type'] = 'Buch';
						}

						$sql_art = $general->db_connection->prepare('SELECT * FROM artikel WHERE autor = :autor ORDER BY jahr DESC');
						$sql_art->bindValue(':autor', $name, PDO::PARAM_STR);
						$sql_art->execute();
						$result_art = $sql_art->fetchAll();

						for ($n = 0; $n < count($result_art); $n++) {
							$result_art[$n]['type'] = 'Artikel';
						}

						$result_lit = array_merge($result_book, $result_art);

						if (!empty($result_lit)) {

							foreach ($result_lit as $key => $row) {
								$id[$key] = $row['id'];
								$year[$key] = $row['jahr'];
							}

							array_multisort($year, SORT_DESC, $id, SORT_ASC, $result_lit);

							if (count($result_lit) >= 10) {$x = 10;}
							else {$x = count($result_lit);}

					?>
      				<h5 class="style-bl--red">Werke</h5>
      				<div class="list">
          				<ul class="list--none">
						<?php
						for ($i = 0; $i < $x; $i++) {
							if ($result_lit[$i]['quelle'] == 'PDF') { //PDF Links vorsichtshalber entfernt.
								//echo '<li>'.$result_lit[$i]['type'].': <a href="../literatur/'.$result_lit[$i]['type'].'/'.$result_lit[$i]['id'].'.pdf" target="_blank">'.$result_lit[$i]['titel'].'</a> ('.$result_lit[$i]['jahr'].')';
								echo '<li>'.$result_lit[$i]['type'].': '.$result_lit[$i]['titel'].' ('.$result_lit[$i]['jahr'].')';
							} else if (empty($result_lit[$i]['quelle'])) {
								echo '<li>'.$result_lit[$i]['type'].': '.$result_lit[$i]['titel'].' ('.$result_lit[$i]['jahr'].')';
							} else {
								echo '<li>'.$result_lit[$i]['type'].': <a href="'.$result_lit[$i]['link'].'" target="_blank">'.$result_lit[$i]['titel'].'</a> ('.$result_lit[$i]['jahr'].')';
							}
						}
						?>
          				</ul>
      				</div>
      				<?php
      				if (count($result_lit) > 10) {
      				?>
      				<div class="h-centered h-extra-space__top">
						<a class="btn-link h-block" href="../literatur/?autor=<?=$thinker_id?>">gesamte Liste</a>
					</div>
					<?php
							}
						}
					?>
      			</div>
      		</div>
      	</div>

<?php
}
else {

    $result = $general->getItemList('denker', 'geburt', 'ASC');
		$result_id = $general->getItemList('denker', 'id', 'ASC');
?>
<!--Denkerliste-->

			<div class="container index-link"><p><a href="../index.php">mises.at</a> / Denker</p></div>
      		<div class="container">
      			<h1>Denker</h1>
      			<p>Hier finden Sie eine umfassende &Uuml;bersicht der in der Denktradition der &Ouml;sterreichischen Schule stehenden Denker.</p>
      		</div>

      		<div class="container">
      			<div class="itm-index">
							<?php
							$l_let = '';
							$let_list = array();
							$let_full = array();
						//	$name_list = array();
							$new_let = array();
							for ($j = 0; $j < count($result_id); $j++) {
								$let = substr($result_id[$j]['id'],0,1);
								$let_full[$j] = substr($result_id[$j]['id'],0,1);
								if ($let != $l_let) {
									$let_list[$j] = $let;
									$l_let = $let;
								}
							}
						//	for ($n = 0; $n<=count($let_list); $n++) {
							$n = 0;
							
							foreach ($let_list as $lett) {
								//echo '<a href="#'.$lett.'">'.ucfirst($lett).'</a> | ';
									echo '
									<div class="dropdown">
										<button class="dropbtn">
												'.ucfirst($lett).'
										</button>
										<div class="dropdown-content">';
											while ($lett == substr($result_id[$n]['id'],0,1)) {
												echo '<a href="#'.$result_id[$n]['id'].'">'.$result_id[$n]['name'].'</a>';
												$n ++;
											}	echo '
										</div>
									</div>';
							}
					?>
      			</div>
						<div class="container h-centered style-space--bottom genbuttons">
							<div class="row">
							<? 
							$gen = array("menger", "bawerk", "mises", "rothbard");
							for($i=0;$i<=3;$i++){ 
								if ((($i) % 2) == 0) { 
									echo '<div class="row">';
				        } ?>
								<div class="one-half column button-column">
								<a href="#<?=$gen[$i]?>"><div class='card button-card'>
									<img class="card-head button-img" src="buttons/<?=$gen[$i]?>2.jpg"></img>
									
								</div><h6 class="button-title"><?=($i+1)?>. Generation<h6></a>
								
							</div>
								
							<?} 
							if ((($i+1) % 2 == 0 || ($i+1) == count($result))) {
								echo '</div>';
							}
							?>
						</div>
						</div>
						</div>
					</div>
						
						</div>
						
						
<?php
    //$gencount = 1;
    $n = 0;
    
	for ($i = 0; $i < count($result); $i++)
	{
		$id = $result[$i]['id'];
        $name = $result[$i]['name'];
  		$bio = $result[$i]['bio'];
        $gen = $result[$i]['gen'];
			$img_url = './'.$id.'.jpg';
			if (@getimagesize($img_url)) {
					$img = $img_url;
			} else {
					$img = "./ma_logo.jpg";
			}

		$last_letter = '';
		$letter = substr($id,0,1);

		if ($letter != $last_letter) {
			echo '<span id="'.$letter.'"></span>';
		}

		$last_letter = $letter;
        
        
        
        if (($n % 2) == 0) { 
			echo '<div class="row">';
        }

        /*if($gen == $gencount){
            
            echo("</div><div class=''><h3 class='style-bl--red h-extra-space__top'>".$gen.". Generation</h3></div><div class='row'>");
            $gencount++;
            if((($n+1) % 2) == 0){
                $n++;
            }
        } */
        
        
		?>
					<div class="one-half column" id="<?=$id?>">
      					<div class="card">
      						<a href="?denker=<?=$id?>">	<div class="card-head <? if ($img != '') echo 'card-head__overlay';?>">
      							<? if ($img != '') echo '<img src="'.$img.'" alt="'.$name.'">';?>
      						</div></a>
									
						 <div class="card-content">
										<h6> <a href="?denker=<?=$id?>" <? if ($img != ''); ?>><?=$name?></span></a></h6>
      							<p><?=$general->substrCloseTags($bio,200)?></p>
      						</div>
									
						 <div class="card-link h-right">
								<a href="?denker=<?=$id?>">Zur Person</a>
      						</div>
      					</div>
      				</div>

		<?
		if ((($n + 1) % 2 == 0 || ($i + 1) == count($result))) {
			echo '</div>';
		}
        $n++;
	}
?>
			</div>
<?
}
?>
		</div>
<?php include "../page/footer.inc.php"; ?>
