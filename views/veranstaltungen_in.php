<?
require_once('../classes/Login.php');
$title="Veranstaltungen";
include "_header_in.php";

  $sql = "SELECT * from produkte WHERE (type='salon' or type='lehrgang' or type='seminar' or type='kurs') and (end > NOW()) and (status = 1) order by start asc, n asc";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

//für Interessenten (Mitgliedschaft 1) Erklärungstext oben
  if ($_SESSION['Mitgliedschaft'] == 1) {
?>  		
  	<div class="salon_info">
		<h1>Veranstaltungen</h1>
		
		<?php
			$static_info_seminare = $general->getStaticInfo('seminare');
			echo $static_info_seminare->info;
			$static_info_salon = $general->getStaticInfo('salon');
			echo $static_info_salon->info;	
		?>
  	</div>
    <div class="salon_seperator">
    	<h1>Termine</h1>
    </div>
	<?
  }
  	?>
  <div class="salon_content">
  	
<?php
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
	</div>

<? include "_footer.php"; ?>
