<?php

// check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once('libraries/password_compatibility_library.php');
}
// include the config
require_once('config/config.php');

// include the to-be-used language, english by default. feel free to translate your project and include something else
require_once('translations/de.php');

// include the PHPMailer library
require_once('libraries/PHPMailer.php');

// load the login class
require_once('classes/Login.php');
require_once('classes/Registration.php');

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();
$registration = new Registration();
$title="Mitwirkende";

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    include("views/_header_in.php");

} else {
    // the user is not logged in. you can do whatever you want here.
    include("views/_header_not_in.php");
    
}

?>

<div class="content">
	<div class="blog">
		<header>
			<h1>Mitwirkende</h1>
		</header>
		<p class='linie'><img src='../style/gfx/linie.png' alt=''></p>
		<div class="blog_text">
			
			  
            
            
                
               
                
                    <p class="crew_levels">Rektor</p>
                
            	<?php               

				$sql = "SELECT * from crew WHERE level='1'";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				
				
				while ($entry= mysql_fetch_array($result)) {


				echo "<table>";
				echo "<tr>";
				echo "<td>";
				echo "<div class='crew_image'>";
				echo "<img src='http://craftprobe.com/img/".$entry[id].".jpg'>";
				echo "</div>";
				echo "<div class='crew_link'>";
				echo "<br><a href='http://$entry[link]'>$entry[link]</a></td>";
				echo "</div>";
				echo "<td>";
				echo "<div class='crew_name'>";
				echo "$entry[name]<br>";
				echo "</div>";
				echo "<div class='crew_text'>";
				echo "$entry[text_de]</td>";
				echo "</div>";
				echo "</tr>";			
            
		
				echo "</table>";
				
	}		
				
			?>
                      
        
                
                <p class="crew_levels">Gr&uuml;nder</p>
                
                                
                <?php
                
                $sql = "SELECT * from crew WHERE level='2' order by id asc";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

				while ($entry= mysql_fetch_array($result)) {

				echo "<table>";
				echo "<tr>";
				echo "<td>";
				echo "<div class='crew_image'>";
				echo "<img src='http://craftprobe.com/img/".$entry[id].".jpg'>";
				echo "</div>";
				echo "<div class='crew_link'>";
				echo "<br><a href='http://$entry[link]'>$entry[link]</a></td>";
				echo "</div>";
				echo "<td>";
				echo "<div class='crew_name'>";
				echo "$entry[name]<br>";
				echo "</div>";
				echo "<div class='crew_text'>";
				echo "$entry[text_de]</td>";
				echo "</div>";
				echo "</tr>";						
				echo "</table>";				
    }                          		
			?>
                
               <p class="crew_levels">Mitarbeiter</p>
                                        
            	<?php
                        
				$sql = "SELECT * from crew WHERE level='3' order by id asc";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
								
				while ($entry= mysql_fetch_array($result)) {
				
 				echo "<table>";
				echo "<tr>";
				echo "<td>";
				echo "<div class='crew_image'>";
				echo "<img src='http://craftprobe.com/img/".$entry[id].".jpg'>";		
				echo "</div>";
				echo "<div class='crew_link'>";
				echo "<br><a href='http://$entry[link]'>$entry[link]</a></td>";
				echo "</div>";
				echo "<td>";
				echo "<div class='crew_name'>";
				echo "$entry[name]<br>";
				echo "</div>";
				echo "<div class='crew_text'>";
				echo "$entry[text_de]</td>";
				echo "</div>";
				echo "</tr>";			
				echo "</table>";				
      }              
               ?>
                              
               <p class="crew_levels">Mentoren</p>
                                      
            	<?php
              
				$sql = "SELECT * from crew WHERE level='4' order by id asc";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				
				while ($entry= mysql_fetch_array($result)) {

                echo "<table>";
				echo "<tr>";
				echo "<td>";
				echo "<div class='crew_image'>";
				echo "<img src='http://craftprobe.com/img/".$entry[id].".jpg'>";
				echo "</div>";
				echo "<div class='crew_link'>";
				echo "<br><a href='http://$entry[link]'>$entry[link]</a></td>";
				echo "</div>";
				echo "<td>";
				echo "<div class='crew_name'>";
				echo "$entry[name]<br>";
				echo "</div>";
				echo "<div class='crew_text'>";
				echo "$entry[text_de]</td>";
				echo "</div>";
				echo "</tr>";			
				echo "</table>";	
	}			
				?>
				
				
                                      
            	<?php
              
				$sql = "SELECT * from crew WHERE level='5' order by id asc";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				
				while ($entry= mysql_fetch_array($result)) 
					{ 
					$counter= $counter+1;
					IF ($counter==1) 
				    	{ ?>
				    	<p class="crew_levels">Ehrenpr&auml;sidenten</p>
				    	<? 
				    	}	
                	echo "<table>";
					echo "<tr>";
					echo "<td>";
					echo "<div class='crew_image'>";
					echo "<img src='http://craftprobe.com/img/".$entry[id].".jpg'>";
					echo "</div>";
					echo "<div class='crew_link'>";
					echo "<br><a href='http://$entry[link]'>$entry[link]</a></td>";
					echo "</div>";
					echo "<td>";
					echo "<div class='crew_name'>";
					echo "$entry[name]<br>";
					echo "</div>";
					echo "<div class='crew_text'>";
					echo "$entry[text_de]</td>";
					echo "</div>";
					echo "</tr>";			
					echo "</table>";	
					}			
				?>
								
              
				<p class="crew_levels">Beir&auml;te</p>
                                      
            	<?php
              
				$sql = "SELECT * from crew WHERE level='6' order by id asc";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				
				while ($entry= mysql_fetch_array($result)) {

                echo "<table>";
				echo "<tr>";
				echo "<td>";
				echo "<div class='crew_image'>";
				echo "<img src='http://craftprobe.com/img/".$entry[id].".jpg'>";
				echo "</div>";
				echo "<div class='crew_link'>";
				echo "<br><a href='http://$entry[link]'>$entry[link]</a></td>";
				echo "</div>";
				echo "<td>";
				echo "<div class='crew_name'>";
				echo "$entry[name]<br>";
				echo "</div>";
				echo "<div class='crew_text'>";
				echo "$entry[text_de]</td>";
				echo "</div>";
				echo "</tr>";			
				echo "</table>";	
	}			
				?><p class="crew_levels">Partner</p>
                                      
            	<?php
              
				$sql = "SELECT * from crew WHERE level='7' order by id asc";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				
				while ($entry= mysql_fetch_array($result)) {

                echo "<table>";
				echo "<tr>";
				echo "<td>";
				echo "<div class='crew_image'>";
				echo "<img src='img/".$entry[id].".jpg'>";
				echo "</div>";
				echo "<div class='crew_link'>";
				echo "<br><a href='http://$entry[link]'>$entry[link]</a></td>";
				echo "</div>";
				echo "<td>";
				echo "<div class='crew_name'>";
				echo "$entry[name]<br>";
				echo "</div>";
				echo "<div class='crew_text'>";
				echo "$entry[text_de]</td>";
				echo "</div>";
				echo "</tr>";			
				echo "</table>";	
	}			
				?><p class="crew_levels">Studenten</p>
                                      
            	<?php
              
				$sql = "SELECT * from crew WHERE level='8' order by id asc limit 12";
				$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
				
				while ($entry= mysql_fetch_array($result)) {

                echo "<table>";
				echo "<tr>";
				echo "<td>";
				echo "<div class='crew_image'>";
				echo "<img src='http://craftprobe.com/img/".$entry[id].".jpg'>";
				echo "</div>";
				echo "<div class='crew_link'>";
				echo "<br><a href='http://$entry[link]'>$entry[link]</a></td>";
				echo "</div>";
				echo "<td>";
				echo "<div class='crew_name'>";
				echo "$entry[name]<br>";
				echo "</div>";
				echo "<div class='crew_text'>";
				echo "$entry[text_de]</td>";
				echo "</div>";
				echo "</tr>";			
				echo "</table>";	
	}			
				?>
				            
                   
            
		
			<div class="centered">
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform">
  					<input class="inputfield" id="user_email" type="email" placeholder=" E-Mail Adresse" name="user_email" required>
  					<input type=hidden name="first_reg" value="faq">
  					<input class="inputbutton" type="submit" name="eintragen_submit" value="Eintragen">
				</form>
			</div> 
		</div>		
	</div>
</div>

<?php include('views/_footer.php'); ?>