<?php 
require_once('../classes/Login.php');
$title="Vortrag";
include ("_header_not_in.php"); 
?>

<div class="content">

<?php 

  $id = "vortrag";
  $vortrag_info = $general->getProduct($id);
  
?>
	<div class="blog">
 		<h1><?echo $vortrag_info->title?></h1>
 	</div>
	<div class="medien_content">

<?php		
  	echo $vortrag_info->text;
	echo $vortrag_info->text2;

  ?>
			<div class="centered">
				<a class="blog_linkbutton" href="mailto:&#105;&#110;&#102;&#111;&#064;&#115;&#099;&#104;&#111;&#108;&#097;&#114;&#105;&#117;&#109;&#046;&#097;&#116;">Anfrage schicken</a>
			</div>		
    </div>

</div>
    
<?php 
include "_footer.php"; 
?>