<?php

//content: cron job to manage publication of blog entries in sql database
//author: Bernhard Hegyi

@$con=mysql_connect("newBig.db.6152056.hostedresource.com","newBig","bmbClat1!") or die ("cannot connect to MySQL");
mysql_select_db("newBig");
//mysql_query("SET NAMES 'utf8'");

//checks if there are published entries from today or yesterday; every 2 days there should be a new post
$publ_query = "SELECT * FROM blog WHERE publ_date <= CURDATE() AND DATEDIFF(CURDATE(),publ_date) < 2";
$publ_result = mysql_query($publ_query) or die("Failed Query of " .$publ_query. mysql_error());
$publ_rows = mysql_num_rows($publ_result); 

echo $publ_rows;

if ($publ_rows == 0) {
	//get the id of the next entry which gets published
	//1. is there a unpublished entry that has priority status?
	$priority_query = "SELECT * FROM blog WHERE publ_date IS NULL AND priority = 1 ORDER BY n asc LIMIT 1";
	$priority_result = mysql_query($priority_query) or die("Failed Query of " .$priority_query. mysql_error());
	$priority_rows = mysql_num_rows($priority_result); 

	//echo $priority_rows;
	
	if ($priority_rows == 1) {
		$priority_entry = mysql_fetch_array($priority_result);
		$n = $priority_entry[n];
	}
	
	//2. if no priority entry available, pick the oldest unpublished one 
	else {
	$n_query = "SELECT * FROM blog WHERE publ_date IS NULL ORDER BY n asc LIMIT 1";
	$n_result = mysql_query($n_query) or die("Failed Query of " .$n_query. mysql_error());
	$n_entry = mysql_fetch_array($n_result);
	$n = $n_entry[n];
	}

	//echo $n;

	//publish the entry where publ_date is NULL, which has the lowest identification number(n)
	$update_query = "UPDATE blog SET publ_date = CURDATE() WHERE n = '$n'";
	mysql_query($update_query) or die("Failed Query of " .$update_query. mysql_error());
}	


//edit the future entries
$edit_query = "SELECT * FROM blog WHERE edited = 0";
$edit_result = mysql_query($edit_query) or die("Failed Query of " .$edit_query. mysql_error());
$edit_rows = mysql_num_rows($edit_result); 

echo $edit_rows;

if (!$edit_rows == 0) {

	while($edit_entry = mysql_fetch_array($edit_result))
	{
		$n = $edit_entry[n];

		//transformation of published entry to HTML in title
		$html_query = "SELECT * FROM blog WHERE n = '$n'";
		$html_result = mysql_query($html_query) or die("Failed Query of " .$html_query. mysql_error());
		$html_entry = mysql_fetch_array($html_result);

		$title = htmlentities($html_entry[title]);

		$transform_query = "UPDATE blog SET title = '$title' WHERE n = '$n'";
		mysql_query($transform_query) or die("Failed Query of " .$transform_query. mysql_error());


		//get rid of <p>&nbsp;</p>
		$nbsp_query = "UPDATE blog SET private_text = replace(private_text, '<p>&nbsp;</p>', '') WHERE n = '$n'";
		mysql_query($nbsp_query) or die("Failed Query of " .$nbsp_query. mysql_error());

		$nbsp_query = "UPDATE blog SET public_text = replace(public_text, '<p>&nbsp;</p>', '') WHERE n = '$n'";
		mysql_query($nbsp_query) or die("Failed Query of " .$nbsp_query. mysql_error());

		
		//special css format for blockquotes (french quote marks)
		$blockquote = '"blockquote"';

		$quote_query = "UPDATE blog SET public_text = replace(public_text, '<p>&laquo;', '<blockquote class=$blockquote><p>') WHERE n = '$n'";
		mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());

		$quote_query = "UPDATE blog SET public_text = replace(public_text, '&raquo;</p>', '</p></blockquote>') WHERE n = '$n'";
		mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());

		$quote_query = "UPDATE blog SET private_text = replace(private_text, '<p>&laquo;', '<blockquote class=$blockquote><p>') WHERE n = '$n'";
		mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());

		$quote_query = "UPDATE blog SET private_text = replace(private_text, '&raquo;</p>', '</p></blockquote>') WHERE n = '$n'";
		mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());
		

		//get rid of &nbsp; --> WYSIWYG-editor error for some PDFs
		$nbsp_query = "UPDATE blog SET private_text = replace(private_text, '&nbsp;', ' ') WHERE n = '$n'";
		mysql_query($nbsp_query) or die("Failed Query of " .$nbsp_query. mysql_error());

		$nbsp_query = "UPDATE blog SET public_text = replace(public_text, '&nbsp;', ' ') WHERE n = '$n'";
		mysql_query($nbsp_query) or die("Failed Query of " .$nbsp_query. mysql_error());


		//get rid of the line
		$line_query = "UPDATE blog SET private_text = replace(private_text, '<hr />', '') WHERE n = '$n'";
		mysql_query($line_query) or die("Failed Query of " .$line_query. mysql_error());


		//set edited to 1
		$update_query = "UPDATE blog SET edited = '1' WHERE n = '$n'";
		mysql_query($update_query) or die("Failed Query of " .$update_query. mysql_error());
	}
}









	/*
	$public = htmlentities($html_entry[public_text]);
	$private = htmlentities($html_entry[private_text]);

	$transform_query = "UPDATE blog SET public_text = '$public' WHERE n = '$n'";
	mysql_query($transform_query) or die("Failed Query of " .$transform_query. mysql_error());

	$transform_query = "UPDATE blog SET private_text = '$private' WHERE n = '$n'";
	mysql_query($transform_query) or die("Failed Query of " .$transform_query. mysql_error());
						
	
	//inserting paragraphes
	$paragraph_query = "UPDATE blog SET public_text = CONCAT('<p>', public_text) WHERE n = '$n'";
	mysql_query($paragraph_query) or die("Failed Query of " .$paragraph_query. mysql_error());

	$paragraph_query = "UPDATE blog SET public_text = replace(public_text, '\n', '</p><p>') WHERE n = '$n'";
	mysql_query($paragraph_query) or die("Failed Query of " .$paragraph_query. mysql_error());

	$paragraph_query = "UPDATE blog SET public_text = CONCAT(public_text, '</p>') WHERE n = '$n'";
	mysql_query($paragraph_query) or die("Failed Query of " .$paragraph_query. mysql_error());


	$paragraph_query = "UPDATE blog SET private_text = CONCAT('<p>', private_text) WHERE n = '$n'";
	mysql_query($paragraph_query) or die("Failed Query of " .$paragraph_query. mysql_error());

	$paragraph_query = "UPDATE blog SET private_text = replace(private_text, '\n', '</p><p>') WHERE n = '$n'";
	mysql_query($paragraph_query) or die("Failed Query of " .$paragraph_query. mysql_error());

	$paragraph_query = "UPDATE blog SET private_text = CONCAT(private_text, '</p>') WHERE n = '$n'";
	mysql_query($paragraph_query) or die("Failed Query of " .$paragraph_query. mysql_error());

	
	//special css format for blockquotes (french)
	//$quote = '"quote"';

	$quote_query = "UPDATE blog SET public_text = replace(public_text, '<p>&laquo;', '<blockquote>') WHERE n = '$n'";
	mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());

	$quote_query = "UPDATE blog SET public_text = replace(public_text, '&raquo;</p>', '</blockquote>') WHERE n = '$n'";
	mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());

	$quote_query = "UPDATE blog SET private_text = replace(private_text, '<p>&laquo;', '<blockquote>') WHERE n = '$n'";
	mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());

	$quote_query = "UPDATE blog SET private_text = replace(private_text, '&raquo;</p>', '</blockquote>') WHERE n = '$n'";
	mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());
	

	//normal quote marks
	$quote_query = "UPDATE blog SET public_text = replace(public_text, '&bdquo;', '&bdquo;') WHERE n = '$n'";
	mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());

	$quote_query = "UPDATE blog SET private_text = replace(private_text, '&rdquo;', '&rdquo;') WHERE n = '$n'";
	mysql_query($quote_query) or die("Failed Query of " .$quote_query. mysql_error());
	*/



/*
//Another possible, but more complicated solution (using htmlentities) for transforming to html that has some mistake:

$transform_query = "UPDATE blog SET title = replace(title, '%ä%', '%&auml%;') WHERE n = '$n';
						UPDATE blog SET title = replace(title, '%Ä%', '%&Auml%;') WHERE n = '$n';
						UPDATE blog SET title = replace(title, 'ü', '&uuml;') WHERE n = '$n';
						UPDATE blog SET title = replace(title, 'Ü', '&Uuml;') WHERE n = '$n';
						UPDATE blog SET title = replace(title, 'ö', '&ouml;') WHERE n = '$n';
						UPDATE blog SET title = replace(title, 'Ö', '&Ouml;') WHERE n = '$n';
						UPDATE blog SET title = replace(title, 'ß', '&szlig;') WHERE n = '$n';
						UPDATE blog SET title = replace(title, '€', '&euro;') WHERE n = '$n';
						
						UPDATE blog SET public = replace(public, 'ä', '&auml;') WHERE n = '$n';
						UPDATE blog SET public = replace(public, 'Ä', '&Auml;') WHERE n = '$n';
						UPDATE blog SET public = replace(public, 'ü', '&uuml;') WHERE n = '$n';
						UPDATE blog SET public = replace(public, 'Ü', '&Uuml;') WHERE n = '$n';
						UPDATE blog SET public = replace(public, 'ö', '&ouml;') WHERE n = '$n';
						UPDATE blog SET public = replace(public, 'Ö', '&Ouml;') WHERE n = '$n';
						UPDATE blog SET public = replace(public, 'ß', '&szlig;') WHERE n = '$n';
						UPDATE blog SET public = replace(public, '€', '&euro;') WHERE n = '$n';

						UPDATE blog SET private = replace(private, 'ä', '&auml;') WHERE n = '$n';
						UPDATE blog SET private = replace(private, 'Ä', '&Auml;') WHERE n = '$n';
						UPDATE blog SET private = replace(private, 'ü', '&uuml;') WHERE n = '$n';
						UPDATE blog SET private = replace(private, 'Ü', '&Uuml;') WHERE n = '$n';
						UPDATE blog SET private = replace(private, 'ö', '&ouml;') WHERE n = '$n';
						UPDATE blog SET private = replace(private, 'Ö', '&Ouml;') WHERE n = '$n';
						UPDATE blog SET private = replace(private, 'ß', '&szlig;') WHERE n = '$n';
						UPDATE blog SET private = replace(private, '€', '&euro;') WHERE n = '$n';";

	mysqli_multi_query($transform_query) or die("Failed Query of " .$transform_query. mysql_error());

*/


?>

