<? 
	require_once '../../config/config.php';
	include '../config/db.php';

	$title='Literatur';

	include '../page/header2.inc.php';
?>

<!--Content-->

    <div id="content">      	
<?
	if (isset($_GET['author'])) {
		$sql_author = $pdocon->db_connection->prepare('SELECT name FROM denker WHERE id = :authorid');
  		$sql_author->bindValue(':authorid', $_GET['author'], PDO::PARAM_STR);
		$sql_author->execute();
		$author_name = $sql_author->fetchObject();
		
		$sql_lit = $pdocon->db_connection->prepare('SELECT * FROM buecher WHERE autor = :author UNION ALL SELECT * FROM artikel WHERE autor = :author ORDER BY jahr DESC');
		$sql_lit->bindValue(':author', $author_name->name, PDO::PARAM_STR);
    	$sql_lit->execute();
		$result_lit = $sql_lit->fetchAll();
	}
	else {
		if (isset($_GET['order'])) {
			$order = $_GET['order'];
		}
		else {
			$order = 'n';
		}
		$sql_lit = $pdocon->db_connection->prepare('SELECT * FROM buecher UNION ALL SELECT * FROM artikel ORDER BY '.$order.' DESC');
    	$sql_lit->execute();
		$result_lit = $sql_lit->fetchAll();
	}
	$sql_author_list = $pdocon->db_connection->prepare('SELECT * FROM denker ORDER BY id');
	$sql_author_list->execute();
	$author_list = $sql_author_list->fetchAll();	
	$x = count($author_list)/4;	
?>
      	<div class="container index-link"><p><a href="../">Mises Austria</a> / <a href="">Literatur</a></p></div>
      	<div class="container">
      		<h1>Literatur</h1>
      		
      		<?if (isset($_GET['author'])) echo '<h3><a href="../denker/?q='.$_GET['author'].'">'.$author_name->name.'</a></h3>';?>
      	</div>
      	
      	<div class="container">
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
      		<table class="itm-table h-full-width">
      			<thead>
      				<tr><th>Titel (Jahr)</th><th><a href="?order=id" title="Nach Autor sortieren">Autor</a></th><th><a href="?order=sprache" title="Nach Sprache sortieren">Sprache</a></th><th>Quelle</th></tr>
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
  		
		if ($lang_lit == 'en') {$sprache = 'Englisch';} 
		else {$sprache = 'Deutsch';}
		
  		$sql_author = $pdocon->db_connection->prepare('SELECT id FROM denker WHERE name = :name');
  		$sql_author->bindValue(':name', $autor_lit, PDO::PARAM_STR);
		$sql_author->execute();
		$author_id = $sql_author->fetchObject();
						
		?>      	
					<tr>
						<td><a class="itm-table_pri" href="<?=$link_lit?>"><?=$title_lit?></a> (<?=$year_lit?>)<br>
						</td>
						<td data-label="Autor"><a class="itm-table_sec" href="../denker/index.php?q=<?=$author_id->id?>"><?=$autor_lit?></a></td>
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
