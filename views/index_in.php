<?php
include ("_db.php");
$title="Willkommen!";
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
                <div class="startpage_info">
                    <p>Die Wertewirtschaft ist ein lernendes Unternehmen, in dem Wege werte- und sinnorientierten Unternehmertums praktisch erkundet und theoretisch reflektiert werden. Wir bieten eine Orientierungshilfe für kritische B&uuml;rger und eine Bildungsalternative für junge Menschen, die der heutigen Blasenwirtschaft, aber auch ideologischen Versprechen misstrauen.</p>
                </div>
                <div class="startpage_box black">
                    <h1>Neue Scholien</h1>
                </div>
            </div>
            
            <div class="startpage_section_b">
                <div class="startpage_box white">
                    <h1>Schriften</h1>
                </div>
                <div class="startpage_box white">
                    <h1>Medien</h1>
                </div>
                <div class="startpage_box white">
                    <h1>Projekte</h1>
                </div>
            </div>
            
            <div class="startpage_section_c">
                <div class="startpage_box black">
                    <h1>Salons</h1>
                </div>       
                <div class="startpage_box black">
                    <h1>Kurse</h1>
                </div>         
            </div>
            
        </div>
     
     <?php 
     #include ("views/sidebar.inc.php"); 
     include ("_side_in.php");       
     ?>
        	
	</div>
  
<?php include "_footer.php"; ?>