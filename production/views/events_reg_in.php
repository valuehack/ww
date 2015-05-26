
<script type="text/javascript">

var checkoutSum = 0;

function setCredits(creditsLeft)
{
  checkoutSum = creditsLeft; 
}

function toggleMe(id)
{
    if(document.getElementById(id).style.display == 'none')
    {
        document.getElementById(id).style.display = '';
    }
    else
    {
        document.getElementById(id).style.display = 'none';
    }
}

function PriceSum (checkbox, price) 
{
  if (checkbox.checked) 
  {
      // alert ("The check box is checked.");
      checkoutSum -= price;
      document.getElementById("demo").innerHTML = checkoutSum;
  }
  else 
  {
      checkoutSum += price;
      document.getElementById("demo").innerHTML = checkoutSum;
  }
}

function displayCredits()
{
  document.getElementById("demo").innerHTML = checkoutSum;
}

// window.onload = displayZero;

</script>


<?php 
  include ("_db.php"); 
  $user_id = $_SESSION['user_id'];
  $credits_sql="SELECT * from mitgliederExt WHERE user_id='$user_id'";
  $credits_result = mysql_query($credits_sql) or die("Failed Query of " . $credits_sql. " - ". mysql_error());
  $credits_entry = mysql_fetch_array($credits_result);
  $_SESSION['credits_left'] = $credits_entry[credits_left];

?>



<?php

// include "header1.inc.php";

include ("_header.php"); 
$title="Akademie";

// if ($id) echo "This is id: ".$id;
// echo "here: ".$_GET["id"];

if ($id = $_GET["id"])
{
  $sql="SELECT * from termine WHERE id='$id'";
  $result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
  $entry3 = mysql_fetch_array($result);
  $title=$entry3[title];
  $avail=$entry3[spots]-$entry3[spots_sold];
  $gold=$entry3[gold];
  $gold2=$entry3[gold2];
  $adresse=$entry3[adresse];
  $date=strftime("%d.%m.%Y", strtotime($entry3[start]));
  $date2= substr($entry3[start],0,10);
}

// Setting session variable needed to pass info to JS




?>

<!--Content-->
<div id="center">
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a> <a class="content" href="index.php">Akademie</a>
<div id="tabs-wrapper-lower"></div>

<h3>Termine Anmeldung</h3>  

<div id="tabs-wrapper-sidebar"></div>
<div id="tabs-wrapper-lower" style="margin-top:10px;">

<?php 

// PHP FUNCTIONS:

    function ifChecked($event_id, $user_id)
    {

        $check_query = "SELECT * from registration WHERE `event_id` LIKE '%$event_id%' AND `user_id` LIKE '%$user_id%' ";

        $check_result = mysql_query($check_query) or die("Failed Query of " . $check_query. mysql_error());

        if(mysql_num_rows($check_result) == 0) 
        {
         return false;
        } 
        else 
        {
          return true;
        }
    }

#ifDisabled
#check if event is old and should be disabled. 
#returns "disabled" if old
#checks both for event age and spaces left
#as those are the only scenarios when event should be disabled

    function ifDisabled($event_id, $ifCheck)
    {

		// something is strange in here with multiple queries. try to solve it when time is right

        $disabled_query = "SELECT * from termine WHERE id LIKE '%$event_id%' AND start <= DATE_ADD(NOW(),INTERVAL 1 week)";
        $disabled_result = mysql_query($disabled_query) or die("Failed Query of " . $disabled_query. mysql_error());

        $space_query = "SELECT * from termine WHERE id LIKE '%$event_id%'";
        $space_result = mysql_query($space_query) or die("Failed Query of " . $space_query. mysql_error());
        $space = mysql_fetch_array($space_result);

        $spaces_left = $space[spots] - $space[spots_sold];


        if((mysql_num_rows($disabled_result) != 0)) 
        {
         return true;
        } 

        if (($spaces_left == 0) and $ifCheck) return false;
        else 
          if ($spaces_left <= 0)
              {
                return true;
              }

        return false;

// if ($ifCheck) echo "LOOK HERE ".$event_id    ;

// 

        // else if ($spaces_left <= 0)
        // {
        //   return true;
        // } else if ($ifCheck)return false;
        // else return true;
  



        // if(mysql_num_rows($disabled_result) != 0) 
        // {
        //  return true;
        // } 
        // else {
        //   return false;
        // }



    }

		$sql = "SELECT * from termine WHERE end > NOW() order by start asc, id asc";
		$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());

?>

<!-- HTML -->
<!-- Optional: There are currently no events, please register to be informed about it... -->

In order to register for events, please click on the checkbox next to the event you would like to attend and then click "Select events" button at the bottom of the form. You might register to multiple events at the same time if you have sufficient credits. You will receive email confirmation upon successful registration/ cancelation. 
<hr>
<br>
<br>
<div style="text-align:center;font-size:150%;"><strong>Event registration form</strong></div>
<hr>
<br>
<form action="index.php" method="post">

<table style="width:100%;border-collapse: collapse">

<tr>
      <td style="width:5%"> </td>
      <td style="width:15%"><i>Datum</i></td>
      <td style="width:60%"><i>Titel</i></td>
      <!-- <td style="width:7%"><i>Ref</i></td> -->
      <td style="width:13%"><i>Places left</i></td>
</tr>


<!-- END HTML -->
<!--  -->


<?php


  while($entry = mysql_fetch_array($result))
  {

	$event_id = $entry[id];
	$checked = ifChecked($event_id, $user_id);
	$disabled = ifDisabled($event_id, $checked);
   
  $checkedStatus = "";
	$disabledStatus = "";

	if ($checked) $checkedStatus = "checked";
	if ($disabled) $disabledStatus = 'disabled="disabled"'; 
   ?>


    <tr>
      <td style="width:5%">
      		<input type="checkbox" onclick="PriceSum (this,<?php echo $entry[event_price] ?>)" name="events[]" value="<?php echo $event_id ?>" <?php echo $checkedStatus." ". $disabledStatus; ?> /><br>
      		<?php 
   			if ( $checked and $disabled ) echo '<input type="hidden" name="events[]" value="'.$event_id.'"/>';
				?>
      </td>
      <td style="width:15%"><?php echo date('d.m', strtotime($entry[start]))."-".date('d.m', strtotime($entry[end]));?></td>
      <td style="width:60%"> <a href="/akademie/?id=<?php echo $entry[id]; ?>"><?php echo "<i>".ucfirst($entry[type])."</i> ".$entry[title];?></a>
<a style="font-size: 120%;" href="javascript:toggleMe('<?php echo $event_id; ?>')">+</a><br></td>
      <!-- <td style="width:7%"><?php echo $entry[referent] ?></td> -->
      <td style="width:13%"><?php echo $entry[spots]-$entry[spots_sold] ?></td>
    
     </tr>


  <?php 
   echo $entry[text3]
  ?>
    

	<!-- IF disabled -->
	<?php
	}
	?>
</table>


<!--  -->
<!-- using image to invoke javascript funtions for initialisation -->


<p>Credits left: </p><p id="demo"></p>


<!--  -->


<input type="submit" name="select_events" value="Select events">
</form>

<?php 
// var_dump($events); 
?>

<img src="/1.gif" onload="setCredits(<?php echo $_SESSION['credits_left']; ?>);displayCredits()" style="visibility: hidden;">






<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

</div>

</div>
<?php include "_side_in.php"; ?>
</div>


<?php 
include "_footer.php"; 
?>
