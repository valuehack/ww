<?php
header('Content-type: application/xml');
@$con=mysql_connect("mysql.liberty.li","li000089","vr2u39") or die ("cannot connect to MySQL");
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>
<rdf:RDF xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\" xmlns=\"http://purl.org/rss/1.0/\" xmlns:slash=\"http://purl.org/rss/1.0/modules/slash/\" xmlns:taxo=\"http://purl.org/rss/1.0/modules/taxonomy/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:syn=\"http://purl.org/rss/1.0/modules/syndication/\" xmlns:admin=\"http://webns.net/mvcb/\" xmlns:feedburner=\"http://rssnamespace.org/feedburner/ext/1.0\">
<channel rdf:about=\"http://rahim.cc/\">
<title>http://rahim.cc</title>
<link>http://rahim.cc</link>
<description>Persönliche Seite von Rahim Taghizadegan</description>
    <dc:language>de</dc:language>
    <dc:rights>Copyright: Rahim Taghizadegan</dc:rights>
     <dc:date>".strftime("%Y-%m-%dT%H:%M:%SZ", strtotime(date("Y-m-d H:j:s")))."</dc:date>
    <dc:publisher>Rahim Taghizadegan</dc:publisher>
    <dc:creator>rt@wertewirtschaft.org</dc:creator>
    <dc:subject>Wertewirtschaft</dc:subject>
    <syn:updatePeriod>daily</syn:updatePeriod>
    <syn:updateFrequency>1</syn:updateFrequency>

    <syn:updateBase>1970-01-01T00:00+00:00</syn:updateBase>
    <items>
      <rdf:Seq>";
  $sql="SELECT * from li000089_rahim.blog order by datum desc, id desc limit 10";
	$result = mysql_query($sql);
	while($entry = mysql_fetch_array($result))
	  {
    echo "<rdf:li rdf:resource=\"http://rahim.cc/?id=$entry[id]\" />";
    }
echo "</rdf:Seq>
    </items>
    <textinput rdf:resource=\"http://rahim.cc/\" />

  </channel>";
  $sql="SELECT * from li000089_rahim.blog order by datum desc, id desc limit 10";
	$result = mysql_query($sql);
	while($entry = mysql_fetch_array($result))
	  {
		echo "<item rdf:about=\"http://rahim.cc/?id=$entry[id]\">

   <title>".htmlspecialchars($entry[titel])."</title>
    <link>http://rahim.cc/?id=$entry[id]</link>
    <description>".ereg_replace("\x93","",ereg_replace("\x84","",htmlspecialchars(strip_tags(substr($entry[text],0,1000)))))."</description>
    <dc:creator>Rahim Taghizadegan</dc:creator>

    <dc:date>".strftime("%Y-%m-%dT%H:%M:%SZ", strtotime($entry[datum]))."</dc:date>

    <feedburner:origLink>http://rahim.cc/?id=$entry[id]</feedburner:origLink>
  </item>";
		}
echo "</rdf:RDF>";
$db_close = @MYSQL_CLOSE($con)
?>