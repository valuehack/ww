<? 
	include "../config/header1.inc.php";

	$title="Orte";

	include "../page/header2.inc.php";
	
if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Autorendetails
  $sql="SELECT * from orte WHERE id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry = mysql_fetch_array($result);
  $name = $entry[name];
  $text = $entry[text];
  $img = $entry[img];
  $denker = $entry[denker];
    
?>
<!--Orte-->
<!--Content-->

    <div class="content">
      <article class="denker">
      	<div class="index"><p><a href="../index.php">Wiener Schule</a> / <a href="index.php">Orte</a> / <a href=""><?=$name?></a></p></div>
      
      	<h1><?=$name?></h1>
      	     
      	<section>
      	<h2>Beschreibung</h2>
      
      <?php
      	if ($img !== "" OR $img !== 0) { 
      	echo '<img src="'.$img.'" class="denker" alt="Portr&auml;t von '.$name.'">';
		}
      ?>
      	<p><?=$text?></p>
      	
      	<p><?=$denker?></p>
      	</section>
      	
       </article>
    </div>
<?php
}
else {
	
   $sql="SELECT * from orte where n=3 and n=7 und n=2 order by id asc";
   $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
   
?>
<!--Ortsliste-->	
<div class="content">
  	
  	  <p class="index"><a class="index" href="../index.php">Wiener Schule</a> / <a class="index" href="">Orte</a></p>
      
      <h2>Orts&uuml;bersicht</h2>
      
      <div id="map" style="width:100%; height:500px;"></div>
      
    <noscript><b>Um unsere Kartenanwendung zu nutzen ben&ouml;tigen Sie JavaScript.</b> 
      JavaScript scheint in Ihrem Browser deaktiviert zu sein oder wird von diesem nicht unterst&uuml;tzt. 
      Um unsere Kartenansischt sehen k&oouml;nnen, aktivieren Sie bitte JavaScript.
    </noscript>
    
    <script type="text/javascript">
      
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 50.0596696, lng: 14.4656239},
            zoom: 5
        });
<?php
	while($entry = mysql_fetch_array($result))
	{
		$id = $entry[id]; 
        $name = $entry[name];
  		$text = $entry[text];
  		$img = $entry[img];
  		$denker = $entry[denker];
		$coord = $entry[geo];
 		
		echo"var info = '<div><h1>".$name."</h1><p>".substr($text, 0, 200)."</p></div>';";
		
        echo"var marker = new google.maps.Marker({";
         echo"position: {lat: ".substr($coord,0, 9).", lng: ".substr($coord,11, 21)."},";
         echo"map: map,";
         echo"title: '".$name."'";
        echo"});";
       echo"attachInfoWindow(marker, info);";
	
	}
?>
	}
</script>
    <nav>
    	<ol class="nav_autoren">
    		<li><a href="#a">A</a></li>
    		<li><a href="#b">B</a></li>
    		<li>C</li>
    		<li>D</li>
    		<li>E</li>
    		
    		<li><a href="#f">F</a></li>
    		<li>G</li>
    		<li><a href="#h">H</a></li>
    		<li>I</li>
    		<li>J</li>
    		
    		<li>K</li>
    		<li><a href="#l">A</a></li>
    		<li><a href="#m">M</a></li>
    		<li>N</li>
    		<li>O</li>
    		
    		<li>P</li>
    		<li>Q</li>
    		<li><a href="#r">R</a></li>
    		<li><a href="#s">S</a></li>
    		<li>T</li>
    		
    		<li>U</li>
    		<li>V</li>
    		<li><a href="#w">W</a></li>
    		<li>X</li>
    		<li>Y</li>
    		
    		<li>Z</li>
    	</ol>
    </nav>

</div>
	<script type="text/javascript">
    function attachInfoWindow(marker, info) {
        var infowindow = new google.maps.InfoWindow({
        content: info
        });
        
        marker.addListener('mouseover', function() {
        infowindow.open(map, marker);
        });
        
        marker.addListener('mouseout', function() {
        infowindow.close(map, marker);
        });
    }
    </script>
    
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChP6VPcxuqcO5r8q7733mF7hzjNg4r9EY&callback=initMap">
    </script>

<?	
	//}
}
	include "../page/footer.inc.php";
?>