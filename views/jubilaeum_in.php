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
      $i=1;

      while ($i<=5) {
        //$img = "../bla/bla"+$i+".jpg";
        echo "<figure><img src='https://googledrive.com/host/0B4pA_9bw5MghQVBEN29WaTQzVU0/Benjamin_Zika_20161203_Scholarium_0".$i."'.jpg' /></figure>";
        $i++;
      }
    ?>



      <figure>
      <img src="../style/gfx/twitter.png" width="100%" />
    </figure>
    <figure>
      <img src="../style/gfx/facebook.png" width="100%" /><figcaption>"Facebook" by <a href="https://www.google.com/">Trey Ratcliff</a>.</figcaption>
    </figure>
    <figure>
      <img src="../style/gfx/xing.png" width="100%" /><figcaption>"Xing" by <a href="https://www.google.com/">Dave Soldano</a>.</figcaption>
    </figure>

      <!-- more figures here as needed -->

    </div>
    <script src="../js/slideshow.js"></script>
    <script>
      var opts = {
        auto : false,
        fullScreen : true,
        swipe : false
      };
      makeBSS('.num2', opts);
    </script>


  </div>

</div>

<?php include('_footer.php'); ?>
