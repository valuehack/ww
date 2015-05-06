<?php 
//Author: Bernhard Hegyi

require_once('../classes/Login.php');
include('_header.php'); 
$title="Bibliothek";

?>

<div id="center">  
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a><a class="content" href="<?php echo $_SERVER['PHP_SELF']; ?>"> Bibliothek</a>
<div id="tabs-wrapper-lower"></div>

<h2>Bibliothek</h2>

<i>Wenn Sie sich für unsere Schriften interessieren, tragen Sie sich hier völlig unverbindlich ein:</i><br><br>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="registerform" style="text-aligna:center; paddinga: 10px ">
      <input class="inputfield" id="user_email" type="email" placeholder=" E-Mail Adresse" name="user_email" required /><br>
      <input class="inputbutton" type="submit" name="subscribe" value="Eintragen" />
  </form><br>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

</div>
<?php include('_side_in.php'); ?>
</div>
<?php include('_footer.php'); ?>