<?
require_once('../classes/Login.php');
$title="Veranstaltungen";
include "_header_not_in.php"; 
?>
	<div class="content">
		<div class="salon_info">
			<h1>Veranstaltungen</h1>
		
		<?php
			$sql = "SELECT * from static_content WHERE (page LIKE 'veranstaltungen')";
			$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
			$entry4 = mysql_fetch_array($result);
	
				echo $entry4[info];	
		?>

    </div>
    <div class="salon_seperator">
    	<h1>Termine</h1>
    </div>
    <div class="salon_types">
    	<span><a href="">Alle</a></span>
    	<span><a href="../seminare/">Seminare</a></span>
    	<span><a href="../salon/">Salons</a></span>
    </div>
    <div class="salon_content">
  <?php
  $sql = "SELECT * from produkte WHERE (type='salon' or type='lehrgang' or type='seminar' or type='kurs') AND start > NOW() AND spots > spots_sold AND status = 1 order by start asc, n asc";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
	
  while($entry = mysql_fetch_array($result))
  {
    $id = $entry[id];
      ?>
      
<?php echo "<h1><a href='../".$entry[type]."/index.php?q=$id'>".$entry[title]; ?></a></h1>
		<div class="salon_type"><?echo ucfirst($entry[type]);?></div>
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
          echo " Uhr &ndash; ";
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
	</div>
	
<? include "_footer.php"; ?>