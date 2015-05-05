
<?php 
// require_once('classes/Login.php');
include('_header.php'); 
?>

<div id="center">  
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a>

<!-- <div id="tabs-wrapper-lower"></div> -->

<h2>Event Area</h2>

<?php 

// print_r($_SESSION[user_id]);

//array comes out of this one
$events = $login->getUserEvents();

echo "Extra material for the events:<hr>";

foreach ($events as $event_id) 
{

    echo "<br>";
    // or can use between and
    // $events_extra_query = "SELECT * from termine WHERE `id` LIKE '%$event_id%' AND start <= DATE_ADD(CURDATE(),INTERVAL 7 DAY)";

    $events_extra_query = "SELECT * from termine WHERE `id` LIKE '%$event_id%' AND start <= DATE_ADD(NOW(),INTERVAL 7 DAY) AND `type` NOT LIKE 'project' ORDER BY start DESC";

    $events_extra_result = mysql_query($events_extra_query) or die("Failed Query of " . $events_extra_query. mysql_error());
    $eventsExtraArray = mysql_fetch_array($events_extra_result);

    // print_r($eventsExtraArray);
    // echo $eventsExtraArray[id]." ".$eventsExtraArray[title];

    echo $eventsExtraArray[id]." ".$eventsExtraArray[title]."<br>";

    echo $eventsExtraArray[event_stuff];
    echo "<br><br><hr>";

}












// echo $_SESSION['user_email'];
// $some = $login->getUserData($_SESSION['user_email']); 

$result_row = $login->getUserData(trim($_SESSION['user_email']));

if ($result_row->gave_credits == 0) echo "Please fill in this form to get a free credit.";

if ( isset($result_row->Vorname) and trim($result_row->Vorname) and 
     isset($result_row->Nachname) and trim($result_row->Nachname) and
     isset($result_row->Land) and trim($result_row->Land) and
     isset($result_row->Ort) and trim($result_row->Ort) and
     isset($result_row->Strasse) and trim($result_row->Strasse) and
     ($result_row->gave_credits == 0)
     )
    {

    $login->messages[] = "You have just received a credit. Spend wisely!";

    $login->giveCredits();

    #page refresh after form was submitted
    #evaluate AJAX for such action in the future 
    echo '<meta http-equiv="refresh" content="0; url=http://test.wertewirtschaft.net/edit.php" />';

    }

?>
<!-- <hr/> -->
<br>



 





<!-- backlink -->
<a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a>

</div>
<?php include('_side_in.php'); ?>
</div>
<?php include('_footer.php'); ?>
