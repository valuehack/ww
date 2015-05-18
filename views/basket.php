<!--Author: Bernhard Hegyi -->

<script type="text/javascript">

function checkMe() {
    if (confirm("Are you sure?")) {
        return true;
    } else {
        return false;
    }
}
</script>

<?php 
include_once("secdown/functions.php");
dbconnect();

require_once('classes/Login.php');
include('_header.php'); 
$title="Basket";

?>

<div id="center">  
<div id="content">
<a class="content" href="../index.php">Index &raquo;</a><a class="content" href="<?php echo $_SERVER['PHP_SELF']; ?>"> Basket</a>
<div id="tabs-wrapper-lower"></div>

<h2>Basket</h2>

<?php 
//print_r($_SESSION);

//Check if basket was cleared
if(isset($_POST['delete'])) {
    unset($_SESSION['basket']);
}

//Check if a item was removed
if(isset($_POST['remove'])) {
    $remove_id = $_POST['remove'];
    unset($_SESSION['basket'][$remove_id]);
}

//Check if checkout was made. If yes, show bought items.
if(isset($_POST['checkout'])) {
    $items = $_SESSION['basket'];
    $login->checkout($items);   
}


//Array with all the selected items, which are displayed in the basket:
if($_SESSION['basket']) { 
    $items = $_SESSION['basket'];

    /*echo "Items: ";
    print_r($items);
    echo "<br><br>";*/

    echo "You have the following items in your basket:";
    echo "<hr><table><tr><td style='width:5%'><b>ID</b></td>";
    echo "<td style='width:45%'><b>Name</b></td>";
    echo "<td style='width:10%'></td>";
    echo "<td style='width:10%'><b>Quantity</b></td>";
    echo "<td style='width:15%'><b>Price</b></td>";
    echo "<td><b>Sum</b></td></tr>";

    $total = 0;

    foreach ($items as $key => $quantity) {
        $items_extra_query = "SELECT * from termine WHERE `id` LIKE '$key' ORDER BY start DESC";
        $items_extra_result = mysql_query($items_extra_query) or die("Failed Query of " . $items_extra_query. mysql_error());
        $itemsExtraArray = mysql_fetch_array($items_extra_result);
        
        $sum = $quantity*$itemsExtraArray[event_price];

        echo "<tr><td>".$itemsExtraArray[id]."&nbsp</td>";
        echo "<td><i>".ucfirst($itemsExtraArray[type])."</i> ".$itemsExtraArray[title]." <i>".$itemsExtraArray[format]."</i></td>";
        ?>
        <td><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="hidden" name="remove" value="<?php echo $key ?>" />
                <input type="submit" value="Remove" onClick="return checkMe()"></form></td>
        <?php
        echo "<td>&nbsp &nbsp".$quantity."</td>";
        echo "<td><i>".$itemsExtraArray[event_price]." Credits</i></td>";
        echo "<td>".$sum." Credits</td></tr>";
       
       // TO DO: Find better solution to display the relevant information for different product categories  
       if (!(is_null($itemsExtraArray[start]))) {
            echo "<tr><td></td><td>".date("d.m.Y",strtotime($itemsExtraArray[start]));
            if (strtotime($entry[end])>(strtotime($entry[start])+86400)) echo "-".date("d.m.Y",strtotime($entry[end]));
        }
        
        $total += $sum;

        //TO DO: remove-button
    }
    echo "<tr><td></td><td></td><td></td><td></td><td><b>TOTAL</b></td><td><b>".$total." Credits</b></td></tr>";
    echo "</table><hr>";      
?>
<a class="scholien" href="<?php downloadurl('http://test.wertewirtschaft.net/secdown/sec_files/sampledoc.doc','scholien_universitaet'); ?>" onclick="updateReferer(this.href);">03/14 Universit&auml;t (Test secureDownload)</a>

<!-- Clear Basket + Checkout Buttons-->

<table style="width:100%"><tr><td style="width:80%">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="submit" name="delete" value="Clear Basket" onClick="return checkMe()"></form></td>
    <td align="right">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="submit" name="checkout" value="Checkout"></form></td></tr>
</table>

<?php
}

else {
    echo "You have no items in your basket.<br><br>";
}
?>

<!-- backlink -->
<a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a>

</div>
<?php include('_side_in.php'); ?>
</div>
<?php include('_footer.php'); ?>