<?
require_once('../classes/Login.php');
include('_header.php'); 
$title="Mitgliederbereich";

?>
<!--Content-->
<div id="center">

  <div id="content">
    <a class="content" href="../index.php">Index &raquo;</a> <a class="content" href="#"> Medien</a>

    <div id="tabs-wrapper"></div>
    
<h2>Medien</h2>

<i>Wenn Sie sich für unsere Medien interessieren, tragen Sie sich hier völlig unverbindlich ein:</i><br><br>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform" style="text-aligna:center; paddinga: 10px ">
      <input class="inputfield" id="user_email" type="email" placeholder=" E-Mail Adresse" name="user_email" required /><br>
      <input class="inputbutton" type="submit" name="subscribe" value="Eintragen" />
  </form><br>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


    <div id="tabs-wrapper-lower"></div>
  </div>

    <? include "_side_not_in.php"; ?>
</div>

<? include "../views/_footer.php"; ?>