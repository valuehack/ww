function changePrice(totalQuantity, price){
    document.getElementById("change").innerHTML = (totalQuantity * price);
}

/* Social Links Popup*/
function openpopup2 (url) {
   	popup = window.open(url, "popup1", "width=640,height=480,status=yes,scrollbars=yes,resizable=yes");
   	popup.focus();
}

/*Scholien Print Popup*/
function openpopup2 (url) {
   	popup = window.open(url, "popup1", "width=960,height=640,status=yes,scrollbars=yes,resizable=yes");
   	popup.focus();
}

/* Highlights the current page in the nav*/
function setActive() {
    aObj = document.getElementById('navelm').getElementsByTagName('a');
    for(i=0;i<aObj.length;i++) { 
    	if(document.location.href.indexOf(aObj[i].href)>=0) {
        	aObj[i].className='active';
         }
    }
}

window.onload = setActive;

/* Hide non-content elements on Scholien print view*/
function setPrintView() {
        $(document).ready(function(){
        	$("aside").hide();
        	$("header").hide();
        	$("footer").hide();
        	$("blog_footer").hide();
	});
}
