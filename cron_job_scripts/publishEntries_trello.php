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
$publ_query = "SELECT * FROM test WHERE publ_date <= CURDATE() AND DATEDIFF(CURDATE(),publ_date) < 6";
$publ_result = mysql_query($publ_query) or die("Failed Query of " .$publ_query. mysql_error());
$publ_rows = mysql_num_rows($publ_result);

echo $publ_rows."<br>";

if ($publ_rows == 0) {
	//get the id of the next entry which gets published
	//1. is there a unpublished entry that has priority status?
	$priority_query = "SELECT * FROM test WHERE publ_date = '0000-00-00' AND priority = 1 ORDER BY n asc LIMIT 1";
	$priority_result = mysql_query($priority_query) or die("Failed Query of " .$priority_query. mysql_error());
	$priority_rows = mysql_num_rows($priority_result);

	//echo $priority_rows;

	if ($priority_rows == 1) {
		$priority_entry = mysql_fetch_array($priority_result);
		$n = $priority_entry[n];
	}

	//2. if no priority entry available, pick the oldest unpublished one
	else {
	$n_query = "SELECT * FROM test WHERE publ_date = '0000-00-00' ORDER BY n asc LIMIT 1";
	$n_result = mysql_query($n_query) or die("Failed Query of " .$n_query. mysql_error());
	$n_entry = mysql_fetch_array($n_result);
	$n = $n_entry[n];
	}

	echo $n."<br>";

	//publish the entry where publ_date is NULL, which has the lowest identification number(n)
	$update_query = "UPDATE test SET publ_date = CURDATE() WHERE n = '$n'";
	mysql_query($update_query) or die("Failed Query of " .$update_query. mysql_error());
}


//edit the future entries
$edit_query = "SELECT * FROM test WHERE edited = 0";
$edit_result = mysql_query($edit_query) or die("Failed Query of " .$edit_query. mysql_error());
$edit_rows = mysql_num_rows($edit_result);

echo $edit_rows."<br>";

if (!$edit_rows == 0) {

	while($edit_entry = mysql_fetch_array($edit_result))
	{
		$n = $edit_entry[n];

		//transformation of published entry to HTML in title
		$html_query = "SELECT * FROM test WHERE n = '$n'";
		$html_result = mysql_query($html_query) or die("Failed Query of " .$html_query. mysql_error());
		$html_entry = mysql_fetch_array($html_result); //ACHTUNG: Funktioniert ab php 7.0 nicht mehr!

		$title = htmlentities($html_entry[title]);
		echo $title."<br>";

		$transform_query = "UPDATE test SET title = '$title' WHERE n = '$n'";
		mysql_query($transform_query) or die("Failed Query of " .$transform_query. mysql_error());

		//NEW for trello
		//ID Bearbeitung
		$alt= array("?","(",")");
		$id = str_replace($alt, ' ', $html_entry[id]);
		$id = trim($id);
		$id = preg_replace('/\s/', '-',$id );
		$transform_query = "UPDATE test SET id = '$id' WHERE n = '$n'";
		mysql_query($transform_query) or die("Failed Query of " .$transform_query. mysql_error());

		//Bearbeitung der Inhalte der zwei Textfelder
		$arr = array(private_text, public_text);
		foreach ($arr as &$feld) {

			$text=$html_entry[$feld];

			//links
			$text=preg_replace('/\((.*):\s(\d*)\)\s\[(.*)\]/', "(<a target=\"_blank\" href=\"https://www.amazon.de/dp/$3/&tag=scholarium-22\">$1, S.$2</a>)", $text);

			//'Markdown' nach 'html' mittels Parsedown
			$text=$Parsedown->text($text);

			//Anführungszeichen: Schreibmaschinensatz (&quot;, &quot;) nach deutsch (&bdquo;, &ldquo;)
			$text = preg_replace('/(\s|\A)&quot;(?!\s)/', '$1&bdquo;$2', $text);
			$text = str_replace("&quot;", '&ldquo;', $text);

			//get rid of <p>&nbsp;</p>
			$text=str_replace('<p>&nbsp;</p>', '',$text);

			//special css format for blockquotes
			$text=str_replace('<blockquote>', "<blockquote class=\"blockquote\">",$text);

			//get rid of &nbsp; --> WYSIWYG-editor error for some PDFs
			$text=str_replace('&nbsp;', ' ',$text);

			//get rid of the line
			$text=str_replace('<hr />', '',$text);

			//html Sonderzeichen
			$text=htmlentities($text);

			//Kontrolle
			//echo $text."<br>";

			//Update Datenbank
			$update_query = "UPDATE test SET $feld = '$text' WHERE n = '$n'";
			mysql_query($update_query) or die("Failed Query of " .$update_query. mysql_error());
		}


		//set edited to 1
		$update_query = "UPDATE test SET edited = '1' WHERE n = '$n'";
		mysql_query($update_query) or die("Failed Query of " .$update_query. mysql_error());
	}
}









	/*
	$public = htmlentities($html_entry[public_text]);
	$private = htmlentities($html_entry[private_text]);

	$transform_query = "UPDATE test SET public_text = '$public' WHERE n = '$n'";
	mysql_query($transform_query) or die("Failed Query of " .$transform_query. mysql_error());

	$transform_query = "UPDATE test SET private_text = '$private' WHERE n = '$n'";
	mysql_query($transform_query) or die("Failed Query of " .$transform_query. mysql_error());


	//inserting paragraphes
	$paragraph_query = "UPDATE test SET public_text = CONCAT('<p>', public_text) WHERE n = '$n'";
	mysql_query($paragraph_query) or die("Failed Query of " .$paragraph_query. mysql_error());

	$paragraph_query = "UPDATE test SET public_text = replace(public_text, '\n', '</p><p>') WHERE n = '$n'";
	mysql_query($paragraph_query) or die("Failed Query of " .$paragraph_query. mysql_error());

	$paragraph_query = "UPDATE test SET public_text = CONCAT(public_text, '</p>') WHERE n = '$n'";
	mysql_query($paragraph_query) or die("Failed Query of " .$paragraph_query. mysql_error());


	$paragraph_query = "UPDATE test SET private_text = CONCAT('<p>', private_text) WHERE n = '$n'";
	mysql_query($paragraph_query) or die("Failed Query of " .$paragraph_query. mysql_error());

	$paragraph_query = "UPDATE test SET private_text = replace(private_text, '\n', '</p><p>') WHERE n = '$n'";
	mysql_query($paragraph_query) or die("Failed Query of " .$paragraph_query. mysql_error());

	$paragraph_query = "UPDATE test SET private_text = CONCAT(private_text, '</p>') WHERE n = '$n'";
	mysql_query($paragraph_query) or die("Failed Query of " .$paragraph_query. mysql_error());


	//special css format for blockquotes (french)
	//$quote = '"quote"';

	$quote_query = "UPDATE test SET public_text = replace(public_text, '<p>&laquo;', '<blockquote>') WHERE n = '$n'";
	mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());

	$quote_query = "UPDATE test SET public_text = replace(public_text, '&raquo;</p>', '</blockquote>') WHERE n = '$n'";
	mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());

	$quote_query = "UPDATE test SET private_text = replace(private_text, '<p>&laquo;', '<blockquote>') WHERE n = '$n'";
	mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());

	$quote_query = "UPDATE test SET private_text = replace(private_text, '&raquo;</p>', '</blockquote>') WHERE n = '$n'";
	mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());


	//normal quote marks
	$quote_query = "UPDATE test SET public_text = replace(public_text, '&bdquo;', '&bdquo;') WHERE n = '$n'";
	mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());

	$quote_query = "UPDATE test SET private_text = replace(private_text, '&rdquo;', '&rdquo;') WHERE n = '$n'";
	mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());
	*/



/*
//Another possible, but more complicated solution (using htmlentities) for transforming to html that has some mistake:

$transform_query = "UPDATE test SET title = replace(title, '%ä%', '%&auml%;') WHERE n = '$n';
						UPDATE test SET title = replace(title, '%Ä%', '%&Auml%;') WHERE n = '$n';
						UPDATE test SET title = replace(title, 'ü', '&uuml;') WHERE n = '$n';
						UPDATE test SET title = replace(title, 'Ü', '&Uuml;') WHERE n = '$n';
						UPDATE test SET title = replace(title, 'ö', '&ouml;') WHERE n = '$n';
						UPDATE test SET title = replace(title, 'Ö', '&Ouml;') WHERE n = '$n';
						UPDATE test SET title = replace(title, 'ß', '&szlig;') WHERE n = '$n';
						UPDATE test SET title = replace(title, '€', '&euro;') WHERE n = '$n';

						UPDATE test SET public = replace(public, 'ä', '&auml;') WHERE n = '$n';
						UPDATE test SET public = replace(public, 'Ä', '&Auml;') WHERE n = '$n';
						UPDATE test SET public = replace(public, 'ü', '&uuml;') WHERE n = '$n';
						UPDATE test SET public = replace(public, 'Ü', '&Uuml;') WHERE n = '$n';
						UPDATE test SET public = replace(public, 'ö', '&ouml;') WHERE n = '$n';
						UPDATE test SET public = replace(public, 'Ö', '&Ouml;') WHERE n = '$n';
						UPDATE test SET public = replace(public, 'ß', '&szlig;') WHERE n = '$n';
						UPDATE test SET public = replace(public, '€', '&euro;') WHERE n = '$n';

						UPDATE test SET private = replace(private, 'ä', '&auml;') WHERE n = '$n';
						UPDATE test SET private = replace(private, 'Ä', '&Auml;') WHERE n = '$n';
						UPDATE test SET private = replace(private, 'ü', '&uuml;') WHERE n = '$n';
						UPDATE test SET private = replace(private, 'Ü', '&Uuml;') WHERE n = '$n';
						UPDATE test SET private = replace(private, 'ö', '&ouml;') WHERE n = '$n';
						UPDATE test SET private = replace(private, 'Ö', '&Ouml;') WHERE n = '$n';
						UPDATE test SET private = replace(private, 'ß', '&szlig;') WHERE n = '$n';
						UPDATE test SET private = replace(private, '€', '&euro;') WHERE n = '$n';";

	mysqli_multi_query($transform_query) or die("Failed Query of " .$transform_query. mysql_error());

*/

//Absätze und kursiv -> ersetzt durch Parsedown s.o.
//		$alt= array("\r\n\r\n");
//		$neu=array("</p><p>");
//		$text=str_replace($alt, $neu, $text);
// 	  $text='<p>'.$text.'</p>';
//		$text=preg_replace('/\*(.*?)\*/',"<em>$1</em>",$text);

//get rid of <p>&nbsp;</p>
//$nbsp_query = "UPDATE test SET private_text = replace(private_text, '<p>&nbsp;</p>', '') WHERE n = '$n'";
//mysql_query($nbsp_query) or die("Failed Query of " .$nbsp_query. mysql_error());

//$nbsp_query = "UPDATE test SET public_text = replace(public_text, '<p>&nbsp;</p>', '') WHERE n = '$n'";
//mysql_query($nbsp_query) or die("Failed Query of " .$nbsp_query. mysql_error());


//special css format for blockquotes
/*$blockquote = '"blockquote"';

$quote_query = "UPDATE test SET public_text = replace(public_text, '<blockquote>', '<blockquote class=$blockquote>') WHERE n = '$n'";
mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());

//$quote_query = "UPDATE test SET public_text = replace(public_text, '&raquo;</p>', '</p></blockquote>') WHERE n = '$n'";
//mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());

$quote_query = "UPDATE test SET private_text = replace(private_text, '<blockquote>', '<blockquote class=$blockquote>') WHERE n = '$n'";
mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());

//$quote_query = "UPDATE test SET private_text = replace(private_text, '&raquo;</p>', '</p></blockquote>') WHERE n = '$n'";
//mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());


//get rid of &nbsp; --> WYSIWYG-editor error for some PDFs
$nbsp_query = "UPDATE test SET private_text = replace(private_text, '&nbsp;', ' ') WHERE n = '$n'";
mysql_query($nbsp_query) or die("Failed Query of " .$nbsp_query. mysql_error());

$nbsp_query = "UPDATE test SET public_text = replace(public_text, '&nbsp;', ' ') WHERE n = '$n'";
mysql_query($nbsp_query) or die("Failed Query of " .$nbsp_query. mysql_error());


//get rid of the line
$line_query = "UPDATE test SET private_text = replace(private_text, '<hr />', '') WHERE n = '$n'";
mysql_query($line_query) or die("Failed Query of " .$line_query. mysql_error());
*/

?>
