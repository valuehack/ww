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
	$img_url = 'http://www.mises.at/denker/'.$thinker_id.'.jpg';
	if (@getimagesize($img_url)) {
			$img = $img_url;
	} else {
			$img = "http://www.mises.at/denker/ma_logo.jpg";
	}
	//$img = $result->img;

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
          					echo '<li>'.$result_lit[$i]['type'].': <a href="'.$result_lit[$i]['link'].'" target="_blank">'.$result_lit[$i]['titel'].'</a> ('.$result_lit[$i]['jahr'].')';
          				}
						?>
          				</ul>
      				</div>
      				<div class="h-centered h-extra-space__top">
						<a class="btn-link h-block" href="../literatur/?author=<?=$thinker_id?>">gesamte Liste</a>
					</div>
					<?php
						}
					?>
      			</div>
      		</div>
      	</div>

<?php
}
else {

    $result = $general->getItemList('denker', 'id', 'ASC');
?>
<!--Denkerliste-->

			<div class="container index-link"><p><a href="../index.php">mises.at</a> / Denker</p></div>
      		<div class="container">
      			<h1>Denker</h1>
      			<p>Hier finden Sie eine umfassende &Uuml;bersicht der in der Denktradition der &Ouml;sterreichischen Schulen stehenden Denker.</p>
      		</div>

      		<div class="container">
      			<div class="itm-index">
      				<?php
      				$l_let = '';
					$let_list = array();
      				for ($j = 0; $j < count($result); $j++) {
      					$let = substr($result[$j]['id'],0,1);
						if ($let != $l_let) {
							$let_list[$j] = $let;
							$l_let = $let;
						}
      				}
					foreach ($let_list as $lett) {
						echo '<a href="#'.$lett.'">'.ucfirst($lett).'</a> | ';
					}
					?>
      			</div>
<?php
	for ($i = 0; $i < count($result); $i++)
	{
		$id = $result[$i]['id'];
        $name = $result[$i]['name'];
  		$bio = $result[$i]['bio'];
			$img_url = 'http://www.mises.at/denker/'.$id.'.jpg';
			if (@getimagesize($img_url)) {
					$img = $img_url;
			} else {
					$img = "http://www.mises.at/denker/ma_logo.jpg";
			}

		$last_letter = '';
		$letter = substr($id,0,1);

		if ($letter != $last_letter) {
			echo '<span id="'.$letter.'"></span>';
		}

		$last_letter = $letter;

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
      							<p><?=$general->substrCloseTags($bio,200)?></p>
      						</div>
      						<div class="card-link h-right">
      							<a href="?denker=<?=$id?>">Zum Denker</a>
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
<?php include "../page/footer.inc.php"; ?>
