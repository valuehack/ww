<?php
require_once('../classes/Login.php');
//$title="Schriften";
include "../views/_header_not_in_jubilaeum.php";



?>

<div class="content">


  <div class="jubilaeum_head">
  <p>Vielen Dank für 10 Jahre Unterstützung!</p>
  </div>
  <div class="jubilaeum_body">
    <p>Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. Vielen Dank. </p>

    <div class="bss-slides num2" tabindex="2">
    <?
      for($i=1;$i<=37;$i++) {
        echo "<figure><img src='../jubilaeum/Fotos/jubilaeum".$i.".jpg' /></figure>";
      }
    ?>
    </div>
    <script src="../js/slideshow.js"></script>
    <script>
      var opts = {
        auto : true,
        fullScreen : true,
        swipe : false
      };
      makeBSS('.num2', opts);
    </script>


  </div>

</div>

<?php include('_footer.php'); ?>
