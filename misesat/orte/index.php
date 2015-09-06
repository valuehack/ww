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
	
   $sql="SELECT * from orte order by id asc";
   $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
   
?>
<!--Ortsliste-->	
<div class="content">
  	
  	  <p class="index"><a class="index" href="../index.php">Wiener Schule</a> / <a class="index" href="">Orte</a></p>
      
      <h2>Orts&uuml;bersicht</h2>
      
<?php
	while($entry = mysql_fetch_array($result))
	{
		$id = $entry[id]; 
        $name = $entry[name];
  		$text = $entry[text];
  		$img = $entry[img];
  		$denker = $entry[denker];
  		
  		echo '<div>';
		echo '<h2><a href="index.php?q='.$id.'">'.$name.'</a></h2>';
		echo '<p>'.substr($text, 0, 200).'</p>';
		echo '</div>';
	}
?>
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
    <div class="autorenliste">
<?php 
  //while($entry = mysql_fetch_array($result))
  //{	
?>
      <section>
      <h2 id="a">A</h2>   
        <dl>
          <img src="<?=$img?>" alt="">
    	  <dt><a href="?q=<?=$id?>"><?=$name?></a></dt>
    	  <dd>
    		<p><?=$shortbio?></p>
    		<p>Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.</p>
    		<p>Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld.</p>
    		<p><a href="?q=<?=$id?>">zum Autor</a></p>
    	  </dd>
        </dl>
      </section>
      
      <section>
      <h2 id="b">B</h2>   
        <dl>
          <img src="../style/mises_scetch.jpg" alt="" />
    	  <dt><a href="#">Eugen B&ouml;hm Ritter von Bawerk</a></dt>
    	  <dd>
    		<p>Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.</p>
    		<p>Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.</p>
    		<p>Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld.</p>
    		<p><a href="#">zum Autor</a></p>
    	  </dd>
        </dl>
      </section>
      
      <section>
      <h2 id="f">F</h2>   
        <dl>
          <img src="../style/mises_scetch.jpg" alt="" />
    	  <dt><a href="#">Frank Fetter</a></dt>
    	  <dd>
    		<p>Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.</p>
    		<p>Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.</p>
    		<p>Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld.</p>
    		<p><a href="#">zum Autor</a></p>
    	  </dd>
        </dl>
      </section>
      
      <section>
      <h2 id="h">H</h2>   
        <dl>
          <img src="../style/mises_scetch.jpg" alt="" />
    	  <dt><a href="#">Gottfried von Harberler</a></dt>
    	  <dd>
    		<p>Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.</p>
    		<p>Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.</p>
    		<p>Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld.</p>
    		<p><a href="#">zum Autor</a></p>
    	  </dd>
        </dl>
        <dl>
          <img src="../style/mises_scetch.jpg" alt="" />
    	  <dt><a href="#">Friedrich August von Hayek</a></dt>
    	  <dd>
    	    <p>Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.</p>
    	    <p>Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.</p>
    	    <p>Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld.</p>
    	    <p><a href="#">zum Autor</a></p>
		  </dd>
      	</dl>      
      </section>
      
      <section>
      <h2 id="l">L</h2>   
        <dl>
          <img src="../style/mises_scetch.jpg" alt="" />
    	  <dt><a href="#">Ludwig Lachmann</a></dt>
    	  <dd>
    		<p>Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.</p>
    		<p>Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.</p>
    		<p>Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld.</p>
    		<p><a href="#">zum Autor</a></p>
    	  </dd>
        </dl>
      </section>
      
      <section>
      <h2 id="m">M</h2>   
        <dl>
          <img src="../style/mises_scetch.jpg" alt="" />
    	  <dt><a href="#">Fritz Machlup</a></dt>
    	  <dd>
    		<p>Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.</p>
    		<p>Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.</p>
    		<p>Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld.</p>
    		<p><a href="#">zum Autor</a></p>
    	  </dd>
        </dl>        
        <dl>
          <img src="../style/mises_scetch.jpg" alt="" />
    	  <dt><a href="#">Carl Menger</a></dt>
    	  <dd>
    		<p>Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.</p>
    		<p>Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.</p>
    		<p>Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld.</p>
    		<p><a href="#">zum Autor</a></p>
    	  </dd>
        </dl>             
        <dl>
          <img src="../style/mises_scetch.jpg" alt="" />
    	  <dt><a href="#">Ludwig von Mises</a></dt>
    	  <dd>
    		<p>Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.</p>
    		<p>Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.</p>
    		<p>Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld.</p>
    		<p><a href="#">zum Autor</a></p>
    	  </dd>
        </dl>
      </section>
      
      <section>
      <h2 id="r">R</h2>   
        <dl>
          <img src="../style/mises_scetch.jpg" alt="" />
    	  <dt><a href="#">Paul Narcyz Rosenstein-Rodan</a></dt>
    	  <dd>
    		<p>Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.</p>
    		<p>Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.</p>
    		<p>Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld.</p>
    		<p><a href="#">zum Autor</a></p>
    	  </dd>
        </dl>
      </section>
      
      <section>
      <h2 id="s">S</h2>   
        <dl>
          <img src="../style/mises_scetch.jpg" alt="" />
    	  <dt><a href="#">Emil Sax</a></dt>
    	  <dd>
    		<p>Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.</p>
    		<p>Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.</p>
    		<p>Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld.</p>
    		<p><a href="#">zum Autor</a></p>
    	  </dd>
        </dl>
        <dl>
          <img src="../style/mises_scetch.jpg" alt="" />
    	  <dt><a href="#">Hans Sennholz</a></dt>
    	  <dd>
    		<p>Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.</p>
    		<p>Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.</p>
    		<p>Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld.</p>
    		<p><a href="#">zum Autor</a></p>
    	  </dd>
        </dl>  
      </section>
      
      <section>
      <h2 id="w">W</h2>   
        <dl>
          <img src="../style/mises_scetch.jpg" alt="" />
    	  <dt><a href="#">Friedrich von Wieser</a></dt>
    	  <dd>
    		<p>Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.</p>
    		<p>Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.</p>
    		<p>Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld.</p>
    		<p><a href="#">zum Autor</a></p>
    	  </dd>
        </dl>
      </section>
  </div>
</div>
<?	
	//}
}
	include "../page/footer.inc.php";
?>