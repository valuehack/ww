<!--Sidebar-->
<!--Sidebar-->

<?
    $ok2 = $_POST['ok2'];
?>

<div id="sidebar">
<div style="">
  <div style="float: lefta;widtha:500px;">
    <!-- <p style="text-aligna:center;"> REGISTER </p> -->

<h6>Wenn Sie die Arbeit des Instituts f&uumlr Wertewirtschaft anspricht, tragen Sie sich hier v&oumlllig unverbindlich ein.</h6>
<h4>Selbstverst&aumlndlich geben wir Ihre Daten nicht weiter. Wir senden Ihnen ca. einmal im Monat aktuelle Hinweise zu Veranstaltungen und Publikationen.</h4>

<!--     <form style="text-align:center; padding: 10px " class="layout_form cr_form cr_font" action="http://63147.seu1.cleverreach.com/f/63147-127316/wcs/" method="post" target="_blank">
          
        <label for="text2591464" class="itemname">Email</label>
        <input id="text2591464" placeholder="Email Address" name="email" value="" type="text"/>
        <br><button type="submit" class="cr_button">Subscribe</button>

    </form> -->

      <!-- fancy form that is connected to script.js -->
      <form method="post" action="index.php" name="registerform" style="text-aligna:center; paddinga: 10px ">
        <input class="inputfield" id="keyword" type="email" placeholder=" E-Mail-Adresse" name="user_email" autocomplete="off" required /><br>
        <input class="inputfield" id="user_password" type="password" name="user_password" placeholder=" Passwort" autocomplete="off"/><br>
        <input class="inputbutton" id="inputbutton" type="submit" name="fancy_ajax_form_submit" value="Eintragen" />
      </form>

<!--       <form method="post" action="index.php" name="registerform" style="text-aligna:center; paddinga: 10px ">
        <input class="inputfield" id="user_email" type="email" placeholder=" E-Mail-Adresse" name="user_email" required /><br>
        <input class="inputbutton" type="submit" name="subscribe" value="Eintragen" />
      </form> -->

  </div>

  <div style="float: righta;widtha:500px;">
    <!-- <p style="text-aligna:center;"> Mitgliederbereich </p> -->
    <!-- <h5>Mitgliederbereich</h5> -->
<!--     <form method="post" action="index.php" name="loginform" style="text-aligna:center;">
        <label for="user_email"><?php# echo WORDING_LOGIN; ?></label>
        <input class="inputfield" id="user_email" type="text" name="user_email" placeholder=" E-Mail-Adresse" required /><br>
        <label for="user_password"><?php #echo WORDING_PASSWORD; ?></label>
        <input class="inputfield" id="user_password" type="password" name="user_password" placeholder=" Passwort" autocomplete="off" required /><br>
        <input class="inputbutton" type="submit" name="login" value="Anmelden" />
    </form> -->
<!-- <a href="register.php"><?php #echo WORDING_REGISTER_NEW_ACCOUNT; ?></a> -->
<p style="text-align:centera;"><a href="/password_reset.php"><?php echo WORDING_FORGOT_MY_PASSWORD; ?></a></p>


          <h6><a href="http://www.wertewirtschaft.org/institut/mitglied.php" alt="">Wir nehmen kein Geld von Staat, Banken, Konzernen und Lobbies. Helfen Sie uns, unabh&auml;ngig zu bleiben und nutzen Sie die Vorteile einer <u>Mitgliedschaft.</u></a></h6>

</div></div></div>
        <div id="sidebar">       
          <? if ($title=="Mitgliederbereich" or $title=="Tonaufnahmen" or $title=="Videoaufnahmen" or $title=="Scholienarchiv") {}
              else {
		  ?>	
          <!-- <h5><a href="http://www.wertewirtschaft.org/mitglied/" alt="">Mitgliederbereich</a></h5> -->


<!-- SIGN IN --> 

<!-- <table width="100%"><tr><td align="center"><a class="amd" href="http://www.wertewirtschaft.org/mitglied/" alt=""><input class="inputbutton" type="submit" value="Anmelden&nbsp;&nbsp;&nbsp;&nbsp;"></a></td></tr></table> -->



         <!-- <form action="" method="post" name="mitglied">
          	<input type="hidden" name="ok2" value="1">
          <table width="300">
           <tbody align="left">
           <tr>
            <td class="input"><img src="http://wertewirtschaft.org/style/arrow.png" alt="">&nbsp;&nbsp;Benutzer</td>
            <td><input id="" name="user" value="<?$user?>" type="text" class="inputfield" /></td>
           </tr>
           <tr>
            <td class="input"><img src="http://wertewirtschaft.org/style/arrow.png" alt="">&nbsp;&nbsp;Passwort</td>
            <td><input id="" name="pw" value="<?$pw?>" type="password" class="inputfield" /></td>
           </tr>
           <tr>
            <td>&nbsp;</td>
            <td align="center"><input class="inputbutton" type="submit" value="Anmelden&nbsp;&nbsp;&nbsp;&nbsp;"></td>
           </tr>
           </tbody>
          </table>
         </form>-->
          	
          	<? 
          	  //$ok = $_POST['ok'];
              //$user = $_POST['user'];
              //$pw = $_POST['pw'];
			  
			  //if ($ok2) {
				//echo "<meta http-equiv='refresh' content='1; url=http://$user:$pw@www.wertewirtschaft.org/mitglied/'>";
			  //}

			 } 
          	?>


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
