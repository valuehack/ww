<? 
	require_once '../../config/config.php';
	include '../config/db.php';

	include "../config/header1.inc.php";

	$title='Literatur';

	include '../page/header2.inc.php';
?>

<!--Content-->

    <div id="content">      	
<?
	if (isset($_GET['author'])) {
		$author_name = $general->getDenkerInfo($_GET['author']);
				
		$sql_book = $pdocon->db_connection->prepare('SELECT * FROM buecher WHERE autor = :author ORDER BY jahr DESC');
		$sql_book->bindValue(':author', $author_name->name, PDO::PARAM_STR);
		$sql_book->execute();
		$result_book = $sql_book->fetchAll();
		
		for ($m = 0; $m < count($result_book); $m++) {
			$result_book[$m]['type'] = 'Buch';
		}
		
		$sql_art = $pdocon->db_connection->prepare('SELECT * FROM artikel WHERE autor = :author ORDER BY jahr DESC');
		$sql_art->bindValue(':author', $author_name->name, PDO::PARAM_STR);
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
				
		array_multisort($id, SORT_ASC, $year, SORT_ASC, $result_lit);
	}
	else {
		if (isset($_GET['order'])) {
			$order = $_GET['order'];
		}
		else {
			$order = 'n';
		}	
			
		$sql_book = $pdocon->db_connection->prepare('SELECT * FROM buecher ORDER BY '.$order.' DESC');
		$sql_book->execute();
		$result_book = $sql_book->fetchAll();
		
		for ($m = 0; $m < count($result_book); $m++) {
			$result_book[$m]['type'] = 'Buch';
		}
		
		$sql_art = $pdocon->db_connection->prepare('SELECT * FROM artikel ORDER BY '.$order.' DESC');
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
				
		array_multisort($id, SORT_ASC, $year, SORT_ASC, $result_lit);
				
	}
	$sql_author_list = $pdocon->db_connection->prepare('SELECT * FROM denker ORDER BY id');
	$sql_author_list->execute();
	$author_list = $sql_author_list->fetchAll();
	$x = count($author_list)/4;	
?>
      	<div class="container index-link"><p><a href="../">Mises Austria</a> / <a href="">Literatur</a></p></div>
      	<div class="container">
      		<h1>Literatur</h1>
      		<p><b>mises.at</b> bietet die gr&ouml;&szlig;te und umfassendeste Online-Bibliothek der klassischen Wiener/ &Ouml;stereichischen Schule der &Ouml;konomik. Hier finden Sie Artikel und B&uuml;cher einer Vielzahl von Denker der Wiener Schule &uuml;ber ein breites Spektrum von &ouml;konomischen, sozialwissenschaftlichen und philosophischen Problemstellungen und Themen.</p>
      		
      		<?if (isset($_GET['author'])) echo '<h3><a href="../denker/?q='.$_GET['author'].'">'.$author_name->name.'</a></h3>';?>
      	</div>
      	
      	<div class="container">
      		<div class="style-space--bottom">
      			<button class="reiter showhide">Nach Autor filtern</button>
      			<div class="hidden row reiter--ctn">
      				<div class="three columns">
<?php
      				for ($j = 0; $j < $x; $j++) {
						echo '<a href="?author='.$author_list[$j]['id'].'">'.$author_list[$j]['name'].'</a><br>';
					}
?>      					
      				</div>
      				<div class="three columns">
<?php
      				for ($j = $x+1; $j < $x*2; $j++) {
						echo '<a href="?author='.$author_list[$j]['id'].'">'.$author_list[$j]['name'].'</a><br>';
					}
?>      					
      				</div>
      				<div class="three columns">
<?php
      				for ($j = ($x*2)+1; $j < $x*3; $j++) {
						echo '<a href="?author='.$author_list[$j]['id'].'">'.$author_list[$j]['name'].'</a><br>';
					}
?>      					
      				</div>
      				<div class="three columns">
<?php
      				for ($j = ($x*3)+1; $j < count($author_list); $j++) {
						echo '<a href="?author='.$author_list[$j]['id'].'">'.$author_list[$j]['name'].'</a><br>';
					}
?>      					
      				</div>
      			</div>     			
      		</div>
      		<table class="itm-table h-full-width sortable">
      			<thead>
      				<tr>
      					<th>Titel</th>
      					<th>Jahr</th>
      					<th>Autor</th>
      					<th>Typ</th>
      					<th>Sprache</th>
      					<th>Quelle</th>
      				</tr>
      			</thead>
      			<tbody>
<?php
	for ($i = 0; $i < count($result_lit); $i++)
	{
		$id_lit = $result_lit[$i]['id'];
        $title_lit = $result_lit[$i]['titel'];
  		$autor_lit = $result_lit[$i]['autor'];
  		$year_lit = $result_lit[$i]['jahr'];
		$link_lit = $result_lit[$i]['link'];
		$lang_lit = $result_lit[$i]['sprache'];
		$typ_lit = $result_lit[$i]['type'];
  		
		if ($lang_lit == 'en') {$sprache = 'Englisch';} 
		else {$sprache = 'Deutsch';}
		
  		$sql_author = $pdocon->db_connection->prepare('SELECT id FROM denker WHERE name = :name');
  		$sql_author->bindValue(':name', $autor_lit, PDO::PARAM_STR);
		$sql_author->execute();
		$author_id = $sql_author->fetchObject();
						
		?>      	
					<tr>
						<td><a class="itm-table_pri" href="<?=$link_lit?>"><?=$title_lit?></a>
						</td>
						<td data-label="Jahr"><?=$year_lit?></td>
						<td data-label="Autor"><a class="itm-table_sec" href="../denker/index.php?q=<?=$author_id->id?>"><?=$autor_lit?></a></td>
						<td data-label="Typ"><?=$typ_lit?></td>
						<td data-label="Sprache"><?=$sprache?></td>
						<td>free/amazon</td>
					</tr>
		<?
	}
?> 				</tbody>
			</table>  
		</div>
	</div>
<?	
	include "../page/footer.inc.php";
?>