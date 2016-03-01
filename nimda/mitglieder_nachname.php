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
		<title>Mitgliederliste (nach Nachname sortiert)</title>
		
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
                width: 17cm;
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
                 width: 7cm;
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
			.rot {
				background-color:rgba(255,0,0,0.5);
			}
			.gelb {
				background-color:rgba(255,255,0,0.3);
			}
			.gruen {
				background-color:rgba(0,255,0,0.3);
			}
			.weiss {
				background-color: white;
			}
		</style>
		
	</head>
	<body>
		<div class="content">
			<div class="logo">
                <img src="../style/gfx/ticket_logo.png">
            </div>
<?php
  
	echo '<div>';
	echo '<table class="teilnehmer">';
		echo '<tr>';
			echo '<th>ID</th>';		
			echo '<th>Name</th>';
			echo '<th>Vorname</th>';
			echo '<th>E-Mail</th>';
			echo '<th>Stufe</th>';
			echo '<th>Ablauf</th>';
			echo '<th>Guthaben</th>';
			echo '<th>Tage seit letztem Login</th>';
		echo '</tr>';
		
	$user_query = "SELECT * from mitgliederExt WHERE Mitgliedschaft > 1 || Zahlung != '' order by Nachname ASC";
	$user_result = mysql_query($user_query) or die("Failed Query of " . $user_query. mysql_error());
	
  	while($userEntry = mysql_fetch_array($user_result)) {
  		
		$user_id = $userEntry[user_id];	
		$email = $userEntry[user_email];
		$surname = $userEntry[Nachname];
		$name = $userEntry[Vorname];
		$stufe = $userEntry[Mitgliedschaft];
		$ablauf = $userEntry[Ablauf];
		$guthaben = $userEntry[credits_left];
		$letzter_login = floor((abs(strtotime(date("Y-m-d")) - strtotime($userEntry[last_login_time]))/(60*60*24)));
		if ($userEntry[last_login_time] == '') {$letzter_login = 'Nie';}
		
		
		$diff_ablauf = floor((abs(strtotime(date("Y-m-d")) - strtotime($ablauf))/(60*60*24)));
		
		if (strtotime($ablauf) < time() && $ablauf !='') {$ablauf_bgc = 'rot';}
		elseif ($diff_ablauf<30) {$ablauf_bgc = 'gelb';}
		else {$ablauf_bgc = 'weiss';}
		
		echo '<tr>';
		echo '<td>'.$user_id.'</td>';
			echo '<td>'.$surname.'</td>';
			echo '<td>'.$name.'</td>';
			echo '<td>'.$email.'</td>';
			echo '<td>'.$stufe.'</td>';
			echo '<td class='.$ablauf_bgc.'>'.$ablauf.'</td>';
			echo '<td>'.$guthaben.'</td>';
			echo '<td>'.$letzter_login.'</td>';
		echo '</tr>';
		
	}
	
	echo '</table>';
	echo '</div>';
	

	
	echo '</ul>';
	echo '</div>';
?>
	<a href="index.php">Zur&uuml;ck zum Admin Panel</a>
		</div>
	</body>
</html>