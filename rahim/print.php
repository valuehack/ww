<?
$active="magazine";
include "/home/li000089/www/home/wien/header1.inc.php";
if ($id)
	{
  @$con=mysql_connect("mysql.liberty.li","li000089","vr2u39") or die ("cannot connect to MySQL");
  $sql="SELECT * from li000089_wertewirtschaft.magazin WHERE id='$id'";
	$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
	$entry = mysql_fetch_array($result);
  $title=$entry[title];
	?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<title>bildungsfreiheit.org - <? if ($title) echo $title; ?></title>
<META HTTP-EQUIV="CHARSET" CONTENT="ISO-8859-1">
<META HTTP-EQUIV="CONTENT-LANGUAGE" CONTENT="Deutsch">
<META NAME="RATING" CONTENT="General">
<META NAME="ROBOTS" CONTENT="index,follow">
<META NAME="REVISIT-AFTER" CONTENT="2 days">
<link rel="shortcut icon" href="http://www.liberty.li/favicon.ico" type="image/x-icon" />
<link rel="alternate" type="application/rss+xml" title="RSS" href="http://feeds.feedburner.com/<?=$language?>-liberty-li" />
<link rel="stylesheet" type="text/css" href="http://<?=$language?>.liberty.li/style.css" />
</head>
<body style="background:white;font-size: 12px;">
<!-- google_ad_section_start(weight=ignore) -->

<SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT">
<!--
	if (document.referrer.indexOf('wienerschule.org') == -1)
   	window.location='<?="http://wienerschule.org/?id=".$id."&q=".ereg_replace(" ","+",$entry[title])?>';
//-->
</SCRIPT>

	<div style="width:596px;padding:5px">
	<?
  if (!ereg("0000",$entry[time])) $date=strftime("%d.%m.%Y", strtotime($entry[time]));
  else $date=strftime("%d.%m.%Y", strtotime($entry[time_input]));

    echo "<div class=\"magentry\">";
    if (!ereg("0000",$entry[time])) $date=strftime("%d.%m.%Y", strtotime($entry[time]));
  else $date=strftime("%d.%m.%Y", strtotime($entry[time_input]));
    $preview=$entry[id];
 echo "<h2><a href=\"http://$language.liberty.li/magazine/?id=$entry[id]&q=".ereg_replace(" ","+",$entry[title])."\" style=\"border:none;\">"; ?>
    <?=$entry[title]?></a></h2>
    <? echo "<div class=\"magauthor\">";
     echo $date.", ";
    if (ereg("MSIE",$_SERVER['HTTP_USER_AGENT'])) $authorlink="http://$language.liberty.li/user/".urlencode(Username($entry[userid]));
    else $authorlink="http://$language.liberty.li/user/".Username($entry[userid]);
    if (Username($entry[userid])&&Username($entry[userid])==$entry[author]&&$entry[type]!="quotes") echo "<a href=\"$authorlink\">$entry[author]</a>";
    elseif (Username($entry[userid])&&Username($entry[userid])!=$entry[author]&&$entry[type]!="quotes") echo "$entry[author] (<a href=\"$authorlink\">".Username($entry[userid])."</a>)";
    else echo "(<a href=\"$authorlink\">".Username($entry[userid])."</a>)";
    echo "</div>"; ?>

<?
		if ($entry[text])
      {
      echo "<div id=\"item\" >";
      echo stripslashes($entry[text]);
      }
  if ($entry[asin]&&ereg("amazon",$entry[shop]))
 	   {
	    ?>
	    <div align="right"><a href="http://www.amazon.<?=$amazon?>/exec/obidos/ASIN/<?=$entry[asin]?>/<?=$amazonid[$amazon]?>/" target="_blank" id="nolink"><img src="http://www.liberty.li/Img/amazon.<?=$amazon?>.gif" alt="" border="0"></a></div>
	    <?
	    }
  elseif ($entry[asin]&&ereg("lfb",$entry[shop]))
  	{
	  ?>
	  <div align="right"><a href="http://www.lfb.com/cart/affiliate.php?code=10522&stocknumber=<?=$entry[asin]?>" target="_blank" id="nolink"><img src="http://www.liberty.li/Img/lfb.jpg" alt="" border="0"></a></div>
	  <?
	  }
  elseif ($entry[asin]&&ereg("spreadshirt",$entry[shop]))
  	{
    $number=explode("-",$entry[asin]);
    ?>
    <div align="center"><a class="boxl" href="#" onClick="window.open('http://libertyshop.spreadshirt.net/shop.php?article_id=<?=$number[1]?>','shopfenster','scrollbars=yes,width=650,height=450')" id="nolink"><img src="http://spreadshirt.net/image.php?type=image&amp;partner_id=507567&amp;product_id=<?=$number[0]?>&amp;img_id=1&amp;size=big&amp;bgcolor_images=white" border="0"><br><?=Phrase('quote_shirt')?></a></div>
    <?
    }
  elseif (ereg("liberty",$entry[shop]))
  	{
	  ?>
	  <div align="center"><a href="http://<?=$language?>.liberty.li/order.php?id=<?=$entry[asin]?>" id="nolink"><b>&rarr;<?=Phrase('buy')?></b></a></div>
	  <?
	  }
  elseif ($entry[shop])
  	{
	  ?>
	  <div align="center"><a href="<?=$entry[shop]?>"><b>&rarr;<?=Phrase('buy')?></b></a></div>
	  <?
	  }
  echo "<br></div>";
    ?>

  <p><i><b>Copyright:</b> <a href="http://wertewirtschaft.org">Institut für Wertewirtschaft</a> und der Autor. Abdruck nur mit Genehmigung; Online-Veröffentlichung gestattet bei Anbringung eines deutlich sichtbaren, anklickbaren Links zur Quelle mit eindeutigem Hinweis.</i></p>
<?
}
?>
<br>
</div>
</div>
</body>
</html>
<script type="text/javascript" language="javascript">
window.print();
</script>
<?php $db_close = @MYSQL_CLOSE($con); ?>