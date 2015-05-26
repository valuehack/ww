<?php 

require_once('../classes/Login.php');
include('_header_not_in.php'); 
$title="Scholien";

if(isset($_GET['q']))
{
	// #$scholien = htmlentities($scholien);

	// echo $scholien;

	$id = $_GET['q'];

 	$sql = "SELECT * from blog WHERE id='$id'";
	$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
	$entry = mysql_fetch_array($result);

	$title = $entry[title];
	$public = $entry[public_text];
	$private = $entry[private_text];
	$publ_date = $entry[publ_date];
	$length = str_word_count($private, 0, 'äüöÄÜÖß') - str_word_count($public, 0, 'äüöÄÜÖß');

	//check, if there is a image in the blog/gfx folder
	$img = 'http://test.wertewirtschaft.net/scholien/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://test.wertewirtschaft.net/scholien/default.jpg";
	}

?>
        <aside class="social">
                   <ul>
                       <li><a href="https://www.facebook.com/sharer/sharer.php?u=http://test.wertewirtschaft.net/scholien/index.php?id=<?php echo $id;?>" target="_blank"><img src="../style/gfx/facebook.png" alt="Facebook" title="Teile diesen Post auf Facebook!"></a></li>
                       <li><a href="http://twitter.com/share?url=http://test.wertewirtschaft.net/scholien/index.php?id=<?php echo $id;?>&text=<?php echo $id;?>&hashtags=<?php echo $id;?>" target="_blank"><img src="../style/gfx/twitter.png" alt="Twitter" title="Tweete diesen Post!"></a></li>
                       <li><a href="https://plus.google.com/share?url=http://test.wertewirtschaft.net/scholien/index.php?id=<?php echo $id;?>" target="_blank"><img src="../style/gfx/google.png" alt="Google+" title="Teile diesen Post auf Google+!"></a></li>
                       <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=http://test.wertewirtschaft.net/scholien/index.php?id=<?php echo $id;?>" target="_blank"><img src="../style/gfx/linkedin.png" alt="Linkedin" title="Teile diesen Post auf Linkedin!"></a></li>
                       <li><a href="https://www.xing-share.com/app/user?op=share;sc_p=xing-share;url=http://test.wertewirtschaft.net/scholien/index.php?id=<?php echo $id;?>" target="_blank"><img src="../style/gfx/xing.png" alt="Facebook" title="Teile diesen Post auf Xing!"></a></li>
                    </ul>                 
        </aside>
        <div class="content">
           <article class="blog">
<?
	echo "<header>";
	echo "<h1>$title</h1>";
	echo "</header>";
	echo "<p class='linie'><img src='../style/gfx/linie.png' alt=''></p>";
	echo "<p class='blogdate'><!--Keyword: ".$id."&nbsp &nbsp &nbsp-->".date('d.m.Y', strtotime($publ_date))."</p>";
	echo "<img class='blog_img' src='$img_url' alt='$id''>";
	echo "<div class='blog_text'>";
	echo $public;
	echo "</div>"
?>
	<div class="blog_upgrade">
		<p>Weitere <? echo $length;?> W&ouml;rter Kontext nur f&uuml;r G&auml;ste. Bitte um Verzeihung, dieser Text ist f&uuml;r Fremde nicht sichtbar. 
		Er k&ouml;nnte allzu pers&ouml;nliche Gedanken, Hintergrundinformationen, intimes Wissen enthalten, aus gesetzlichen Gr&uuml;nden nicht teilbar, oder sonstwie heikel sein. 
		Beehren Sie eine der letzten v&ouml;llig unabh&auml;ngigen Bildungs- und&nbsp;Forschungseinrichtungen als Gast und sichern Sie sich Ihren Wissensvorteil. 
		Treten Sie dazu bitte zun&auml;chst einen Schritt weit aus der Anonymit&auml;t und tragen Sie hier Ihre E-Mail-Adresse ein:</p>

		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform" style="text-aligna:center; paddinga: 10px ">
  			<input class="inputfield" id="user_email" type="email" placeholder=" E-Mail Adresse" name="user_email" required />
  			<input class="inputbutton" type="submit" name="subscribe" value="Eintragen" />
		</form>
	</div>
	<footer class="blog_footer">
		<p><a href='index.php'>Alle Scholien</a></p>
		<div class="socialimg">
                   <a href="https://www.facebook.com/sharer/sharer.php?u=http://test.wertewirtschaft.net/scholien/index.php?id=<?php echo $id;?>" target="_blank"> <img src="gfx/facebook.png" alt="Facebook" title="Teile diesen Post auf Facebook!"></a>
                   <a href="http://twitter.com/share?url=http://test.wertewirtschaft.net/scholien/index.php?id=<?php echo $id;?>&text=<?php echo $id;?>&hashtags=<?php echo $id;?>" target="_blank"><img src="../style/gfx/twitter.png" alt="Twitter" title="Tweete diesen Post!"></a>
                   <a href="https://plus.google.com/share?url=http://test.wertewirtschaft.net/scholien/index.php?id=<?php echo $id;?>" target="_blank"><img src="../style/gfx/google.png" alt="Google+" title="Teile diesen Post auf Google+!"></a>
                   <a href="http://www.linkedin.com/shareArticle?mini=true&url=http://test.wertewirtschaft.net/scholien/index.php?id=<?php echo $id;?>" target="_blank"><img src="../style/gfx/linkedin.png" alt="Linkedin" title="Teile diesen Post auf Linkedin!"></a>
                   <a href="https://www.xing-share.com/app/user?op=share;sc_p=xing-share;url=http://test.wertewirtschaft.net/scholien/index.php?id=<?php echo $id;?>" target="_blank"><img src="../style/gfx/xing.png" alt="Xing" title="Teile diesen Post auf Xing!"></a>
                   </div>
    </footer>
		<p class="linie"><img src="../style/gfx/linie.png" alt=""></p>
<?php
}
else 
{
?>
<div class="content">
           <article class="blog">
			<div class="blog_text">
			<p>Mit Scholion bezeichnete man urspr&uuml;nglich eine Randnotiz, die Gelehrte in den B&uuml;chern anbrachten, die ihre st&auml;ndigen Wegbegleiter waren. Heute sind die Scholien die Randnotizen von <a href="http://www.rahim.cc">Rahim Taghizadegan</a>, die Erkenntnisgewinne im Rahmen der Wertewirtschaft dokumentieren: der tiefgehenden Reflexion und praktischen &Uuml;berpr&uuml;fung der M&ouml;glichkeiten, unter erschwerten Bedingungen noch Werte zu schaffen, Realit&auml;t von Illusion zu unterscheiden und Sinn zu finden.</p>
			<p>Das Institut f&uuml;r Wertewirtschaft ist ein lernendes Unternehmen, in dem aus der Spannung zwischen mu&szlig;evoll-theoretischer Reflexion und praktisch-unternehmerischem Schaffen Erkenntnis gewonnen wird. Die Sp&auml;ne, die bei dieser Erkenntnissuche abfallen, teilt <a href="http://www.rahim.cc">Rahim Taghizadegan</a> an dieser Stelle mit Seelenverwandten. Die Scholien sind daher pers&ouml;nlich und frei von der Leber geschrieben &ndash; ohne Blatt vor dem Mund.</p>
			<p>Themen: Unternehmerische Herausforderungen auf verzerrten M&auml;rkten, Werte und Wirtschaft, Theorie und Praxis des guten Lebens, Freiheit und Ordnung, Erkenntnis, Dynamiken und Hintergr&uuml;nde der Gegenwart und Vergangenheit, Ideengeschichte, Alternativen und Traditionen, Aktuelles und Zeitloses, Strategie und Einstellung, Sprache und Symbole, Spirituelles und Materielles, Fragen und Antworten, hilfreiche Hinweise und Ratschl&auml;ge, Kunst und Kultur.</p>
			<p>Die Scholien sind eine Anregung f&uuml;r Vielleser, aber vielmehr noch eine Dienstleistung f&uuml;r Wenigleser &ndash; insbesondere f&uuml;r Praktiker, die es auch unter schwierigsten Bedingungen nicht aufgeben, Werte zu schaffen und zu wahren, und f&uuml;r Erkenntnis- und Sinnsucher in Zeiten inflation&auml;rer Desinformation.</p>
			<p>Wenn Sie sich angesprochen f&uuml;hlen, treten Sie doch bitte zun&auml;chst einen Schritt weit aus der Anonymit&auml;t und tragen Sie hier Ihre E-Mail-Adresse ein, Sie k&ouml;nnen dann die letzten Scholien-Beitr&auml;ge anlesen.</p>
		</div>
		<div class="blog_subscribe">
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform">
        <input class="inputfield" id="keyword" type="email" placeholder=" E-Mail Adresse" name="user_email" autocomplete="off" required />
        <input class="inputfield" id="user_password" type="password" name="user_password" placeholder=" Passwort" autocomplete="off" style="display:none"  />
        <input class="inputbutton" id="inputbutton" type="submit" name="fancy_ajax_form_submit" value="Eintragen" />
      </form>	
		</div>
		<p class="linie"><img src="../style/gfx/linie.png" alt=""></p>
		
</article>
</div>

<?php 
}
include('_footer_blog.php'); ?>