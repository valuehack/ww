<? 
	require_once (dirname(__DIR__)."/config/header1.inc.php");

	$title='Literatur';

	include '../page/header2.inc.php';
?>

<!--Content-->

    <div id="content">      	
<?
	if (isset($_GET['autor'])) {
		$author_name = $general->getInfo('denker', $_GET['autor']);
		
		$result_book = $general->getSpecialList('*', 'buecher', 'autor', $author_name->name, 'jahr', 'desc');
				
		/*$sql_book = $general->db_connection->prepare('SELECT * FROM buecher WHERE autor = :autor ORDER BY jahr DESC');
		$sql_book->bindValue(':autor', $author_name->name, PDO::PARAM_STR);
		$sql_book->execute();
		$result_book = $sql_book->fetchAll();*/
		
		for ($m = 0; $m < count($result_book); $m++) {
			$result_book[$m]['type'] = 'Buch';
		}
		
		$result_art = $general->getSpecialList('*', 'artikel', 'autor', $author_name->name, 'jahr', 'desc');
		
		/*$sql_art = $general->db_connection->prepare('SELECT * FROM artikel WHERE autor = :autor ORDER BY jahr DESC');
		$sql_art->bindValue(':autor', $author_name->name, PDO::PARAM_STR);
		$sql_art->execute();
		$result_art = $sql_art->fetchAll();*/
		
		for ($n = 0; $n < count($result_art); $n++) {
			$result_art[$n]['type'] = 'Artikel';
		}
		
		$result_lit = array_merge($result_book, $result_art);
		
		foreach ($result_lit as $key => $row) {
			$id[$key] = $row['id'];
			$year[$key] = $row['jahr'];
		}
				
		array_multisort($year, SORT_DESC, $id, SORT_ASC, $result_lit);
	}
	else {
		# get Buecher and Artikel List and add the type (Buch, Artikel) to the result array			
		$result_book = $general->getItemList('buecher', 'jahr', 'ASC');
		for ($m = 0; $m < count($result_book); $m++) {
			$result_book[$m]['type'] = 'Buch';
		}
		
		$result_art = $general->getItemList('artikel', 'jahr', 'ASC');
		for ($n = 0; $n < count($result_art); $n++) {
			$result_art[$n]['type'] = 'Artikel';
		}
		# merge both arrays to one and sort it
		$result_lit = array_merge($result_book, $result_art);
		foreach ($result_lit as $key => $row) {
			$id[$key] = $row['id'];
			$year[$key] = $row['jahr'];
		}				
		array_multisort($year, SORT_DESC, $id, SORT_ASC, $result_lit);

	}
	$author_list = $general->getItemList('denker', 'id', 'ASC');
	$author_l = $general->clearAuthorList($author_list);
	$x = count($author_l)/4;	
?>
      	<div class="container index-link"><p><a href="../">mises.at</a> / Literatur</p></div>
      	<div class="container">
      		<h1>Literatur</h1>
      		<?if (isset($_GET['autor'])) echo '<h3><a href="../denker/?denker='.$_GET['autor'].'">'.$author_name->name.'</a></h3>';?>
      	</div>
      	
      	<div class="container">
      		<div class="style-space--bottom">
      			<button class="reiter showhide">Nach Autor filtern</button>
      			<div class="hidden row reiter--ctn">
      				<div class="three columns">
<?php
      				for ($j = 0; $j <= $x; $j++) {
						echo '<a href="?autor='.$author_l[$j]['id'].'">'.$author_l[$j]['name'].'</a><br>';
					}
?>      					
      				</div>
      				<div class="three columns">
<?php
      				for ($j = $x+1; $j <= $x*2; $j++) {
						echo '<a href="?autor='.$author_l[$j]['id'].'">'.$author_l[$j]['name'].'</a><br>';
					}
?>      					
      				</div>
      				<div class="three columns">
<?php
      				for ($j = ($x*2)+1; $j <= $x*3; $j++) {
						echo '<a href="?autor='.$author_l[$j]['id'].'">'.$author_l[$j]['name'].'</a><br>';
					}
?>      					
      				</div>
      				<div class="three columns">
<?php
      				for ($j = ($x*3)+1; $j <= count($author_l); $j++) {
						echo '<a href="?autor='.$author_l[$j]['id'].'">'.$author_l[$j]['name'].'</a><br>';
					}
?>
      				</div>
      			</div>     			
      		</div>
      		<table class="itm-table h-full-width sortable">
      			<thead>
      				<tr>
      					<th class="list_head">Titel</th>
      					<th class="list_head">Jahr</th>
      					<th class="list_head">Autor</th>
      					<th class="list_head">Typ</th>
      					<th class="list_head">Sprache</th>
      					<th class="list_head">Link</th>
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
		$quelle_lit = $result_lit[$i]['quelle'];
		$typ_lit = $result_lit[$i]['type'];
  		
		switch($lang_lit) {
			case 'en': $lang = 'English'; break;
			case 'fr': $lang = 'Franz&ouml;sisch'; break;
			case 'es': $lang = 'Spanisch'; break;
			case 'it': $lang = 'Italienisch'; break;
			case 'nl': $lang = 'Niederl&auml;ndisch'; break;
			case 'pt': $lang = 'Portugiesisch'; break;
			case 'pl': $lang = 'Polnisch'; break;
			case 'jp': $lang = 'Japanisch'; break;
			case 'hu': $lang = 'Ungarisch'; break;
			default: $lang = 'Deutsch'; break;
		}
				
			 $author_id = $general->getSpecialObject('id', 'denker', 'name', $autor_lit);
				
  		/*$sql_author = $general->db_connection->prepare('SELECT id FROM denker WHERE name = :name');
  		$sql_author->bindValue(':name', $autor_lit, PDO::PARAM_STR);
		$sql_author->execute();
		$author_id = $sql_author->fetchObject();*/
						
		if ($quelle_lit == "PDF") { 
			$sitelink = "./".$typ_lit."/".$id_lit.".pdf"; 
		}
		else if (empty($quelle_lit)) {
			$sitelink = '';
		}
		else {
			$sitelink = $link_lit;
		}
		
		?>      	
					<tr>
						<!--? if($quelle_lit == "PDF"){
							echo '<td><a class="itm-table_pri" target="_blank" href="./Buecher/'.$id_lit.'.pdf">'.$title_lit.'</a></td>';
						} else if (empty($link_lit)) {
							echo '<td>'.$title_lit.'</td>';
						} else {
							echo '<td><a class="itm-table_pri" target="_blank" href="'.$link_lit.'">'.$title_lit.'</a></td>';
						}
						?-->
						
						<td><?
						if (empty($sitelink)) {
							echo $title_lit;
						} else {
							echo '<a class="list_title" target="_blank" href="'.$sitelink.'">'.$title_lit.'</a>';
						}
						?></td>
						<td data-label="Jahr"><?=$year_lit?></td>
						<td data-label="Autor"><a class="itm-table_sec" href="../denker/?denker=<?=$author_id->id?>"><?=$autor_lit?></a></td>
						<td data-label="Typ"><?=$typ_lit?></td>
						<td data-label="Sprache"><?=$lang?></td>
						<td><a class="itm-table_pri" target="_blank" href="<?=$sitelink?>"><?=$quelle_lit?></a></td>
						
						
						<!--? if($quelle_lit == "PDF" && $typ_lit == "Artikel"){
							echo '<td><a class="itm-table_pri" target="_blank" href="'.$sitelink.'">'.$quelle_lit.'</a></td>'; 
						}
							else if ($quelle_lit == "PDF") {
							echo '<td><a class="itm-table_pri" target="_blank" href="'.$sitelink.'">'.$quelle_lit.'</a></td>'; 
						} else if (empty($quelle_lit)) {
							echo '<td>'.$quelle_lit.'</td>';
						} else {
							echo '<td><a class="itm-table_pri" target="_blank" href="'.$sitelink.'">'.$quelle_lit.'</a></td>';
						}
						?-->
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
