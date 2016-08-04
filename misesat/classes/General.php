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
                $this->db_connection = new PDO('mysql:host='. DB_MISESAT_HOST .';dbname='. DB_MISESAT_NAME . ';charset=latin1', DB_MISESAT_USER, DB_MISESAT_PASS);
                							
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
	
	public function getItemList($table, $orderby, $order) {
						
		$list_query = $this->db_connection->prepare('SELECT * FROM '.$table.' ORDER by '.$orderby.' '.$order.'');
		$list_query->execute();
    	
    	return $list_query->fetchAll();
	}
	
	public function substr_close_tags($code, $limit = 300) {
		# Creates a substr out of a html string where html end tags are closed		
		
    	if ( strlen($code) <= $limit )
    	{
      	  return $code;
   		}

    	$html = substr($code, 0, $limit);
    	preg_match_all ( "#<([a-zA-Z]+)#", $html, $result );

    	foreach($result[1] AS $key => $value)
    	{
        	if ( strtolower($value) == 'br' )
        	{
            	unset($result[1][$key]);
        	}
    	}
    	$openedtags = $result[1];

    	preg_match_all ( "#</([a-zA-Z]+)>#iU", $html, $result );
    	$closedtags = $result[1];

    	foreach($closedtags AS $key => $value)
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
}