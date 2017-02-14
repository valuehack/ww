<?php
function addlinks($text, $arrayin, $category, $type){ //$arrayin: words to be replaced. $category: Notwendig fuer Link. $type={denker, ort, ...}
                
                //echo "<pre>I've thrown out: "; print_r(array_pop($arrayin)); echo '</pre><br>'; //Nur Roland Baader macht Probleme? Wieso?? (Nicht die letzte Stelle; Orte gehen alle.) TODO: Fix.
                
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
                    
					 
                            
                    
					for ($n = 0; $n < count($arrayin); $n++) { //Cycle through words to be replaced
                        
                        
                        $denkername = $arrayin[$n][$name];
                        $denkerid = $arrayin[$n][$id];
                        
                        if($type=="denker"){  
                            
                            
                            $pieces = explode(' ', $denkername);
                            $current = func_get_arg(4);
                        
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
                            
                            
                            foreach($zincluded as $s){
                                //Ganzer Name
                                array_push($links, "<a href='../".$category."/?".$type."=".$denkerid."'>".str_replace(" ","_",$denkername).$s."</a>".$i); 
                                array_push($words, $denkername.$s.$i);
                                //Carl Menger => <a href="../denker/?denker=menger>Carl</a>
                                //echo($denkername.$i." => "."<a href='../".$category."/?".$type."=".$arrayin[$n][$id]."'>".$denkername."</a>".$i."<br>".$denkername."<br><br>");

                                //Vorname
                                array_push($links2, "<a href='../".$category."/?".$type."=".$denkerid."'>".$pieces[0].$s."</a>".$i);  
                                array_push($words2, $pieces[0].$s.$i);
                                //Carl => <a href="../denker/?denker=menger>Carl</a>
                                //echo($pieces[0].$i." => "."<a href='../".$category."/?".$type."=".$arrayin[$n][$id]."'>".$pieces[0]."</a>".$i."<br>".$pieces[0]."_".end(array_values($pieces))."<br><br>");

                                //Nachname
                                $last = end($pieces);
                                array_push($links3, "<a href='../".$category."/?".$type."=".$denkerid."'>".$last.$s."</a>".$i); 
                                array_push($words3, $last.$s.$i);
                                //Menger => <a href="../denker/?denker=menger>Menger</a>
                                //echo(end(array_values($pieces)).$i." => "."<a href='../".$category."/?".$type."=".$arrayin[$n][$id]."'>".end(array_values($pieces))."</a>".$i."<br>".$pieces[0]."_".end(array_values($pieces))."<br><br>");
                                //echo($last."_____".$n."<br>");   

                                //echo '<pre>'; print_r($pieces); echo '</pre>';
                            }
                            
                        } else {
                            array_push($links, "<a href='../".$category."/?".$type."=".$denkerid."'>".$denkername."</a>".$i);
                            array_push($words, $denkername.$i);
                        } 
                        
                        
					}

                    //  echo '<pre>'; print_r($words2); echo '</pre><br>';
                    //foreach($words2 as $m => $w){
                    //    echo($w." => ".$links2[$m]."<br>");
                    //}
                    
                    
				}
                
                $text = str_replace($words,$links,$text); //Replace $words with $links in $text.
                    //echo ("1: ".$text."<br>");
                    if($type == "denker"){ //TODO: entfernen?
                        $text = str_replace($words2,$links2,$text); //Replace $words with $links in $text.
                        //echo ("3: ".$text."<br>");
                        $text = str_replace($words3,$links3,$text);
                        //echo ("3: ".$text."<br>");
                        $text = str_replace("_"," ",$text);
                        //echo ("3: ".$text."<br>");
                        //$text = preg_replace("/\w/","HALLO",$text);
                        
                }
            
                
				return $text;
			}

?>