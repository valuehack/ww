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
            
            <div class="startpage_section_last_scholie">
			            	
            		<?php
$sql = "SELECT * from blog WHERE publ_date<=CURDATE() order by publ_date desc, id asc LIMIT 0, 1";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());



while($entry = mysql_fetch_array($result))
{
                $id = $entry[id]; 
				
				echo "<div class='startpage_last_scholie'>";
				echo "<div class='startpage_last_scholie_ms'>";
                echo "<h1><a href='/scholien/index.php?q=$id'>".$entry[title]."</a></h1><br>"; 
				echo "<span>Scholie</span>";
				echo "<span>".date('d.m.Y', strtotime($entry[publ_date]))."</span><br>";  
				
					$text1 = wordwrap($entry[public_text], 300, "\0");
					$short_text = preg_replace('/^(.*?)\0(.*)$/is', '$1', $text1);
				if (strlen($entry[public_text]) > 300) {
					echo $short_text;
					echo " ... <a href='scholien/index.php?q=$id'>Weiterlesen</a>";
					}
				else {
					echo $entry[public_text];
					echo "... <a href='/index.php?q=$id'>Weiterlesen</a>";
		}              
}
                    ?>
                   </div>
            	</div>
            </div>
			            	
            <div class="startpage_section">
                <div class="startpage_box_outer  left">
                    <h1>Veranstaltungen</h1>
                    <div class="startpage_box_inner">
                        <?php
$sql = "SELECT * from produkte WHERE (type='salon' or type='lehrgang' or type='seminar' or type='kurs') and (start > NOW()) and (status = 1) and (spots > spots_sold) order by start asc, n asc LIMIT 0, 3";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id];
                echo "<p>"; 
				echo "<a href='/salon/index.php?q=$id'>";
              	echo "$entry[title]</a><br>";
				echo date("d.m.Y",strtotime($entry[start]));
              	if (strtotime($entry[end])>(strtotime($entry[start])+86400)) echo "-".date("d.m.Y",strtotime($entry[end])); 
				echo "<span>".ucfirst($entry[type])."</span>";
				echo "</p>";                 
				}
                    ?>
                	</div> 
                <p class="startpage_more"><a href="/veranstaltungen/">Mehr Veranstaltungen</a></p> 
                </div>
			                
                <div class="startpage_box_outer right">
                    <h1>Scholien</h1>
                    <div class="startpage_box_inner">
                    <?php
$sql = "SELECT * from blog WHERE publ_date<=CURDATE() AND publ_date > '2000-01-01' order by publ_date desc, id asc LIMIT 1, 3";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id];
				echo "<p>";  
                echo "<a href='/scholien/index.php?q=$id'>".$entry[title]."</a><br>"; 
				echo "<i>".date('d.m.Y', strtotime($entry[publ_date]))."</i>";
				echo ucfirst($entry[type]);
				echo "</p>";                  
}
                    ?>
                    </div>
                    <p class="startpage_more"><a href="/scholien/">Mehr Scholien</a></p>
                </div>     
			</div>        
			         
			<div class="startpage_section">
                <div class="startpage_box_outer right">
                    <h1>Schriften</h1>
                    <div class="startpage_box_inner">
                     <?php
$sql = "SELECT * from produkte WHERE (type LIKE 'buch' OR type LIKE 'scholie' OR type LIKE 'analyse') AND status > 0 order by id asc, n asc LIMIT 0, 3";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id];
				echo "<p>";  
                echo "<a href='/schriften/index.php?q=$id'>".$entry[title]."</a><br>"; 
				echo ucfirst($entry[type]);
				echo "</p>";                    
}
                    ?>
                    </div>
                    <p class="startpage_more"><a href="/schriften/">Mehr Schriften</a></p>
                </div>
                <div class="startpage_box_outer left">
                    <h1>Medien</h1>
                    <div class="startpage_box_inner"> 
                    <?php
$sql = "SELECT * from produkte WHERE (type LIKE 'media%') AND status > 0 order by id asc, n asc LIMIT 0, 3";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id];
                echo "<p>"; 
                echo "<a href='/medien/index.php?q=$id'>".$entry[title]."</a><br>"; 
				echo ucfirst(substr($entry[type],6));
				echo "</p>";                   
}
                    ?>
                    </div>
                    <p class="startpage_more"><a href="/medien/">Mehr Medien</a></p>
                </div>
			</div>
			
			<!--<div class="startpage_section">                                                                
                <div class="startpage_box_outer left">
                    <h1>Letzte Projektbeitr&auml;ge</h1>
                    <!--<img src="../style/gfx/sp_projekte.jpg" alt="">
                    <div class="startpage_box_inner">
                    <?php
$sql = "SELECT * from produkte WHERE (type LIKE 'projekt') AND status > 0 order by last_donation desc LIMIT 0, 3";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id];
                echo "<p>"; 
                echo "<a href='/projekte/index.php?q=$id'>".$entry[title]."</a><br>"; 
				echo ucfirst($entry[type]); 
				echo "</p>";                
}
                    ?>
                    </div>
                    <p class="startpage_more"><a href="/projekte/">Weitere Projekte</a></p>
                </div>
			</div>-->          	
	</div>
  
<?php include "_footer.php"; ?>