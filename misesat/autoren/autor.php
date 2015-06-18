<? 
	include "../config/header1.inc.php";

	$title="Denker";

	include "../page/header2.inc.php";
	
if(isset($_GET['q']))
{
  $id = $_GET['q'];

  //Autorendetails
  $sql="SELECT * from denker WHERE id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry = mysql_fetch_array($result);
  $name = $entry[name];
  $bio = $entry[bio];
  $img = $entry[img];
?>

<!--Content-->

    <div class="content">
      <article class="denker">
      	<div class="index"><p><a href="">Wiener Schule</a> / <a href="">Denker</a> / <a href=""><?=$name?></a></p></div>
      
      	<h1><?=$name?></h1>
      	     
      	<section>
      	<h2>Leben</h2>
      
      	<img src="<?=$img?>" class="denker" alt="Portr&auml;t von <?=$name?>">
      	
      	<p><?=$bio?></p>
      
      	<div class="booksource">
      		<p>
      			<img src="wienerschule_buch.jpg" title="Die Wiener Schule der National&oouml;konomie von Eugen-Maria Schulak und Hebert Unterk&ouml;fler" alt="">
      		Die hier vorgestellte Biografie enstammt dem Buch <i>&quot;Die Wiener Schule der National&ouml;konomie&quot;</i>, geschrieben von <a href="#">Eugen-Maria Schulak</a> und Hebert Unterk&ouml;fler. Das Werk erschien in der Reihe &quot;Wiener Wissen&quot; und ist die bislang am tiefsten gehende Darstellung der historischen Entwicklung der Wiener Schule der &Ouml;konomie. Umfassende Recherchen bef&ouml;rderten viel Unbekanntes und &Uuml;berraschendes zu Tage. Neben Biografien und der historischen Entwicklung werden auch die Ideen der Wiener Schule leicht verst&auml;ndlich dargestellt.<br><br>
      		
      		<b>&quot;Die Wiener Schule der National&ouml;konomie&quot;</b> beim <a href="#">Institut f&uuml;r Wertewirtschaft</a> und bei <a href="#">Amazon.de</a>.

      		</p>
      	</div>
      	</section>
     	<section class="works">
     	
     		<h1>Werke</h1>
     	
     		<span class="works_sub">
          		<h4>B&uuml;cher</h4>
            	<ul>
              		<li><a href="">Theorie des Geldes und der Umlaufsmittel</a></li>
              		<li><a href="">Die Gemeinwirtschaft</a></li>
              		<li><a href="">Human Action - A Treatise in Economics</a></li>
          		</ul>
       		</span>
        
        	<span class="works_sub_m">
          		<h4>Artikel</h4>
            	<ul>
              		<li><a href="">Soziologie und Geschichte</a></li>
              		<li><a href="">Begreifen und Verstehen</a></li>
            	</ul>
       		</span>
        
        	<span class="works_sub">
          		<h4>Biografien</h4>
     
           		<ul>
              		<li><a href="">The Last Knight of Liberalism</a></li>
              		<li><a href="">Ludwig von Mises: Der Mensch und sein Werk</a></li>
            	</ul>
        	</span>
        <div class="clear"></div>
       </div>
    </div>
<?php
}
else {
?>
	
<article class="content">
  	
  	  <p class="index"><a class="index" href="">Wiener Schule</a> / <a class="index" href="">Denker</a></p>
      
      <h2>Autoren&uuml;bersicht</h2>
      
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
    	
      <section>
      <h2 id="a">A</h2>   
        <dl>
          <img src="../style/mises_scetch.jpg" alt="" />
    	  <dt><a href="#">A.A.</a></dt>
    	  <dd>
    		<p>Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.Biografie Übersicht.</p>
    		<p>Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.Hauptwerke. Hauptwerke. Hauptwerke.</p>
    		<p>Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld. Hauptforschungsfeld.</p>
    		<p><a href="#">zum Autor</a></p>
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
  </article>

<?	
	}
	include "../page/footer.inc.php";
?>