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
                <div class="startpage_box_events">
                    <h1>Aktuelle Veranstaltungen</h1>
                    <h2>Salons</h2>
                        <?php
$sql = "SELECT * from produkte WHERE (type LIKE 'salon') AND status > 0 order by id asc, n asc LIMIT 0, 3";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id]; 
				echo "<a href='/salon/index.php?q=$id'>";
				echo date("d.m.Y",strtotime($entry[start]));
              	if (strtotime($entry[end])>(strtotime($entry[start])+86400)) echo "-".date("d.m.Y",strtotime($entry[end]));
              	echo ": $entry[title]</a><br>";                  
}
                    ?>
                    <h2>Kurse</h2>
                        <?php
$sql = "SELECT * from produkte WHERE (type LIKE 'kurs') AND status > 0 order by id asc, n asc LIMIT 0, 3";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id];
				echo "<a href='/kurse/index.php?q=$id'>";
				echo date("d.m.Y",strtotime($entry[start]));
              	if (strtotime($entry[end])>(strtotime($entry[start])+86400)) echo "-".date("d.m.Y",strtotime($entry[end]));
              	echo ": $entry[title]</a><br>";                  
}
                    ?>
                </div>  
                
                <div class="startpage_box_scholien black">
                    <h1>Neue Scholien</h1>
                    <?php
$sql = "SELECT * from blog WHERE publ_date<=CURDATE() order by publ_date desc, id asc LIMIT 0, 2";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id]; 
                echo "<a href='/scholien/index.php?q=$id'><i>".date('d.m.Y', strtotime($publ_date))."</i> ".$entry[title]."</a><br>";                  
}
                    ?>
                </div>
            </div>
            
            <div class="startpage_section_b">
                <h1>Neue Inhalte</h1>
                <div class="startpage_box_contents white">
                    <h1>Schriften</h1>
                     <?php
$sql = "SELECT * from produkte WHERE (type LIKE 'buch' OR type LIKE 'scholie' OR type LIKE 'analyse') AND status > 0 order by id asc, n asc LIMIT 0, 3";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id]; 
                echo "<a href='/schriften/index.php?q=$id'>".$entry[title]." <i>(".ucfirst($entry[type]).")</i></a><br>";                  
}
                    ?>
                </div>
                <div class="startpage_box_contents white startpage_box_contents_middle">
                    <h1>Medien</h1>
                    <?php
$sql = "SELECT * from produkte WHERE (type LIKE 'media' OR type LIKE 'audio' OR type LIKE 'video') AND status > 0 order by id asc, n asc LIMIT 0, 3";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id]; 
                echo "<a href='/medien/index.php?q=$id'>".$entry[title]." <i>(".ucfirst($entry[type]).")</i></a><br>";                  
}
                    ?>
                </div>
                <div class="startpage_box_contents white">
                    <h1>Letzte Spende</h1>
                    <?php
$sql = "SELECT * from produkte WHERE (type LIKE 'projekt') AND status > 0 order by id asc, n asc LIMIT 0, 3";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
                $id = $entry[id]; 
                echo "<a href='/projekte/index.php?q=$id'>".$entry[title]."</a><br>";                  
}
                    ?>
                </div>
                <div class="startpage_info">
                    <p>Die Wertewirtschaft ist ein lernendes Unternehmen, in dem Wege werte- und sinnorientierten Unternehmertums praktisch erkundet und theoretisch reflektiert werden. Wir bieten eine Orientierungshilfe f&uuml;r kritische B&uuml;rger und eine Bildungsalternative f&uuml;r junge Menschen, die der heutigen Blasenwirtschaft, aber auch ideologischen Versprechen misstrauen.</p>
                </div>
            </div>                     
     
     <?php 
     #include ("views/sidebar.inc.php"); 
     include ("_side_in.php");       
     ?>
        	
	</div>
  
<?php include "_footer.php"; ?>