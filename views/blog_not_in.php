<!--Author: Bernhard Hegyi
    Content: Blog view for non-members-->

<?php 

require_once('../classes/Login.php');
include('_header_not_in.php'); 
$title="Blog";

?>

<!--<div id="center">  
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a><a class="content" href="<?php echo $_SERVER['PHP_SELF']; ?>"> Blog</a>
<div id="tabs-wrapper-lower"></div>-->

<?php 
if(isset($_GET['id']))
{
	// #$scholien = htmlentities($scholien);

	// echo $scholien;

	$id = $_GET['id'];

 	$sql = "SELECT * from blog WHERE id='$id'";
	$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
	$entry = mysql_fetch_array($result);

	$title = $entry[title];
	$public = $entry[public_text];
	$publ_date = $entry[publ_date];
?>
	<div class="banner_blog">
    	<div class="banner_blogimg" style="background-image: url(http://test.wertewirtschaft.net/blog/gfx/<?php echo $id;?>.jpg);"></div>
    	<div class="banner_blogms"><h1><?=$title?></h1></div>
    </div>
        <aside class="social">
                   <ul>
                       <li><a href=""><img src="gfx/facebook.png" alt="Facebook" title="Teile diesen Post auf Facebook!"></a></li>
                       <li><a href=""><img src="gfx/twitter.png" alt="Twitter" title="Tweete diesen Post!"></a></li>
                       <li><a href=""><img src="gfx/google.png" alt="Google+" title="Teile diesen Post auf Google+!"></a></li>
                       <li><a href=""><img src="gfx/linkedin.png" alt="Linkedin" title="Teile diesen Post auf Linkedin!"></a></li>
                       <li><a href=""><img src="gfx/xing.png" alt="Facebook" title="Teile diesen Post auf Xing!"></a></li>
                    </ul>                 
        </aside>
        <div class="content">
           <article class="article">
<?
	echo "<p class='blogdate'><!--Keyword: ".$id."&nbsp &nbsp &nbsp-->".date('d.m.Y', strtotime($publ_date))."</p>";
	echo "<div class='blog_b'>";
	echo $public;
?>
	<div class="upgrade">
		<p>Institutsgr&uuml;nder Rahim Taghizadegan l&auml;dt ein zu einer ganz pers&ouml;nlichen Weltschau. Seine Scholien (Scholion: Randnotiz) erscheinen als Quartalsschrift und enthalten Gedanken, Ideen, Fragen, Rezensionen, Empfehlungen, Exzerpte, Gedichte, Kontakte und Fundst&uuml;cke. Dieses Angebot richtet sich primär an Freunde und Seelenverwandte und ist daher pers&ouml;nlich und frei von der Leber geschrieben - ohne Blatt vor dem Mund.</p>
		<p><i>Wenn Sie weiterlesen wollen, tragen Sie sich hier völlig unverbindlich ein:</i></p>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform" style="text-aligna:center; paddinga: 10px ">
  			<input class="inputfield" id="user_email" type="email" placeholder=" E-Mail Adresse" name="user_email" required /><br>
  			<input class="inputbutton" type="submit" name="subscribe" value="Eintragen" />
		</form>
	</div>
	</div>
	<footer class="article">
		<p><a href='index.php'>Alle Scholien</a></p>
		<div class="socialimg">
                   <a href=""><img src="gfx/facebook.png" alt="Facebook" title="Teile diesen Post auf Facebook!"></a>
                   <a href=""><img src="gfx/twitter.png" alt="Twitter" title="Tweete diesen Post!"></a>
                   <a href=""><img src="gfx/google.png" alt="Google+" title="Teile diesen Post auf Google+!"></a>
                   <a href=""><img src="gfx/linkedin.png" alt="Linkedin" title="Teile diesen Post auf Linkedin!"></a>
                   <a href=""><img src="gfx/xing.png" alt="Facebook" title="Teile diesen Post auf Xing!"></a>
                   </div>
    </footer>
		<p class="linie"><img src="gfx/linie.png" alt=""></p>
<?php
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
	
	$sql = "SELECT * from blog WHERE publ_date<=CURDATE() order by publ_date desc, id asc LIMIT $start, $limit";	//$sql = "SELECT * from blog WHERE 'date'>='".date("Y-m-d")."'";
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
			$pagination.= "<a href=\"$targetpage?page=$next\">vor</a>";
		else
			$pagination.= "<span class=\"disabled\">vor</span>";
		$pagination.= "</div>\n";		
	}
?>
		<div class="content">
           <article class="article">
           	<header>
			<h1>Scholien</h1>
			</header>
	<?php
	while($entry = mysql_fetch_array($result))
	{
		$id = $entry[id];
		$title = $entry[title];
		$public = $entry[public_text];
		$publ_date = $entry[publ_date];

		echo "<div class='blog_entry'>";
		echo "<h2><a href='?id=$id'>".$title."</a></h2>";
		echo "<p class='blogdates'><!--Keyword: ".$id."&nbsp &nbsp &nbsp Datum: -->".date('d.m.Y', strtotime($publ_date))."</p>";
		
		if (strlen($private) > 500) {
			echo substr ($private, 0, 500);
			echo " ... <a href='?id=$id'>Weiterlesen</a>";
			echo "</div>";
			echo "<p class='linie'><img src='gfx/linie.png' alt=''></p>";
		}
		else {
			echo $private;
			echo "... <a href='?id=$id'>Weiterlesen</a>";
			echo "</div>";
			echo "<p class='linie'><img src='gfx/linie.png' alt=''></p>";

		}
	}
}
?>

<?=$pagination?>

</article>
</div>
<?php //include('_side_not_in.php'); ?>

<?php include('_footer_blog.php'); ?>