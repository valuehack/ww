<!--  
   Secure Download Links usage example
   -->
<?php 
include_once("functions.php"); //Add this line to your page that has download links. 

?>

<?php dbconnect(); // Add this line for database connection. ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> <!-- head section -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Download Area</title>
<!-- CSS File --> 
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="js/general.js" language="javascript">

</script>

</head> <!-- head end -->

<body><!-- Body start -->
<div id="main"> <!-- main start -->
	<div class="heading">
    	<div class="d_L">
      
        <div class="d_R"><div class="d_M"><div class="d_M_p">Download Area</div></div>
        </div></div>
    </div>
    <ul class="containerText">
    
 <?php /*Add the  downloadurl($url, $fakefilename)  function inside php tags as shown under. */     ?>
 
      <li>  <span class="d_Img"><img src="images/word.gif"  alt="" /></span>
        <span class="text"><a  href="<?php  downloadurl('http://satyamtechnologies.net/secdown/sec_files/sampledoc.doc','mswordfile'); ?>" onclick="updateReferer(this.href);" >MS Word Document</a> </span></li>
       <li>   <span class="d_Img"><img src="images/excel.gif"  alt="" /></span>
        <span class="text"><a href="<?php  downloadurl('http://satyamtechnologies.net/secdown/sec_files/samplexls.xls','excelfile'); ?>"  onclick="updateReferer(this.href);" >MS Excel File</a> </span></li>
       <li>   <span class="d_Img"><img src="images/pdf.gif"  alt="" /></span>
      <span class="text"><a href="<?php  downloadurl('http://satyamtechnologies.net/secdown/sec_files/samplepdf.pdf','pdffile'); ?>"  onclick="updateReferer(this.href);" >Adobe Acrobat File</a> </span></li>
 <li> <span class="d_Img"><img src="images/zipp.gif"  alt="" /></span>
        <span class="text"><a href="<?php  downloadurl('http://satyamtechnologies.net/secdown/sec_files/samplezip.zip', 'ZippedFolder'); ?>"  onclick="updateReferer(this.href);" >Zipped Folder</a></span></li>
  </ul>
    <div class="heading">
    	<div class="d_L">
        
        <div class="d_R"><div class="d_M"><div class="d_M_p">Download Area (Files stored on different server)</div></div>
        </div></div>
  </div>
    <ul class="containerText">

      <li>  <span class="d_Img"><img src="images/word.gif" alt=""  /></span>
        <span class="text"><a href="<?php  downloadurl('http://lifegrance.com/files/sampledoc.doc','mswordfile'); ?>"  onclick="updateReferer(this.href);" >MS Word Document</a></span></li>
     <li>   <span class="d_Img"><img src="images/excel.gif" alt=""  /></span>
        <span class="text"><a href="<?php  downloadurl('http://lifegrance.com/files/samplexls.xls','excelfile'); ?>"  onclick="updateReferer(this.href);" >MS Excel File</a> </span></li>
     <li>   <span class="d_Img"><img src="images/pdf.gif" alt=""  /></span>
        <span class="text"><a href="<?php  downloadurl('http://lifegrance.com/files/samplepdf.pdf','pdffile'); ?>"  onclick="updateReferer(this.href);" >Adobe Acrobat File</a> </span> </li>
     <li>   <span class="d_Img"><img src="images/zipp.gif" alt=""  /></span>
        <span class="text"><a href="<?php  downloadurl('http://lifegrance.com/files/samplezip.zip', 'ZippedFolder'); ?>"  onclick="updateReferer(this.href);" >Zipped Folder</a></span></li>
  </ul>
  
  
	<div class="heading">
    	<div class="d_L">
      
        <div class="d_R"><div class="d_M"><div class="d_M_p">Download Area (Relative Path to files)</div></div>
        </div></div>
    </div>
    <ul class="containerText">
    
 <?php /*Add the  downloadurl($url, $fakefilename)  function inside php tags as shown under. */     ?>
 
      <li>  <span class="d_Img"><img src="images/word.gif"  alt="" /></span>
        <span class="text"><a  href="<?php  downloadurl('sec_files/sampledoc.doc','mswordfile'); ?>" onclick="updateReferer(this.href);" >MS Word Document</a> </span></li>
       <li>   <span class="d_Img"><img src="images/excel.gif"  alt="" /></span>
        <span class="text"><a href="<?php  downloadurl('sec_files/samplexls.xls','excelfile'); ?>"  onclick="updateReferer(this.href);" >MS Excel File</a> </span></li>
       <li>   <span class="d_Img"><img src="images/pdf.gif"  alt="" /></span>
      <span class="text"><a href="<?php  downloadurl('sec_files/samplepdf.pdf','pdffile'); ?>"  onclick="updateReferer(this.href);" >Adobe Acrobat File</a> </span></li>
 <li> <span class="d_Img"><img src="images/zipp.gif"  alt="" /></span>
        <span class="text"><a href="<?php  downloadurl('sec_files/samplezip.zip', 'ZippedFolder'); ?>"  onclick="updateReferer(this.href);" >Zipped Folder</a></span></li>
  </ul>
   <div class="containerText" style="font-weight:bold;">
It is possible to store files above docroot(www or public_html) and generate a secure download link using relative path to file. This is "the recomended method" experts suggest.
</div>

   <div class="containerText">
	 <div id="All_L">
     <div id="P_M">
  Supported file formats are:
   .ai, .asx, .au, .avi ,.bmp ,.css, .doc, .eps, .exe, .gif, .htm, .html, .ico, .jpe, .jpeg, .jpg, .js, .mid, .mov, .mp3, .mpeg, .mpg, .pdf, .pps, .ppt, .ps, .pub, .qt, .rtf, .svg, .swf, .tif, .tiff, .txt, .wav, .wmf, .xls, .zip.</div></div>
   </div>
    <div id="clear"></div>
</div><!-- main end -->
</body><!-- Body end -->
</html>