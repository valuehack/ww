<?
require_once('../classes/Login.php');
$title="Veranstaltungen";
include "_header_in.php"; 
?>
	<div class="content">
  <?php
  $sql = "SELECT * from produkte WHERE (type='salon' or type='lehrgang' or type='seminar' or type='kurs') and (start > NOW()) and (status = 1) order by start asc, n asc";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
	
//für Interessenten (Mitgliedschaft 1) Erklärungstext oben
  if ($_SESSION['Mitgliedschaft'] == 1) {
  	echo "<div class='salon_info'>";
			$sql = "SELECT * from static_content WHERE (page LIKE 'salon')";
			$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
			$entry4 = mysql_fetch_array($result);
			
		    $sql = "SELECT * from static_content WHERE (page LIKE 'seminare')";
			$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
			$entry5 = mysql_fetch_array($result);
	
				echo $entry4[info];	
				echo $entry5[info];
	?>
			<div class="centered">
				<a class="blog_linkbutton" href="../spende/">Unterst&uuml;tzen & Zugang erhalten</a>
			</div>		
   </div>
	<?
  }
  else {
  	echo '<div class="salon_content">';
	  
  while($entry = mysql_fetch_array($result))
  {
    $id = $entry[id];
	$type = $entry[type];
  	if ($type == 'seminar') {
  		$type = 'seminare';
  	} 
      ?>
      
        <div class="salon_type"><?echo ucfirst($entry[type]);?></div>        
		<h1><a href='../<?=$type?>/index.php?q=<?=$id?>'><?=$entry[title]; ?></a></h1>		
		<div class="salon_dates">
			
      <?php 
      if ($entry[start] != NULL && $entry[end] != NULL)
        {
        $tag=date("w",strtotime($entry[start]));
        $tage = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
        echo $tage[$tag]." ";
        echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry[start]));
        if (strftime("%d.%m.%Y", strtotime($entry[start]))!=strftime("%d.%m.%Y", strtotime($entry[end])))
          {
          echo " &ndash; ";
          $tag=date("w",strtotime($entry[end]));
          echo $tage[$tag];
          echo strftime(" %d.%m.%Y %H:%M Uhr", strtotime($entry[end]));
          }
        else echo strftime(" &ndash; %H:%M Uhr", strtotime($entry[end]));
      }
      elseif ($entry[start]!= NULL)
        {
        $tag=date("w",strtotime($entry[start]));
        echo $tage[$tag]." ";
        echo strftime("%d.%m.%Y %H:%M", strtotime($entry[start]));
      }
      else echo "Der Termin wird in K&uuml;rze bekannt gegeben."; ?>
		</div>
		<?php echo $entry[text]; ?> 
			<div class="centered"><p class='linie'><img src='../style/gfx/linie.png' alt=''></p></div>	
  <?php
  }
  ?>
			</div>
	<?
	}
	?>
	</div>
	
<? include "_footer.php"; ?>