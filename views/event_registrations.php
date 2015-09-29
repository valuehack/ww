<?php
	require_once('../config/config.php');
	
	@$con=mysql_connect(DB_HOST,DB_USER,DB_PASS) or die ("cannot connect to MySQL");
	mysql_select_db(DB_NAME);

	header('Content-Type: text/html; charset=ISO-8859-1');
?>

<!DOCTYPE html>
<html lang="de">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Event&uuml;bersicht</title>
		
		<style>
		    @font-face {
            font-family: 'Futura Book';
            src: url('http://www.scholarium.at/style/font/futura_bock_regular.ttf') format('truetype');
            }
            
            @font-face {
            font-family: 'Garamond';
            src: url('http://www.scholarium.at/style/font/garamond_regular.otf') format('opentype');
			}
            .content {
                width: 21cm;
                padding: 2cm;
            }
            .logo {
                text-align: right;
            }
            .logo img {
                width: 7cm;
                margin: 0cm 1cm 1cm 0cm;
            }
            h1 {
                font-size: 26pt;
                text-align: center;
                font-weight: normal;
                font-family: "Futura Book", Georgia, Arial, Helvetica, sans-serif;
            }
            .datum  {
                font-size: 14pt;
                text-align: center;
                font-family: "Garamond", Times, serif;
                margin-bottom: 1cm;                                
            }
            .teilnehmer {
                width: 100%;
            }
            .teilnehmer th {
                font-family: "Futura Book", Georgia, Arial, Helvetica, sans-serif;
                font-weight: normal;
                border-bottom: 1px solid #000;
                width: 7cm;
                padding: 5px;
            }
            .teilnehmer td {
                font-family: "Garamond", Times, serif;
                width: 7cm;
                padding: 5px;
            }
            .bottom td {
                border-top: 1px solid #000;
            }
			.list {
				margin: 50px;
			}
			.list ul {
				list-style-type: none;
			}
			.list li {
				margin: 5px 0;
			}
			.list li a {
				font-size: 18pt;
				text-decoration: none;
			}
			.list li a:hover {
				text-decoration: underline;
			}
		</style>
		
	</head>
	<body>
		<div class="content">
			<div class="logo">
                <img src="../style/gfx/ticket_logo.png">
            </div>
<?php
if(isset($_GET['q']))
{
	$id = $_GET['q'];
	
	$sql = "SELECT * from produkte WHERE (type='lehrgang' or type='seminar' or type='kurs' or type='salon') and id='$id'";
  	$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  	$entry = mysql_fetch_array($result);
	
	$n = $entry[n];
	$title = $entry[title];
	$start = $entry[start];
	$end = $entry[end];
	$spots_sold = $entry[spots_sold];
	
	echo '<h1>'.$title.'</h1>';
	
	echo '<p class="datum">';
	if ($entry[start] != NULL && $entry[end] != NULL)
        {
        $tag=date("w",strtotime($entry[start]));
        $tage = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
        echo $tage[$tag]." ";
        echo strftime("%d.%m.%Y %H:%M", strtotime($entry[start]));
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
        echo strftime("%d.%m.%Y %H:%M Uhr", strtotime($entry[start]));
      }
      else echo "Der Termin wird in K&uuml;rze bekannt gegeben.";
	echo '</p>';
	  
	echo '<div>';
	echo '<table class="teilnehmer">';
		echo '<tr>';
			echo '<th>Vorname</th>';
			echo '<th>Nachname</th>';
			echo '<th>Anzahl Pl&auml;tze</th>';
		echo '</tr>';
		
	$event_user_query = "SELECT * from registration WHERE event_id='$n'";
  	$event_user_result = mysql_query($event_user_query) or die("Failed Query of " . $event_user_query. mysql_error());
  	
  	while($eventUserQuery = mysql_fetch_array($event_user_result)) {
  		
		$user_id = $eventUserQuery[user_id];
		$quantity = $eventUserQuery[quantity];
		
		$user_query = "SELECT * from mitgliederExt WHERE user_id ='$user_id'";
		$user_result = mysql_query($user_query) or die("Failed Query of " . $user_query. mysql_error());
		$userEntry = mysql_fetch_array($user_result);
		
		$surname = $userEntry[Nachname];
		$name = $userEntry[Vorname];
		
		echo '<tr>';
			echo '<td>'.$name.'</td>';
			echo '<td>'.$surname.'</td>';
			echo '<td>'.$quantity.'</td>';
		echo '</tr>';
		
	}
	
		echo '<tr class="bottom">';
			echo '<td>&nbsp;</td>';
			echo '<td>Anzahl Teilnehmer</td>';
			echo '<td>'.$spots_sold.'</td>';
		echo '</tr>';
	echo '</table>';
	echo '</div>';
	
}
else {
	$sql = "SELECT * from produkte WHERE (type='salon' or type='lehrgang' or type='seminar' or type='kurs' or type='salon') and (start > NOW()) and (status = 1) order by start asc, n asc";
	$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
	
	echo '<div class="list">';
	echo '<ul>';
	
	while($entry = mysql_fetch_array($result)) {
		$id = $entry[id];
		$title = $entry[title];
		
		echo '<li><a href="event_registrations.php?q='.$id.'">'.$title.'</a></li>';
	}
	
	echo '</ul>';
	echo '</div>';
}
?>
		</div>
	</body>
</html>