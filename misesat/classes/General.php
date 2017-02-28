<?php

	#Collection of general functions used within the page
	
class General {
	

	
	public function __construct() {
		
		$this->databaseConnection();
	}
	
	private function databaseConnection()
    {
        // if connection already exists
        if ($this->db_connection != null) {
            return true;
        } else {
            try {
                // Generate a database connection, using the PDO connector
                // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
                // Also important: We include the charset, as leaving it out seems to be a security issue:
                // @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
                // "Adding the charset to the DSN is very important for security reasons,
                // most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
                #$this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=latin1', DB_USER, DB_PASS);

                #using utf8 charset instead of latin1
                $this->db_connection = new PDO('mysql:host='. DB_MISESAT_HOST .';dbname='. DB_MISESAT_NAME . ';charset=utf8', DB_MISESAT_USER, DB_MISESAT_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                							
                #query sets timezone for the database
                $query_time_zone = $this->db_connection->prepare("SET time_zone = 'Europe/Vienna'");
                $query_time_zone->execute();
                
                return true;
            } catch (PDOException $e) {
                #$this->errors[] = MESSAGE_DATABASE_ERROR . $e->getMessage();
                echo "error! <br>".$e->getMessage();
            }
        }
        // default return
        return false;
    }

	public function getInfo ($table, $id) {
		# Get info of a single row based on the id
		# $table = name of sql table (denker, orte, bucher, artikel, etc.)
		# $id = id of the row of interest
		
		$info_query = $this->db_connection->prepare('SELECT * FROM '.$table.' WHERE id = :id');
		$info_query->bindValue(':id', $id, PDO::PARAM_STR);
		$info_query->execute();
		
		return $info_query->fetchObject();
	}
	
	public function getSpecialList ($n, $table, $prop, $id, $orderby, $order) {
		
		$list_query = $this->db_connection->prepare('SELECT '.$n.' FROM '.$table.' WHERE '.$prop.' = :'.$prop.' ORDER by '.$orderby.' '.$order.'');
		$list_query->bindValue(':'.$prop, $id, PDO::PARAM_STR);
		$list_query->execute();
		
		return $list_query->fetchAll();
	}
	
	public function getSpecialObject ($n, $table, $prop, $id) {
		
		$info_query = $this->db_connection->prepare('SELECT '.$n.' FROM '.$table.' WHERE '.$prop.' = :'.$prop.'');
		$info_query->bindValue(':'.$prop, $id, PDO::PARAM_STR);
		$info_query->execute();
		
		return $info_query->fetchObject();
	}
	
	public function getRandomInfo ($table) {
		# Takes a random entry out of  the table specified
		
		$counter_query = $this->db_connection->prepare('SELECT * FROM '.$table);
		$counter_query->execute();
		$counter = $counter_query->rowCount();
		
		$rand = rand(1,$counter);
		
		$info_query = $this->db_connection->prepare('SELECT * FROM '.$table.' WHERE n = :n');
		$info_query->bindValue(':n', $rand, PDO::PARAM_INT);
		$info_query->execute();
		
		error_log('Counter '.$counter);
		error_log('Rand '.$rand);
		
		return $info_query->fetchObject();
	}
	
	public function getItemList($table, $orderby, $order) {
						
		$list_query = $this->db_connection->prepare('SELECT * FROM '.$table.' ORDER by '.$orderby.' '.$order.'');
		$list_query->execute();
    	
    	return $list_query->fetchAll();
	}
	
	public function substrCloseTags($code, $limit = 300) {
		# Creates a substr out of a html string where html end tags are closed		
		
    	if ( strlen($code) <= $limit )
    	{
      	  return $code;
   		}

    	$html = substr($code, 0, $limit);
    	preg_match_all ( "#<([a-zA-Z]+)#", $html, $result );

    	foreach($result[1] as $key => $value)
    	{
        	if ( strtolower($value) == 'br' )
        	{
            	unset($result[1][$key]);
        	}
    	}
    	$openedtags = $result[1];

    	preg_match_all ( "#</([a-zA-Z]+)>#iU", $html, $result );
    	$closedtags = $result[1];

    	foreach($closedtags as $key => $value)
    	{
        	if ( ($k = array_search($value, $openedtags)) === FALSE )
       		{
            	continue;
        	}
        	else
        	{
            	unset($openedtags[$k]);
        	}
    	}

    	if ( empty($openedtags) )
    	{
        	if ( strpos($code, ' ', $limit) == $limit )
        	{
            	return $html."...";
        	}
        	else
        	{
            	return substr($code, 0, strpos($code, ' ', $limit))."...";
        	}
    	}

    	$position = 0;
    	$close_tag = '';
    	foreach($openedtags AS $key => $value)
    	{   
        	$p = strpos($code, ('</'.$value.'>'), $limit);

        	if ( $p === FALSE )
        	{
            	$code .= ('</'.$value.'>');
        	}
        	else if ( $p > $position )
        	{
            	$close_tag = '</'.$value.'>';
            	$position = $p;
        	}
    	}

    	if ( $position == 0 )
    	{
        	return $code;
    	}

    	return substr($code, 0, $position).$close_tag."...";
	}

	public function clearAuthorList ($list) {
		# Clears the Author List from Authors without books or articles in the database
		# Returns a reindexed array
		
		for ($k = 0; $k < count($list); $k++) {
			$name = $list[$k]['name'];
		
			$book = $this->db_connection->prepare('SELECT * FROM buecher WHERE autor = :autor ORDER BY jahr DESC');
			$book->bindValue(':autor', $name, PDO::PARAM_STR);
			$book->execute();
			$result_book = $book->fetchAll();
		
			$art = $this->db_connection->prepare('SELECT * FROM artikel WHERE autor = :autor ORDER BY jahr DESC');
			$art->bindValue(':autor', $name, PDO::PARAM_STR);
			$art->execute();
			$result_art = $art->fetchAll();
		
			if (!empty($result_book) || !empty($result_art)) {
			$l[$k] = $list[$k];
			}
	}
	$l = array_values($l);
	return $l;
	}
	
	public function addlinks($text){ 

	$sql_orte = $this->db_connection->prepare('SELECT id, name FROM orte ORDER BY id DESC');
	$sql_orte->execute();
	$result_orte = $sql_orte->fetchAll();

	$sql_denker = $this->db_connection->prepare('SELECT id, name FROM denker ORDER BY id DESC');
	$sql_denker->execute();
	$result_denker = $sql_denker->fetchAll();

	$zeichen = array(".",",",")"," ",";","'"); //Seperators/Endings included
	$zincluded = array("","s");

	$name = "name";
	$id = "id";

	$links = array();
	$words = array();

	$links2 = array(); //Fuer Vor- oder Nachnamen
	$words2 = array();

	$links3 = array(); //Fuer Vor- oder Nachnamen
	$words3 = array();

	foreach($zeichen as $i){ //Cycle through seperators
	  
	  if(func_get_arg(1) != FALSE){
	    $current = func_get_arg(1);
	  } else {
	    $current = "";
	  }
	  
	  foreach($zincluded as $s){
	    
	    for ($n = 0; $n < count($result_denker); $n++) {
	      
	      $denkername = $result_denker[$n][$name];
	      $denkerid = $result_denker[$n][$id];
	      
	      $pieces = explode(' ', $denkername);
	      
	      if($current == $denkername){ //Überspringen, damit nicht auf die aktuelle Denkerseite verlinkt wird.
	        continue;
	      } else { //Falls Vorname der gleiche ist, weiterspringen.
	        $current_p = explode(" ", $current);
	        if(strcmp($pieces[0], $current_p[0])==0){
	          continue;
	        }
	      }
	      
	      //Ganzer Name
	      array_push($links, "<a href='../denker/?denker=".$denkerid."'>".str_replace(" ","_",$denkername).$s."</a>".$i); 
	      array_push($words, $denkername.$s.$i);
	      
	      //Vorname
	      //array_push($links2, "<a href='../denker/?denker=".$denkerid."'>".$pieces[0].$s."</a>".$i);  
	      //array_push($words2, $pieces[0].$s.$i);
	      
	      //Nachname
	      $last = end($pieces);
	      array_push($links3, "<a href='../denker/?denker=".$denkerid."'>".$last.$s."</a>".$i); 
	      array_push($words3, $last.$s.$i);
	    }
	  }
	  
	  for ($n = 0; $n < count($result_orte); $n++){
	    
	    $ortname = $result_orte[$n][$name];
	    $ortid = $result_orte[$n][$id];
	    
	    if($current == $ortname){ //Überspringen, damit nicht auf die aktuelle Denkerseite verlinkt wird.
	      continue;
	    }
	    
	    array_push($links, "<a href='../orte/?ort=".$ortid."'>".$ortname."</a>".$i);
	    array_push($words, $ortname.$i);
	  }
	}

	$text = str_replace($words,$links,$text); //Replace $words with $links in $text.
	$text = str_replace($words2,$links2,$text); //Replace $words with $links in $text.
	$text = str_replace($words3,$links3,$text);
	$text = str_replace("_"," ",$text);
	return $text;
	}
}
