<!DOCTYPE html >
<html lang="de">	
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    	<meta name="description" content="Verlag und Kompendium zur &Ouml;stereichischen Schule der &Ouml;konomik">
    	<link rel="shortcut icon" href="../favicon.ico">
    	
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<!--[if IE]>
      		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js" type="text/javascript"></script>
    	<![endif]-->
    	
    	<link rel="stylesheet" href="../style/normalize.css">
    	<link rel="stylesheet" href="../style/style.css">
    	<link href='https://fonts.googleapis.com/css?family=Raleway:400,300|EB+Garamond' rel='stylesheet' type='text/css'>
       
    	<title><?=$title?> | Mises Austria</title>
    
    	<script type="text/javascript">
    	    function setActive() {
              aObj = document.getElementById('nav').getElementsByTagName('a');
              for(i=0;i<aObj.length;i++) { 
                if(document.location.href.indexOf(aObj[i].href)>=0) {
                  aObj[i].className='nav--active';
                }
              }
            }
            window.onload = setActive;
            
            function showNav() {
            	aObj = document.getElementById('nav');
            	if (aObj.style.display == 'none') {
            	aObj.style.display = 'block';
            	}
            	else {
            		aObj.style.display = 'none';
            	}
            }
    	</script>
    
	</head>
	<body>
<!--Header-->
		<header id="header">
  			<div class="logo">
  				<a href="../index.php"><img src="../style/ma_logo.png" alt=""></a>
			</div>
			<div class="mises">
  				<a href="../index.php"><img src="../style/Young_Mises.png" alt=""></a>
			</div>
			<div class="text">
			<h1>mises.at</h1>
			<h2>The Original Austrians</h2>
			<h3>tu ne cede malis</h3>
			</div>
			<div class="nav-trigger">
				<div class="nav-trigger__icon">
					<a href="#" onclick="showNav();return false;"><img src="../style/navicon.svg" alt="Menu" title="Menu"></a>
				</div>
			</div>
  			<div id="nav">
    			<div class="navi">
      				<ul>
      					<li><a href="../verlag/">Verlag</a></li>
        				<li><a href="../begriffe/">Begriffe</a></li>
        				<li><a href="../denker/">Denker</a></li>
        				<li><a href="../buecher/">B&uuml;cher</a></li>
        				<li><a href="../dokumente/">Dokumente</a></li>
        				<li><a href="../orte/">Orte</a></li>
      				</ul>
   				</div>
  			</div>
  	</header>