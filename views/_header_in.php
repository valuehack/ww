<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
  <head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> -->    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="shortcut icon" href="/favicon.ico">
    <!--<link rel="stylesheet" type="text/css" href="../style/style.css">-->
    <link rel="stylesheet" type="text/css" href="../scholien/blog_style.css">

    <title><?=$title?> | Institut f&uuml;r Wertewirtschaft</title>

<!--Dateien - Bildgalerie -->
    <link rel="stylesheet" href="http://wertewirtschaft.org/tools/Lightbox/css/lightbox.css" type="text/css" media="screen" />

    <script src="http://wertewirtschaft.org/tools/Lightbox/prototype.js" type="text/javascript"></script>
    <script src="http://wertewirtschaft.org/tools/Lightbox/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
    <script src="http://wertewirtschaft.org/tools/Lightbox/lightbox.js" type="text/javascript"></script>
<!-- Ende -->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39285642-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

  </head>

<script type="text/javascript">
// Javascript originally by Patrick Griffiths and Dan Webb.
// http://htmldog.com/articles/suckerfish/dropdowns/
sfHover = function() {
   var sfEls = document.getElementById("navbar").getElementsByTagName("li");
   for (var i=0; i<sfEls.length; i++) {
      sfEls[i].onmouseover=function() {
         this.className+=" hover";
      }
      sfEls[i].onmouseout=function() {
         this.className=this.className.replace(new RegExp(" hover\\b"), "");
      }
   }
}
if (window.attachEvent) window.attachEvent("onload", sfHover);
</script>

<body>
<!-- Layout-->
        <header class="header1">
            <div class="logo">
                <a href="/"><img class="logo_img" src="../scholien/gfx/ww_logo_w.png" alt="Institut f&uuml; Wertewirtschaft" name="Home"></a>
                <span class="login"><a href="">Ulrich M&ouml;ller</a></span>
            </div>
            <div class="nav">
                <div class="navi">
                <ul class="navi">
                    <li><a href="/scholien/">Scholien</a></li>
                    <li><a href="/salon/">Salon</a></li>
                    <li><a href="/kurse/">Kurse</a></li>
                    <li><a href="/schriften/">Schriften</a></li>
                    <li><a href="/medien/">Bibliothek</a></li>
                    <li><a href="/kurse/">Projekte</a></li>
                </ul>
                </div>
           </div>
        </header>

<?php
//set timezone
mysql_query("SET time_zone = 'Europe/Vienna'");

// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            #add some html to make it look nicer
            
          ?><p style="text-align:center;"> <?php echo $error; ?> </p> <?php
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            #echo $message;
            ?><p style="text-align:center;"> <?php echo $message; ?> </p> <?php
        }
    }
}
?>

<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            #echo $error;
            ?><p style="text-align:center;"> <?php echo $error; ?> </p> <?php
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            #echo $message;
            ?><p style="text-align:center;"> <?php echo $message; ?> </p> <?php
        }
    }
}
?>
   