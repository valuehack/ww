<?php
require_once (__DIR__."/config/header1.inc.php");
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
                        <li><a href="projekte/" onclick="showNav();">Projekte</a></li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- End Header -->
        <div id="content">

<?php
				$inhalt = $general->getInfo('statische_inhalte', 'startseite');
				$infotext = $inhalt->info;
?>			
			
                <div class="container">

                    <div class="row">
                        <div class="two-thirds column">
                            <div class="row style-space--bottom">
                                <h1>Willkommen!</h1>
                                <p><?=$infotext?></p>
                            </div>
                            <div>

                                <h3>Neuerscheinungen</h3>
                                <div class="row hiderow">
                                    <?
                                    $program = $general->getItemList('verlagsprogramm', 'n', 'desc');
              
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
                                                        <?=$general->addlinks($item['desc'], $item['title']);?>
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
                
                
                $result_denker = $general->getItemList('denker', 'n', 'desc');
                $result_lit = $general->getItemList('buecher', 'n', 'desc');
                $result_art = $general->getItemList('artikel', 'n', 'desc');
                
                $tage = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
                $monatsnamen = array(
                  1=>"Januar",
                  2=>"Februar",
                  3=>"M&auml;rz",
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
                      echo("Heute vor ".$yeardif." Jahren ist <a href='denker/?denker=".$item['id']."'>".$item['name']."</a> geboren.<br>");
                      $fittingday = true;
                    } else if ($datum==(substr($item['tod'],5,9))) {
                      $yeardif = (date("Y")-substr($item['tod'],0,4));
                      echo("Heute vor ".$yeardif." Jahren ist <a href='denker/?denker=".$item['id']."'>".$item['name']."</a> gestorben.<br>");
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
                            
                            <h5 class="style-bl--red h-extra-space__bottom h-extra-space__top">Neueste Eintr&auml;ge</h5>
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
                                    <a href="./denker">Alle Denker</a>
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
                                    
                                    $author_id = $general->getSpecialObject('id', 'denker', 'name', $autor);
                              
                                    
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
                                    
                                    $author_id = $general->getSpecialObject('id', 'denker', 'name', $autor);
                                    
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
                                    <a href="./literatur">Gesamte Literatur</a>
                                </div>
                                
                                </div>

                           
                            <div>
                                <h5 class="style-bl--red h-extra-space__bottom h-extra-space__top">Aktuelle Projekte</h5>
                                <div class="card">
                                <div class="card-content">
                                  <h3 class="h-centered">Übersetzung: Man, Economy and State</h3>
                                  <a class="link" href="../denker/?denker=rothbard"><h6 class="h-left" style="text-align: left;">Murray Rothbard</h6></a>
                                   <!--mg class="container h-extra-space__top h-extra-space__bottom sidebar-img" src="literatur/HumanAction.png"-->
                                    <p>Das umfassendste Lehrbuch zur Österreichischen Schule und Lebenswerk von Murray N. Rothbard liegt noch immer nicht in deutscher Fassung vor. Die Österreichische Schule bietet eine wichtige Grundlage realistischer Ökonomie, auch wenn Sie heute meist in einer vulgärpolitischen Zerrform rezipiert wird. Rothbard ist durch seine Radikalität politisch schwer zu missbrauchen und umso grundlegender für Didaktik und wissenschaftliche Neuansätze. Wir haben schon erste Vorarbeiten durchgeführt, doch der Übersetzungsaufwand ist sehr groß. Diese Arbeit ist sehr schwierig und darf nicht Hobbyübersetzern überlassen werden. Ohne wissenschaftliche Präzision wäre das Ergebnis unbrauchbar und würde die akademische Rezeption der Österreichischen Schule verunmöglichen. Alle Unterstützer werden (auf Wunsch) freilich im Buch vermerkt.</p>
                                    <!--img class="container h-extra-space__bottom sidebar-img" src="literatur/HumanAction.png"-->
                                    
                                    <!--div class="h-centered h-extra-space__top">
                                        <a class="btn-link h-block button-text" href="mailto:&#105;nf&#111;&#064;&#109;&#105;se&#115;.&#97;&#116;">Kontakt</a>
                                    </div-->
                                    <div class="">
                            					<progress value="22.2" max="100"></progress>
                            						<table class="progresstable">
                            							<tr class="">
                            								<td class="">
                            						<p class=""><b>22.2%</b> finanziert</p></td><td class=""><p> <b>2220€</b> beigetragen</p></td>
                            							</tr>
                            						</table>
                            					<? if($prozent==100){echo "<br>";} else {?>
                            					<div class="h-centered">
                            					<a class="btn-link h-block button-text" href="mailto:&#105;nf&#111;&#064;&#109;&#105;se&#115;.&#97;&#116;">Kontakt</a><br><br><br><br>
                                    </div>
                            					<?}?>
                            				</div>


                                </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>

        </div>
<?php include (__DIR__."/page/footer.inc.php"); ?>
