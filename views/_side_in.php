<!-- Sidebar IN -->

<div id="sidebar">

<?php

@$con=mysql_connect(DB_HOST,DB_USER,DB_PASS) or die ("cannot connect to MySQL");
mysql_select_db(DB_NAME);

$user_id = $_SESSION['user_id'];

#echo $user_email;

if (!isset($user_id)) echo ""; 
else
{
$query = "SELECT * from mitgliederExt WHERE `user_id` LIKE '%$user_id%' ";

$result = mysql_query($query) or die("Failed Query of " . $query. mysql_error());

echo "You are logged in as:<br>";

while ($entry = mysql_fetch_array($result))
{
  #var_dump( $entry );

    echo " ". $entry[user_email]."<br>";
    echo "Account expiry: ".$entry[Ablauf]."<br>";
    echo "Membership: ".$entry[Mitgliedschaft]."<br>";
    echo "Credits left: ".$entry[credits_left]."<br>";
    // echo "User id: ".$entry[user_id]."<br>";

}

?>

<div>

    <br>
    <a href="/blog/">Scholien (Blog)</a>
    <br>
    <a href="/salon/">Salon</a>
    <br>
    <a href="/seminare/">Seminare</a>
    <br>
    <a href="/schriften/">Schriften</a>
    <br>
    <a href="/mitglied/">Medien</a>
    <br>
    <a href="/spenden/">Spenden</a>
    <br>
    <a href="/bibliothek/">Bibliothek</a>
    <br><br>
    <a href="/catalog.php">//Catalog</a>
    <br>
    <a href="/basket.php">Basket</a>
    <br><br> 
    <a href="/edit.php">Profil</a>
    <br>
    <a href="/upgrade.php">Upgrade</a>
    <br><br>
    <a href="/index.php?logout"><?php echo WORDING_LOGOUT; ?></a>

</div>
          
<?php } ?> 
    <!-- <div id="tabs-wrapper-sidebar"></div> -->


	  <div id="tabs-wrapper-sidebar"></div>
	  <div id="tabs-wrapper-sidebar"><h5>N&auml;chste Termine</h5><br>
            <?
             $current_dateline=strtotime(date("Y-m-d"));
	             $to_dateline=$current_dateline+(14*86400);
                $sql="SELECT * from termine WHERE (UNIX_TIMESTAMP(start)>=$current_dateline) and status>0 and spots_sold<spots order by start asc, id asc limit 10";
            $result = mysql_query($sql);
             while($entry = mysql_fetch_array($result))
              {
               $found=1;
               if (strpos($entry[anmeldung],"http") !== false) echo "<a class=\"termine\" href=\"".$entry[anmeldung]."\">";
               else
                {
	            echo "<a class=\"termine\" href=\"http://www.wertewirtschaft.org/";
                if ($entry[url]) echo $entry[url];
                else echo "akademie/?id=$entry[id]&q=".preg_replace('/ /','+',$entry[title]);
                echo "\">";
                }
              echo date("d.m.Y",strtotime($entry[start]));
              if (strtotime($entry[end])>(strtotime($entry[start])+86400)) echo "-".date("d.m.Y",strtotime($entry[end]));
              echo ": <i>".ucfirst($entry[type])."</i> $entry[title]</a><br><br>";
              }
            ?>
          </div>      
	  <div align="center"><a href="https://www.facebook.com/wertewirtschaft" target="_blank"><img style="margin-left:79px;" src="/style/gfx/facebook_logo.png" alt="Wertewirtschaft auf Facebook" title="Das Institut f&uuml;r Wertewirtschaft auf Facebook"></a></div>
		<div align="center"><a href="https://www.twitter.com/wertewirtschaft" target="_blank"><img style="margin-left:79px; margin-top:10px; border-radius: 15px;" src="/style/gfx/twitter_logo.png" alt="Wertewirtschaft auf Twitter" title="Das Institut f&uuml;r Wertewirtschaft auf Twitter"></a></div>
    <div align="center"><a href="https://www.instagram.com/wertewirtschaft" target="_blank"><img style="margin-left:130px; margin-top:10px;" src="/style/gfx/instagram_logo.png" alt="Wertewirtschaft auf Instagram" title="Das Institut f&uuml;r Wertewirtschaft auf Instagram"></a></div>
