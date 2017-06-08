<?php

//content: cron job to manage publication of blog entries in sql database
//author: Bernhard Hegyi

require_once('../config/config.php');
include 'parsedown.php';
$Parsedown = new Parsedown();

@$con=mysql_connect(DB_HOST,DB_USER,DB_PASS) or die ("cannot connect to MySQL");
mysql_select_db(DB_NAME);
//mysql_query("SET NAMES 'utf8'");

//checks if there are published entries from today or yesterday; every 4 days there should be a new post
//TO DO: Check publication plan, wenn 2 geplante Posts 4 Tage auseinander sind
$publ_query = "SELECT * FROM blog WHERE publ_date <= CURDATE() AND DATEDIFF(CURDATE(),publ_date) < 6";
$publ_result = mysql_query($publ_query) or die("Failed Query of " .$publ_query. mysql_error());
$publ_rows = mysql_num_rows($publ_result);

echo $publ_rows."<br>";

if ($publ_rows == 0) {
	//get the id of the next entry which gets published
	//1. is there a unpublished entry that has priority status?
	$priority_query = "SELECT * FROM blog WHERE publ_date = '0000-00-00' AND priority = 1 ORDER BY n asc LIMIT 1";
	$priority_result = mysql_query($priority_query) or die("Failed Query of " .$priority_query. mysql_error());
	$priority_rows = mysql_num_rows($priority_result);

	//echo $priority_rows;

	if ($priority_rows == 1) {
		$priority_entry = mysql_fetch_array($priority_result);
		$n = $priority_entry[n];
	}

	//2. if no priority entry available, pick the oldest unpublished one
	else {
	$n_query = "SELECT * FROM blog WHERE publ_date = '0000-00-00' ORDER BY n asc LIMIT 1";
	$n_result = mysql_query($n_query) or die("Failed Query of " .$n_query. mysql_error());
	$n_entry = mysql_fetch_array($n_result);
	$n = $n_entry[n];
	}

	echo $n."<br>";

	//publish the entry where publ_date is NULL, which has the lowest identification number(n)
	$update_query = "UPDATE blog SET publ_date = CURDATE() WHERE n = '$n'";
	mysql_query($update_query) or die("Failed Query of " .$update_query. mysql_error());
}


//edit the future entries
$edit_query = "SELECT * FROM blog WHERE edited = 0";
$edit_result = mysql_query($edit_query) or die("Failed Query of " .$edit_query. mysql_error());
$edit_rows = mysql_num_rows($edit_result);

echo $edit_rows."<br>";

if (!$edit_rows == 0) {

	while($edit_entry = mysql_fetch_array($edit_result))
	{
		$n = $edit_entry[n];

		//transformation of published entry to HTML in title
		$html_query = "SELECT * FROM blog WHERE n = '$n'";
		$html_result = mysql_query($html_query) or die("Failed Query of " .$html_query. mysql_error());
		$html_entry = mysql_fetch_array($html_result); //ACHTUNG: Funktioniert ab php 7.0 nicht mehr!

		//$title = htmlentities($html_entry[title]);
		echo $title."<br>";

		$transform_query = "UPDATE blog SET title = '$title' WHERE n = '$n'";
		mysql_query($transform_query) or die("Failed Query of " .$transform_query. mysql_error());

		//NEW for trello
		//ID Bearbeitung
		$search = array("Ä", "Ö", "Ü", "ä", "ö", "ü", "ß", "´");
		$replace = array("Ae", "Oe", "Ue", "ae", "oe", "ue", "ss", "");
		$id= str_replace($search, $replace, $html_entry[id]);
		$alt= array("?", "(" , ")" , " - " , chr(150) ,chr(151), "," , "." , ";" , ":" , "\"" , "!");
		$id = str_replace($alt, ' ', $id);
		$id = str_replace("  ", ' ', $id);
		$id = str_replace("  ", ' ', $id);
		$id = trim($id);
		$id = preg_replace('/\s/', '-',$id );
		$transform_query = "UPDATE blog SET id = '$id' WHERE n = '$n'";
		mysql_query($transform_query) or die("Failed Query of " .$transform_query. mysql_error());

		//Bearbeitung der Inhalte der zwei Textfelder
		$arr = array(private_text, public_text, title);
		foreach ($arr as &$feld) {

			$text=$html_entry[$feld];

			// _ für kursiv, von Parsedown nicht erkannt
			$text = preg_replace('/(\s|\A)_(?!\s)/', '$1*$2', $text);
			$text = str_replace("(\s)_", '$1*', $text);
			$text = str_replace("_([\s-\.])", '*$1', $text);

			//links
			$text=preg_replace('/\(([0-9a-zA-Z\s-\.]*):\s(.*)\)\s\[(.*)\]/', "(<a target=\"_blank\" href=\"https://www.amazon.de/dp/$3/&tag=scholarium-21\">$1, S.$2</a>)", $text);

			//'Markdown' nach 'html' mittels Parsedown
			$text=$Parsedown->text($text);

			//Anführungszeichen: Schreibmaschinensatz (&quot;, &quot;) nach deutsch (&bdquo;, &ldquo;)
			$text = preg_replace('/(\s|>|\A)&quot;(?!\s)/', '$1&bdquo;$2', $text);
			$text = str_replace("&quot;", '&ldquo;', $text);

			//Anführungszeichen: fehlerhafte(englisch schließend) (&rdquo;, &rdquo;) nach deutsch (&bdquo;, &ldquo;)
			$text = preg_replace('/(\s|>|\A)&ldquo;(?!\s)/', '$1&bdquo;$2', $text);
			$text = str_replace("&rdquo;", '&ldquo;', $text);


			//get rid of <p>&nbsp;</p>
			$text=str_replace('<p>&nbsp;</p>', '',$text);

			//special css format for blockquotes
			$text=str_replace('<blockquote>', "<blockquote class=\"blockquote\">",$text);

			//get rid of &nbsp; --> WYSIWYG-editor error for some PDFs
			$text=str_replace('&nbsp;', ' ',$text);

			//get rid of the line
			$text=str_replace('<hr />', '',$text);

			//Gedankenstriche
			$text=preg_replace('/(\s)\-(\s)/', '$1&ndash;$2',$text);

			// Escape für mysql Sonderzeichen
			$text=mysql_real_escape_string($text);

			//html Sonderzeichen
			//$text=htmlentities($text);

			//Kontrolle
			//echo $text."<br>";
			if ($feld == title){
				$text=str_replace('<p>','',$text);
				$text=str_replace('</p>','',$text);
			}
			//Update Datenbank
			$update_query = "UPDATE blog SET $feld = '$text' WHERE n = '$n'";
			mysql_query($update_query) or die("Failed Query of " .$update_query. mysql_error());
		}


		//set edited to 1
		$update_query = "UPDATE blog SET edited = '1' WHERE n = '$n'";
		mysql_query($update_query) or die("Failed Query of " .$update_query. mysql_error());
	}
}

?>
