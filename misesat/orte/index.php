<? 
	require_once "../../config/config.php";
	include "../config/db.php";

	$title="Orte";

	include "../page/header2.inc.php";
	
if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Autorendetails
  $sql = $pdocon->db_connection->prepare("SELECT * from orte WHERE id='$id'");
  $sql->execute();
  $result = $sql->fetchAll();

  $name = $result[0]['name'];
  $text = $result[0]['text'];
  $img = $result[0]['img'];
  $denker = $result[0]['denker'];
      
?>
<!--Orte-->
<!--Content-->

    <div id="content">
      <article>
      	<div class="index"><p><a class="index-link" href="../index.php">Wiener Schule</a> / <a class="index-link" href="index.php">Orte</a> / <a class="index-link" href=""><?=$name?></a></p></div>
      
      	<h1><?=$name?></h1>
      	     
      	<section class="text">
      	<h2>Beschreibung</h2>
      
      <?php
      	if ($img !== "" OR $img !== 0) { 
      	echo '<img src="'.$img.'" class="denker" alt="Portr&auml;t von '.$name.'">&nbsp;';
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
			
    $sql = $pdocon->db_connection->prepare("SELECT * from orte order by id asc");
	$sql->execute();
    $result = $sql->fetchAll();
   
?>
<!--Ortsliste-->	
<div id="content">
  	
		<div class="index"><a class="index-link" href="../index.php">Wiener Schule</a> / <a class="index-link" href="">Orte</a></div>
      
      	<h1>Orts&uuml;bersicht</h2>
      
    	<noscript><b>Um unsere Kartenanwendung zu nutzen ben&ouml;tigen Sie JavaScript.</b> 
     	 JavaScript scheint in Ihrem Browser deaktiviert zu sein oder wird von diesem nicht unterst&uuml;tzt. 
     	 Um unsere Kartenansischt sehen k&oouml;nnen, aktivieren Sie bitte JavaScript.
    	</noscript>
    
    	<div class="map">
			<div id="map" class="map__map"></div>
		</div>
	<script type="text/javascript">

    function initMap() {

	var MisesAustriaMapStyle = new google.maps.StyledMapType([
      {
      	      }
    ], {name: 'Wohnorte und Wirkstaetten Wiener Oekonomen'});
    
     var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 48.0596696, lng: 14.4656239},
            zoom: 5,
            mapTypeControlOptions: {
                mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'misesat_map']
            }
        });
        
        map.mapTypes.set('misesat_map', MisesAustriaMapStyle);
        map.setMapTypeId('misesat_map');

<?php
	for ($i = 0; $i < count($result); $i++)
	{
		$id = $result[$i]['id']; 
		$n = $result[$i]['n'];
        $name = $result[$i]['name'];
  		$text = $result[$i]['text'];
  		$img = $result[$i]['img'];
  		$denker = $result[$i]['denker'];
		$lat = $result[$i]['lat'];
		$lng = $result[$i]['lng'];
     ?> 
        		 			
		var info = '<div class="map-info"><a href="index.php?q=<?=$id?>"><h1><?=$name?></h1></a><img src="<?=$img?>" alt=""><p><?=substr($text, 0, 180)?> ... <a href="index.php?q=<?=$id?>">Mehr</a></p><h2>Denker die hier gelebt und gewirkt haben</h2><p><?=$denker?></p></div>';
			
        var marker = new google.maps.Marker({
         	position: {lat: <?=$lat?>, lng: <?=$lng?>},
         	map: map,
         	title: '<?=$name?>'
        });
        attachInfoWindow(marker, info);
<?php       
	}
?>
    	function attachInfoWindow(marker, info) {
        	var infowindow = new google.maps.InfoWindow({
        	content: info
       		 });
        
       		marker.addListener('click', function() {
        	infowindow.open(map, marker);
        	});
        
    	}
	}
	</script>

		<!--echo"var info = '<div><h1>".$name."</h1><p>".substr($text, 0, 200)."</p></div>';";-->

</div>

    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChP6VPcxuqcO5r8q7733mF7hzjNg4r9EY&callback=initMap">
    </script>

<?	
	//}
}
	include "../page/footer.inc.php";
?>