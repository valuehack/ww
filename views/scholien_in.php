<?php 

require_once('../classes/Login.php');

include('_header.php'); 

$title="Scholien";

if(isset($_GET['q']))
{
	$id = $_GET['q'];

 	$sql = "SELECT * from blog WHERE id='$id'";
	$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
	$entry = mysql_fetch_array($result);

	$title = $entry[title];
	$img = $entry[img];
	$private = $entry[private_text];
	$public = $entry[public_text];
	$publ_date = $entry[publ_date];
	$length = str_word_count($private, 0, 'äüöÄÜÖß') - str_word_count($public, 0, 'äüöÄÜÖß');

	//check, if there is a image in the scholien folder
	$img = 'http://test.wertewirtschaft.net/scholien/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/scholien/default.jpg";
	}

?>

		<!--<div class="banner_blog">
            <div class="banner_blogimg" style="background-image: url(<?php echo $img_url;?>);"></div>
            <div class="banner_blogms"><h1><?=$title?></h1></div>
     </div>-->
        <aside class="social">
                   <ul>
                       <li><a href="https://www.facebook.com/sharer/sharer.php?u=http://test.wertewirtschaft.net/blog/index.php?id=<?php echo $id;?>" target="_blank"><img src="gfx/facebook.png" alt="Facebook" title="Teile diesen Post auf Facebook!"></a></li>
                       <li><a href="http://twitter.com/share?url=http://test.wertewirtschaft.net/blog/index.php?id=<?php echo $id;?>&text=<?php echo $id;?>&hashtags=<?php echo $id;?>" target="_blank"><img src="gfx/twitter.png" alt="Twitter" title="Tweete diesen Post!"></a></li>
                       <li><a href="https://plus.google.com/share?url=http://test.wertewirtschaft.net/blog/index.php?id=<?php echo $id;?>" target="_blank"><img src="gfx/google.png" alt="Google+" title="Teile diesen Post auf Google+!"></a></li>
                       <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=http://test.wertewirtschaft.net/blog/index.php?id=<?php echo $id;?>" target="_blank"><img src="gfx/linkedin.png" alt="Linkedin" title="Teile diesen Post auf Linkedin!"></a></li>
                       <li><a href="https://www.xing-share.com/app/user?op=share;sc_p=xing-share;url=http://test.wertewirtschaft.net/blog/index.php?id=<?php echo $id;?>" target="_blank"><img src="gfx/xing.png" alt="Facebook" title="Teile diesen Post auf Xing!"></a></li>
                    </ul>                 
               </aside>
        <div class="content">
           <article class="article">
           	
        <div class="blog_img">
        	<img class="blog_img" src="<?php echo $img_url;?>" alt="<?php echo $id?>"> 
        </div>   	
<?  
	if ($_SESSION['Mitgliedschaft'] == 1) { 
		echo "<div>";
		echo '<p class="scholie_info">Mit Scholion bezeichnete man urspr&uuml;nglich eine Randnotiz, die Gelehrte in den B&uuml;chern anbrachten, die ihre st&auml;ndigen Wegbegleiter waren. Heute sind die Scholien die Randnotizen von <a href="http://rahim.cc">Rahim Taghizadegan</a>, die Erkenntnisgewinne im Rahmen der Wertewirtschaft dokumentieren: der tiefgehenden Reflexion und praktischen &Uuml;berpr&uuml;fung der M&ouml;glichkeiten, unter erschwerten Bedingungen noch Werte zu schaffen, Realit&auml;t von Illusion zu unterscheiden und Sinn zu finden. Um alle Scholien in voller Länge lesen zu können, <a href="/upgrade.php"> beehren Sie uns bitte als Gast</a></p>';
		echo "</div>";
		echo "<h1>$title</h1>";
		echo "<p class='linie'><img src='gfx/linie.png' alt=''></p>";
		}	

	echo "<p class='blogdate'><!--Keyword: ".$id."&nbsp &nbsp &nbsp-->".date('d.m.Y', strtotime($publ_date))."</p>";		
	if ($_SESSION['Mitgliedschaft'] == 1) {
		echo "<div class='blog_b'>";
		echo "<img class='blog_img' src='$img_url' alt='$id''>";
		echo $public;
		echo "</div>";
?>		<div class="upgrade">
		<p>Weitere <? echo $length;?> W&ouml;rter Kontext nur f&uuml;r G&auml;ste. Wir freuen uns, dass Sie &uuml;ber die Scholien an unseren Erkenntnissen teilhaben m&ouml;chten. Die Scholien enthalten oft allzu pers&ouml;nliche Gedanken, Hintergrundinformationen, intimes Wissen, sind aus gesetzlichen Gr&uuml;nden nicht teilbar, oder sonstwie heikel. Wir k&ouml;nnen Sie nur G&auml;sten offen zug&auml;nglich machen, die einen kleinen Kostenbeitrag (6,25&euro;) f&uuml;r das Bestehen der Wertewirtschaft leisten (und daf&uuml;r auch die meisten Schriften kostenlos beziehen k&ouml;nnen). K&ouml;nnen Sie sich das leisten? Dann folgen Sie <a href="http://wertewirtschaft.org/abo.php">diesem Link</a> und in K&uuml;rze erhalten Sie Zugriff auf alle unsere Scholien in voller L&auml;nge.</p>

		<a class="linkbutton" href="/upgrade.php">Upgrade</a>
		</div>
		<footer class="article">
		<p><a href="index.php">Alle Scholien</a></p>
<?
	}

	else {
		echo "<h1>$title</h1>";
		echo "<div class='blog_b'>";
		echo $private;
		echo "</div>";
		echo "<footer class='article'>";
		echo "<p><a href='index.php'>Alle Scholien</a></p>";
		
	}
?>
				<!--<footer class="article">-->			   
                   <div class="socialimg">
                   <a href="https://www.facebook.com/sharer/sharer.php?u=http://test.wertewirtschaft.net/blog/index.php?id=<?php echo $id;?>" target="_blank"> <img src="gfx/facebook.png" alt="Facebook" title="Teile diesen Post auf Facebook!"></a>
                   <a href="http://twitter.com/share?url=http://test.wertewirtschaft.net/blog/index.php?id=<?php echo $id;?>&text=<?php echo $id;?>&hashtags=<?php echo $id;?>" target="_blank"><img src="gfx/twitter.png" alt="Twitter" title="Tweete diesen Post!"></a>
                   <a href="https://plus.google.com/share?url=http://test.wertewirtschaft.net/blog/index.php?id=<?php echo $id;?>" target="_blank"><img src="gfx/google.png" alt="Google+" title="Teile diesen Post auf Google+!"></a>
                   <a href="http://www.linkedin.com/shareArticle?mini=true&url=http://test.wertewirtschaft.net/blog/index.php?id=<?php echo $id;?>" target="_blank"><img src="gfx/linkedin.png" alt="Linkedin" title="Teile diesen Post auf Linkedin!"></a>
                   <a href="https://www.xing-share.com/app/user?op=share;sc_p=xing-share;url=http://test.wertewirtschaft.net/blog/index.php?id=<?php echo $id;?>" target="_blank"><img src="gfx/xing.png" alt="Xing" title="Teile diesen Post auf Xing!"></a>
                   </div>
               </footer>
               <p class="linie"><img src="gfx/linie.png" alt=""></p>
<?	
}

else 
{
	//Pagination Script found at http://www.phpeasystep.com/phptu/29.html
	$tbl_name="blog";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num FROM $tbl_name";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	$targetpage = "index.php"; 	//your file name  (the name of this file)
	$limit = 5; 								//how many items to show per page
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$sql = "SELECT * from blog WHERE publ_date<=CURDATE() order by publ_date desc, id asc LIMIT $start, $limit";
	
	$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
	

		/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\">« zur&uuml;ck</a>";
		else
			$pagination.= "<span class=\"disabled\">« zur&uuml;ck</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\">vor »</a>";
		else
			$pagination.= "<span class=\"disabled\">vor »</span>";
		$pagination.= "</div>\n";		
	}
?>
	 <div class="content">
           <article class="article">
           	<header>
			<h1>Scholien</h1>
			</header>
	
		<?php if ($_SESSION['Mitgliedschaft'] == 1) { 
		echo "<div>";
		echo '<p class="scholie_info">Mit Scholion bezeichnete man urspr&uuml;nglich eine Randnotiz, die Gelehrte in den B&uuml;chern anbrachten, die ihre st&auml;ndigen Wegbegleiter waren. Heute sind die Scholien die Randnotizen von <a href="http://rahim.cc">Rahim Taghizadegan</a>, die Erkenntnisgewinne im Rahmen der Wertewirtschaft dokumentieren: der tiefgehenden Reflexion und praktischen &Uuml;berpr&uuml;fung der M&ouml;glichkeiten, unter erschwerten Bedingungen noch Werte zu schaffen, Realit&auml;t von Illusion zu unterscheiden und Sinn zu finden. Um alle Scholien in voller Länge lesen zu können, <a href="/upgrade.php"> beehren Sie uns bitte als Gast</a>.</p>';
		echo "</div>";
		echo "<p class='linie'><img src='gfx/linie.png' alt=''></p>";
		}


		while($entry = mysql_fetch_array($result))
		{
	
		$id = $entry[id];
		$title = $entry[title];
		$private = $entry[private_text];
		$publ_date = $entry[publ_date];

		echo "<div class='blog_entry'>";
		echo "<h2><a href='?q=$id'>".$title."</a></h2>";
		echo "<p class='blogdates'><!--Keyword: ".$id."&nbsp &nbsp &nbsp Datum: -->".date('d.m.Y', strtotime($publ_date))."</p>";
		
		if (strlen($private) > 500) {
			echo substr ($private, 0, 500);
			echo " ... <a href='?q=$id'>Weiterlesen</a>";
			echo "</div>";
			echo "<p class='linie'><img src='gfx/linie.png' alt=''></p>";
		}
		else {
			echo $private;
			echo "... <a href='?q=$id'>Weiterlesen</a>";
			echo "</div>";
			echo "<p class='linie'><img src='gfx/linie.png' alt=''></p>";
		}
	}
}
	?>

<?=$pagination?>
           </article> 
        </div>
        
<?php //include('_side_in.php'); ?>

<?php include('_footer_blog.php'); ?>
