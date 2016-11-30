<?php
require_once('../classes/Login.php');
$title="Vortrag";
include ("_header_in.php");
?>

<script>
function changePrice(totalQuantity, price){
    document.getElementById("change").innerHTML = (totalQuantity * price);
}

</script>

<div class="content">

<?php
if(!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}

if(isset($_POST['add'])){

  $add_id = $_POST['add'];
  $add_quantity = $_POST['quantity'];
  $add_code = $add_id . "0";
  if ($add_quantity==1) $wort = "wurde";
  else $wort = "wurden";
  echo "<div class='basket_message'><i>".$add_quantity." Artikel ".$wort." in Ihren Korb gelegt.</i> &nbsp <a href='../spende/korb.php'>&raquo; zum Korb</a></div>";

  if (isset($_SESSION['basket'][$add_code])) {
    $_SESSION['basket'][$add_code] += $add_quantity;
  }
  else {
    $_SESSION['basket'][$add_code] = $add_quantity;
  }

}


  $id = "vortrag";
  $vortrag_info = $general->getProduct($id);
  $title=$vortrag_info->title;
  $text=$vortrag_info->text;
  $text2=$vortrag_info->text2;
  $n=$vortrag_info->n;
  $price=$vortrag_info->price;
?>
	<div class="blog">
 		<h1><?echo $title?></h1>
 	</div>
	<div class="medien_content">

<?php
  	echo $text;
	echo $text2;

  if ($_SESSION['Mitgliedschaft'] == 1) {
    ?>
    <div class="centered">
      	<!-- Button trigger modal -->
     	<!-- <input type="button" class="medien_inputbutton" value="Ausw&auml;hlen" data-toggle="modal" data-target="#myModal"> -->
     	<a class="blog_linkbutton" href="mailto:&#105;&#110;&#102;&#111;&#064;&#115;&#099;&#104;&#111;&#108;&#097;&#114;&#105;&#117;&#109;&#046;&#097;&#116;">Anfrage schicken</a>
    </div>
    <?php
    }
    else {
    ?>
	<div class="projekte_invest">

    <form class="salon_reservation_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="add" value="<?php echo $n; ?>" />
      <select class="project_invest_select" name="quantity" onchange="changePrice(this.value,'<?php echo $price; ?>')">
      	<option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
      <input class="medien_inputbutton" type="submit" value="Ausw&auml;hlen">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="projekte_invest_span" id="change"><?php echo $price; ?> </span><img class='projekte_coin2' src='../style/gfx/coin.png'>
    </form>


      </div>
    <?php
    }
	?>
	</div>


</div>

<!-- Modal 
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h2 class="modal-title" id="myModalLabel">Ausw&auml;hlen</h2>
        </div>

        <div class="modal-footer">
          <a href="../spende/"><button type="button" class="inputbutton">Besuchen Sie uns als Gast</button></a>
        </div>
      </div>
    </div>
  </div> -->
<?php
include "_footer.php";
?>
