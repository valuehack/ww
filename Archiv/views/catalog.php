<?php 
//Author: Bernhard Hegyi
//Content: Catalog of random items for test purposes of checkout process

//testing secureDownload
include_once("secdown/functions.php");
dbconnect();

require_once('classes/Login.php');
include('_header.php'); 
$title="Catalog";

?>

<div id="center">  
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a><a class="content" href="<?php echo $_SERVER['PHP_SELF']; ?>"> Catalog</a>
<div id="tabs-wrapper-lower"></div>

<h2>Catalog</h2>

<?php 
if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}

if(isset($_POST['add'])){

	$add_id = $_POST['add'];
	//$actual_quantity = $_SESSION['basket'][$add_id];
	$add_quantity = $_POST['quantity'];
	//$new_quantity = $add_quantity + $actual_quantity;
 	echo "<div style='text-align:center'><hr><i>You added ".$add_quantity." item(s) (ID: ".$add_id.") to your basket.</i> &nbsp <a href='basket.php'>Go to Basket</a><hr><br></div>";

 	$_SESSION['basket'][$add_id] = $add_quantity; 
}
//$user_id = $_SESSION['user_id'];
//print_r($_SESSION);
//echo "<br><br>";
?>

<b>Choose your events:</b><br><br>

<table style="width:100%;border-collapse: collapse">

	<tr>
    	<td style="width:60%"><b>Titel</b></td>
   		<td style="width:20%"><b>Quantity</b></td>
	</tr>

<?php
$sql = "SELECT * from termine WHERE end > NOW() order by start asc, id asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
	$event_id = $entry[id];
?>
   	<tr>
      	<td style="width:60%"><?php echo $event_id." <i>".ucfirst($entry[type])."</i> ".$entry[title];?></a>
        <td style="width:20%">
        	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          	<input type="hidden" name="add" value="<?php echo $event_id ?>" />
          	<select name="quantity">
  				<option value="1">1</option>
  				<option value="2">2</option>
  				<option value="3">3</option>
  				<option value="4">4</option>
  				<option value="5">5</option> 				
			</select> 
          	<input type="submit" value="Add to Basket"></form>
        </td>
    </tr>

<?php
}

echo "</table><br><br>";

          	//<input type="text" name="quantity" size="2" maxlength="2" placeholder="1">

?>
<b>Choose your books:</b><br><br>

<table style="width:100%;border-collapse: collapse">

	<tr>
    	<td style="width:60%"><b>Titel</b></td>
   		<td style="width:20%"><b>Quantity</b></td>
	</tr>

<?php
$sql = "SELECT * from termine WHERE type LIKE 'Buch' OR type LIKE 'Scholien' order by title asc, id asc";
$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

while($entry = mysql_fetch_array($result))
{
	$event_id = $entry[id];
?>
   	<tr>
      	<td style="width:60%"><?php echo $event_id." <i>".ucfirst($entry[type])."</i> ".$entry[title]." ".$entry[author]." <i>".$entry[format]."</i>";?></a>
        <td style="width:20%">
        	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          	<input type="hidden" name="add" value="<?php echo $event_id ?>" />
          	<select name="quantity">
  				<option value="1">1</option>
  				<option value="2">2</option>
  				<option value="3">3</option>
  				<option value="4">4</option>
  				<option value="5">5</option> 				
			</select> 
          	<input type="submit" value="Add to Basket"></form>
        </td>
    </tr>

<?php
}

echo "</table><br><br>";

          	//<input type="text" name="quantity" size="2" maxlength="2" placeholder="1">

//test Secure download ?>
<a class="scholien" href="<?php downloadurl('http://test.wertewirtschaft.net/secdown/sec_files/test.pdf','scholien_universitaet'); ?>" onclick="updateReferer(this.href);">03/14 Universit&auml;t (Test secureDownload)</a>
<br><br>

<?php
$zeit = date_default_timezone_get();
echo "Current timezone: ".$zeit."<br><br>";
?>


<!-- backlink -->
<a href="basket.php">Go to Basket</a>

</div>
<?php include('_side_in.php'); ?>
</div>
<?php include('_footer.php'); ?>