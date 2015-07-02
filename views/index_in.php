<?php
include ("_db.php");
$title="Willkommen";
include ("_header_in.php"); 
?>

<!-- show registration form, but only if we didn't submit already -->
<!--
-->
<!--
<!-- show subscription form -->

<!-- <input type="checkbox" id="user_rememberme" name="user_rememberme" value="1" />
    <label for="user_rememberme"><?php #echo WORDING_REMEMBER_ME; ?></label> -->

<!-- END Subscription -->

        <div class="content">
            
            <div class="startpage_section_a">
            	
            		<?php
$sql = "SELECT * from blog WHERE publ_date<=CURDATE() order by publ_date desc, id asc LIMIT 0, 1";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

	//check, if there is a image in the scholien folder
	$img = 'http://scholarium.at/scholien/'.$id.'.jpg';

	if (@getimagesize($img)) {
	    $img_url = $img;
	} else {
	    $img_url = "http://scholarium.at/scholien/default.jpg";
	}

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id]; 
				
				echo "<div class='startpage_last_scholie'>";
				echo "<div class='startpage_last_scholie_img' style='background:url(".$img_url.") no-repeat cover;'></div>";
				echo "<div class='startpage_last_scholie_ms'>";
                echo "<a class='startpage_last_scholie_title' href='/scholien/index.php?q=$id'>".$entry[title]."</a><br>"; 
				echo "<span>Scholie</span>";
				echo "<i>".date('d.m.Y', strtotime($entry[publ_date]))."</i><br>";  
				if (strlen($entry[public_text]) > 300) {
					echo substr ($entry[public_text], 0, 300);
					echo " ... <a href='?q=$id'>Weiterlesen</a>";
					}
				else {
					echo $entry[public_text];
					echo "... <a href='?q=$id'>Weiterlesen</a>";
		}              
}
                    ?>
                   </div>
            	</div>
            	
                <div class="startpage_box_outer  left">
                    <h1>Veranstaltungen</h1>
                    <div class="startpage_box_inner">
                        <?php
$sql = "SELECT * from produkte WHERE (type LIKE 'salon' OR 'kurs' OR 'seminar') AND status > 0 order by id asc, n asc LIMIT 0, 3";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id]; 
				echo "<a href='/salon/index.php?q=$id'>";
              	echo ": $entry[title]</a><br>";
				echo date("d.m.Y",strtotime($entry[start]));
              	if (strtotime($entry[end])>(strtotime($entry[start])+86400)) echo "-".date("d.m.Y",strtotime($entry[end])); 
				echo ucfirst($entry[type]);                 
				}
                    ?>
                	</div> 
                <p><a href="/salon/">Mehr Salons</a></p> 
                </div>
                
                <div class="startpage_box_outer right">
                    <h1>Scholien</h1>
                    <div class="startpage_box_inner">
                    <?php
$sql = "SELECT * from blog WHERE publ_date<=CURDATE() order by publ_date desc, id asc LIMIT 0, 2";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id]; 
                echo "<a href='/scholien/index.php?q=$id'>".$entry[title]."</a><br>"; 
				echo "<i>".date('d.m.Y', strtotime($entry[publ_date]))."</i>";
				echo ucfirst($entry[type]);                  
}
                    ?>
                    </div>
                    <p><a href="/scholien/">Mehr Scholien</a></p>
                </div>
            </div>
            
            <div class="startpage_section_b">

                <div class="startpage_box_outer right">
                    <h1>Schriften</h1>
                    <div class="startpage_box_inner"></div>
                     <?php
$sql = "SELECT * from produkte WHERE (type LIKE 'buch' OR type LIKE 'scholie' OR type LIKE 'analyse') AND status > 0 order by id asc, n asc LIMIT 0, 3";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id]; 
                echo "<a href='/scholien/index.php?q=$id'>".$entry[title]."</a><br>"; 
				echo "<i>".date('d.m.Y', strtotime($entry[publ_date]))."</i>";
				echo ucfirst($entry[type]);                    
}
                    ?>
                    </div>
                    <p><a href="/schriften/">Mehr Schriften</a></p>
                </div>
                <div class="startpage_box_outer left">
                    <h1>Medien</h1>
                    <div class="startpage_box_inner right"> 
                    <?php
$sql = "SELECT * from produkte WHERE (type LIKE 'media' OR type LIKE 'audio' OR type LIKE 'video') AND status > 0 order by id asc, n asc LIMIT 0, 3";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id]; 
                echo "<a href='/scholien/index.php?q=$id'>".$entry[title]."</a><br>"; 
				echo "<i>".date('d.m.Y', strtotime($entry[publ_date]))."</i>";
				echo ucfirst($entry[type]);                   
}
                    ?>
                    </div>
                    <p><a href="/medien/">Mehr Medien</a></p>
                </div>

            </div>  
            <div class="startpage_section_c">                
                                
                <div class="startpage_box_outer left">
                    <h1>Letzte Spende</h1>
                    <div class="startpage_box_inner">
                    <?php
$sql = "SELECT * from produkte WHERE (type LIKE 'projekt') AND status > 0 order by id asc, n asc LIMIT 0, 3";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id]; 
                echo "<a href='/scholien/index.php?q=$id'>".$entry[title]."</a><br>"; 
				echo "<i>".date('d.m.Y', strtotime($entry[publ_date]))."</i>";
				echo ucfirst($entry[type]);                 
}
                    ?>
                    </div>
                    <p><a href="/projekte/">Weitere Projekte</a></p>
                </div>
               
            	 <div class="startpage_info">
                    <p>Die Wertewirtschaft ist ein lernendes Unternehmen, in dem Wege werte- und sinnorientierten Unternehmertums praktisch erkundet und theoretisch reflektiert werden. Wir bieten eine Orientierungshilfe f&uuml;r kritische B&uuml;rger und eine Bildungsalternative f&uuml;r junge Menschen, die der heutigen Blasenwirtschaft, aber auch ideologischen Versprechen misstrauen.</p>
                </div>
            </div>                   	
	</div>
  
<?php include "_footer.php"; ?>