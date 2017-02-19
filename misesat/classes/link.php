<?php

function addlinks($text){ //$arrayin: words to be replaced. $category: Notwendig fuer Link. $type={denker, ort, ...}
require_once ('../config/config.php');
require_once ('General.php');
$general = new General();

//echo "<pre>I've thrown out: "; print_r(array_pop($arrayin)); echo '</pre><br>'; 

$sql_orte = $general->db_connection->prepare('SELECT id, name FROM orte ORDER BY id DESC');
$sql_orte->execute();
$result_orte = $sql_orte->fetchAll();

$sql_denker = $general->db_connection->prepare('SELECT id, name FROM denker ORDER BY id DESC');
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
      
      //echo("Aktuell: ".$current."<br>");
      
      if($current == $denkername){ //Überspringen, damit nicht auf die aktuelle Denkerseite verlinkt wird.
        continue;
      } else { //Falls Vorname der gleiche ist, weiterspringen.
        $current_p = explode(" ", $current);
        if(strcmp($pieces[0], $current_p[0])==0){
          //echo("PRENAME CONFLICT: ".$pieces[0]."<br>");
          continue;
        }
        //echo(".".$pieces[0]."==".$current_p[0]."."."<br>");
      }
      
      
      
      //Ganzer Name
      array_push($links, "<a href='../denker/?denker=".$denkerid."'>".str_replace(" ","_",$denkername).$s."</a>".$i); 
      array_push($words, $denkername.$s.$i);
      //Carl Menger => <a href="../denker/?denker=menger>Carl</a>
      
      //Vorname
      //array_push($links2, "<a href='../denker/?denker=".$denkerid."'>".$pieces[0].$s."</a>".$i);  
      //array_push($words2, $pieces[0].$s.$i);
      //Carl => <a href="../denker/?denker=menger>Carl</a>
      
      //Nachname
      $last = end($pieces);
      array_push($links3, "<a href='../denker/?denker=".$denkerid."'>".$last.$s."</a>".$i); 
      array_push($words3, $last.$s.$i);
      //Menger => <a href="../denker/?denker=menger>Menger</a>
      //echo($last."_____".$n."<br>");   
      
      //echo '<pre>'; print_r($pieces); echo '</pre>';
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
  
  
  
  
  
  //  echo '<pre>'; print_r($words2); echo '</pre><br>';
  //foreach($words2 as $m => $w){
  //    echo($w." => ".$links2[$m]."<br>");
  //}
  
  
}

$text = str_replace($words,$links,$text); //Replace $words with $links in $text.
//echo ("1: ".$text."<br>");
$text = str_replace($words2,$links2,$text); //Replace $words with $links in $text.
//echo ("3: ".$text."<br>");
$text = str_replace($words3,$links3,$text);
//echo ("3: ".$text."<br>");
$text = str_replace("_"," ",$text);
//echo ("3: ".$text."<br>");
//$text = preg_replace("/\w/","HALLO",$text);



return $text;
}

?>
