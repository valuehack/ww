<?php
require_once ('config/config.php');

require_once ('classes/General.php');
$general = new General();
$title = "Index";
?>
    <!DOCTYPE html >
    <html lang="de">

    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Verlag und Kompendium zur &Ouml;stereichischen Schule der &Ouml;konomik">
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="icon" type="image/png" href="favicon.png" sizes="32x32">

        <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="mstile-144x144.png">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--[if IE]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js" type="text/javascript"></script>
  <![endif]-->

        <link rel="stylesheet" href="style/normalize.css">
        <link rel="stylesheet" href="style/style.css">
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,300|EB+Garamond' rel='stylesheet' type='text/css'>

        <title>
            <?=$title?> | Mises Austria</title>

    </head>

    <body>
        <!-- Begin Header-->
        <header id="header">
            <div class="logo">
                <a href="index.php"><img src="style/ma_logo_text.png" alt=""></a>
            </div>
            <div class="nav-trigger">
                <div class="nav-trigger__icon">
                    <a href="#" onclick="showNav();return false;"><img src="style/navicon.svg" alt="Menu" title="Menu"></a>
                </div>
            </div>
            <div id="nav">
                <div class="navi">
                    <ul>
                        <li><a href="verlag/" onclick="showNav();">Verlag</a></li>
                        <!--<li><a href="begriffe/" onclick="showNav();">Begriffe</a></li>-->
                        <li><a href="denker/" onclick="showNav();">Denker</a></li>
                        <li><a href="literatur/" onclick="showNav();">Literatur</a></li>
                        <!--<li><a href="dokumente/" onclick="showNav();">Dokumente</a></li>-->
                        <li><a href="orte/" onclick="showNav();">Orte</a></li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- End Header -->
        <div id="content">

        


                <div class="container">

                    <div class="row">
                        <div class="two-thirds column">
                            <div class="row style-space--bottom">
                                <h1>Willkommen!</h1>
                                <p>Endlich ist das Mises-Institut nach Österreich heimgekehrt. Auf <b>mises.at</b> entsteht die größte deutschsprachige Ressource zur Österreichischen Schule der Nationalökonomie. Schon seit einiger Zeit hat sich <b>mises.at</b> als Fachverlag für Werke der Österreichischen Schule einen Namen gemacht. Dank der akademischen Unterstützung der wichtigsten heutigen Vertreter der Österreichischen Schule kann <b>mises.at</b> bei allen Publikationen höchsten wissenschaftlichen Standards entsprechen. <b>mises.at</b> ist ein ehrenamtliches Projekt ohne Gewinnabsicht und sucht Unterstützung zur Durchführung von Fachübersetzungen auf höchstem Niveau. Kontaktieren Sie uns unter <a href="mailto:info@mises.at">info@mises.at</a></p>
                            </div>
                            <div>

                                <h3>Neuerscheinungen</h3>
                                <div class="row hiderow">
                                    <?
              $program_query = $general->db_connection->prepare("SELECT * FROM verlagsprogramm ORDER by n desc");
              $program_query->execute();
              $program = $program_query->fetchAll();	
              
                $n = 0;
                                    
              foreach ($program as $key => $item) {
                $img = 'cover/'.$item['id'].'.jpg';
                $link = $item['link'];
                $authors = $item['author'];
                $author_links = "";
                $author_list = explode(", ", $authors);
                
                foreach ($author_list as $key => $author_id) {
                  $author_info = $general->getInfo('denker',$author_id);
                  if (count($author_list) > 1 && count($author_list) != $key+1) {
                    if ($author_info == FALSE) {
                      $author_links = $author_links.$author_id.', ';
                    }
                    else {
                      $author_links = $author_links.'<a href="denker/index.php?denker='.$author_info->id.'">'.$author_info->name.'</a>, ';
                    }
                  }
                  else {
                    if ($author_info == FALSE) {
                      $author_links = $author_links.$author_id;
                    }
                    else { 
                      $author_links = $author_links.'<a href="denker/index.php?denker='.$author_info->id.'">'.$author_info->name.'</a>';
                    }
                  }
                }
              ?>


                                        <div class="one-half column hiderow">
                                            <div class="card">
                                                <div id="cover_<?=$item['id']?>" class="card-head-2 card-head__overlay">
                                                    <style>
                                                        #cover_<?=$item['id']?> {
                                                            background-image: url(verlag/<?=$img?>);
                                                            background-position: 50% 20%;
                                                            background-size: cover;
                                                        }
                                                    </style>
                                                </div>
                                                <div class="card-content">
                                                    <h5> <a class="title" href=<?=$link?>> <?=$item['title']?></a></h5>
                                                    <p class="text-insert text--raleway">
                                                        <?=$author_links?>
                                                    </p>
                                                    <p>
                                                        <?=$item['desc']?>
                                                    </p>
                                                </div>
                                                <div class="card-link h-right">
                                                    <a href=<?=$link?>>Zum Buch</a>
                                                </div>

                                            </div>
                                        </div>


                                        <? 
                                                if($n>=1){
                                                    break;
                                                }
                                                $n++;
                                            } 
                                        ?>
                                </div>
                            </div>
                        </div>


                        <div class="one-third column">

                            <div class="card" id="tagesbezogenes">
                                <div class="card-content">
                                    <?
                
                $sql_denker = $general->db_connection->prepare('SELECT n, id, name, geburt, tod FROM denker ORDER BY n DESC');
                $sql_denker->execute();
                $result_denker = $sql_denker->fetchAll();
                
                $sql_lit = $general->db_connection->prepare('SELECT * FROM buecher ORDER BY n DESC');
                $sql_lit->execute();
                $result_lit = $sql_lit->fetchAll();
                
                $sql_art = $general->db_connection->prepare('SELECT * FROM artikel ORDER BY n DESC');
                $sql_art->execute();
                $result_art = $sql_art->fetchAll();
                
                $tage = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
                $monatsnamen = array(
                  1=>"Januar",
                  2=>"Februar",
                  3=>"März",
                  4=>"April",
                  5=>"Mai",
                  6=>"Juni",
                  7=>"Juli",
                  8=>"August",
                  9=>"September",
                  10=>"Oktober",
                  11=>"November",
                  12=>"Dezember");
                  $tag = date("w");
                  $monat = date("n");
                  $datum = (date("m")."-".date("d"));
                  $fittingday = false;
                  //$datum = ("02-23");
                  ?>
                                        <h3><?=$tage[$tag]?>, der <?=date("j")?>. <?=$monatsnamen[$monat]?></h3>
                                        <p class="card-bottom">
                                            <?
                  
                  foreach ($result_denker as $key => $item) {
                    if ($datum==(substr($item['geburt'],5,9))) {
                      $yeardif = (date("Y")-substr($item['geburt'],0,4));
                      echo("Heute vor ".$yeardif." Jahren ist <a href='denker/?denker=".$item['id']."'>".$item['name']."</a> geboren!<br>");
                      $fittingday = true;
                    } else if ($datum==(substr($item['tod'],5,9))) {
                      $yeardif = (date("Y")-substr($item['tod'],0,4));
                      echo("Heute vor ".$yeardif." Jahren ist <a href='denker/?denker=".$item['id']."'>".$item['name']."</a> gestorben!<br>");
                      $fittingday = true;
                    } 
                    
                    //echo($datum." - ".substr($item['geburt'],5,9)."<br>");  
                  }
                  if ($fittingday == false) {
                    echo("<script>document.getElementById('tagesbezogenes').style.display = 'none';</script>");
                  }
                                            
                  
                  ?></p>
                                </div>
                            </div>
                            
                            <h5 class="style-bl--red h-extra-space__bottom h-extra-space__top">Neuste Beiträge</h5>
                                <div class="">
                                
                                 
                                <div class="">
                                 <!--h5 class="h-centered">Denker</h5-->
                                 
                                
                                  <?
                                    for($m=0;$m<=3;$m++){
                                        $denk = $result_denker[$m];
                                        
                                        $id = $denk['id'];
                                        $name = $denk['name'];
                                        
                                        $img_url = 'denker/'.$id.'.jpg';
                                        if (@getimagesize($img_url)) {
                                                $img = $img_url;
                                        } else {
                                                $img = "denker/ma_logo.jpg";
                                        }
                                        
                                        if (($m % 2) === 0) {
                                            echo '<div class="row">';
                                        } 
                                    
                                    ?>
                                    <div class="one-half column">
                                        <div class="card">
                                            <a href="denker/?denker=<?=$id?>">	
                                                <div class="card-head <? if ($img != '') echo 'card-head__overlay';?>">
                                                <? 
                                                    if ($img != '') echo '<img src="'.$img.'" alt="'.$name.'">';
                                                ?>
                                                </div>
                                            </a>

                                            <div>
                                                <div class="text--raleway h-centered card-text"> <a href="denker/?denker=<?=$id?>"><?=$name?></a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                     
                                        if (($m + 1) % 2 === 0) {
                                            echo '</div>';
                                        }
                                    }
                                  ?>
                                  
                                  <br>
                                  
                                </div>
                                <div class="card-link h-right">
                                    <a href="#">Alle Denker</a>
                                </div>
                                <div class="card">
                                  <h2 class="card-content h-centered">Literatur</h2>
                                  <div class="container h-extra-space__top list">
                              				<ul class="list--none">
                                  <?
                                  
                                  $buecher_list = array();
                                  $artikel_list = array();
                                  
                                  for($m=0;$m<=1;$m++){
                                    
                                    $buch = $result_lit[$m];
                                    $titel = $buch['titel'];
                                    $id = $buch['id'];
                                    $autor = $buch['autor'];
                                    $link = $buch['link'];
                                    $quelle = $buch['quelle'];
                                    $jahr = $buch['jahr'];
                                    $type = "Buch";
                                    
                                    $sql_author = $general->db_connection->prepare('SELECT id FROM denker WHERE name = :name');
                                		$sql_author->bindValue(':name', $autor, PDO::PARAM_STR);
                              		  $sql_author->execute();
                              		  $author_id = $sql_author->fetchObject();
                              
                                    
                                    if ($quelle == "PDF") {
                                        array_push($buecher_list, ("<li>".$type.": <a href='./literatur/".$type."/".$id.".pdf' target='_blank'>".$titel." <br><br><a href='./denker/?denker=".$author_id->id."'><div class='itm-table_sec h-right'>".$autor."</div></a>"));
                                		}
                                		else if (empty($quelle)) {
                                        array_push($buecher_list, ("<li>".$titel." <br><br><a href='./denker/?denker=".$author_id->id."'><div class='itm-table_sec h-right'>".$autor."</div></a>"));
                                		}
                                		else {
                                        array_push($buecher_list, ("<li><a href=".$link." target='_blank'>".$titel." <br><br><a href='./denker/?denker=".$author_id->id."'><div class='itm-table_sec h-right'>".$autor."</div></a>"));
                                		}
                                    
                                    $artikel = $result_art[$m];
                                    $titel = $artikel['titel'];
                                    $id = $artikel['id'];
                                    $autor = $artikel['autor'];
                                    $link = $artikel['link'];
                                    $quelle = $artikel['quelle'];
                                    $jahr = $artikel['jahr'];
                                    $type = "Artikel";
                                    
                                    $sql_author = $general->db_connection->prepare('SELECT id FROM denker WHERE name = :name');
                                		$sql_author->bindValue(':name', $autor, PDO::PARAM_STR);
                              		  $sql_author->execute();
                              		  $author_id = $sql_author->fetchObject();
                              
                                    
                                    if ($quelle == "PDF") {
                                        array_push($artikel_list, ("<li>".$type.": <a href='./literatur/".$type."/".$id.".pdf' target='_blank'>".$titel." <br><br><a href='./denker/?denker=".$author_id->id."'><div class='itm-table_sec h-right'>".$autor."</div></a>"));
                                		}
                                		else if (empty($quelle)) {
                                        array_push($artikel_list, ("<li>".$titel." <br><br><a href='./denker/?denker=".$author_id->id."'><div class='itm-table_sec h-right'>".$autor."</div></a>"));
                                		}
                                		else {
                                        array_push($artikel_list, ("<li><a href=".$link." target='_blank'>".$titel." <br><br><a href='./denker/?denker=".$author_id->id."'><div class='itm-table_sec h-right'>".$autor."</div></a>"));
                                		}
                                    
                                  }
                                  
                                  foreach ($buecher_list as $m) {
                                    echo $m;
                                  }
                                  foreach ($artikel_list as $m) {
                                    echo $m;
                                  }
                                  
                                  ?>
                                </ul>
                              </div>
                            </div>
                                <div class="card-link h-extra-space__top h-right">
                                    <a href="./literatur">Alle Literatur</a>
                                </div>
                                
                                </div>

                           
                            <div>
                                <h5 class="style-bl--red h-extra-space__bottom h-extra-space__top">Aktuelle Projekte</h5>
                                <div class="card">
                                <div class="card-content">
                                  <h3 class="h-centered">Human Action</h3>
                                   <img class="container h-extra-space__top h-extra-space__bottom sidebar-img" src="literatur/HumanAction.png">
                                    <p>Wir arbeiten momentan an einer kompletten Übersetzung von <a href="denker/?denker=mises">Ludwig von Mises</a> Hauptwerk, Human Action, ins Deutsche. Für diesen immensen Aufwand begrüßen wir jede kleine Unterstützung.</p>
                                    <!--img class="container h-extra-space__bottom sidebar-img" src="literatur/HumanAction.png"-->
                                    
                                    <div class="h-centered h-extra-space__top">
                                        <a class="btn-link h-block button-text" href="verlag/impressum.php">Kontakt</a>
                                    </div>
                                    <br><br>

                                </div>
                                </div>
                                
                            </div>

                            <!--div class="card">
                                <div class="card-content">
                                    <h3>Aktuelle Projekte</h3>
                                    <p>Wir arbeiten momentan an einer kompletten Übersetzung von <a href="denker/?denker=mises">Ludwig von Mises</a> Hauptwerk, Human Action, ins Deutsche. Für diesen immensen Aufwand begrüßen wir jede kleine Unterstützung.</p>
                                    <img class="container" src="literatur/HumanAction.png">

                                </div>
                                <div class="card-link h-right">
                                    <a href="#">Jetzt spenden!</a>
                                </div>
                            </div-->
                            
                            
                            
                        </div>
                    </div>
                </div>

        </div>


        <!--Begin Footer-->
        <footer id="footer">
            <p>&copy; mises.at 2015-2016 &mdash; <a href="verlag/impressum.php">Impressum</a> &mdash; <a href="verlag/index.php">&Uuml;ber Uns</a></p>
        </footer>
        <!--End Footer-->
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/general.js"></script>
    <script src="js/sorttable.js"></script>

    </html>
