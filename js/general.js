function changePrice(totalQuantity, price){
    document.getElementById("change").innerHTML = (totalQuantity * price);
}

/* Social Links Popup*/
function openpopup (url) {
   	popup = window.open(url, "popup1", "width=640,height=480,status=yes,scrollbars=yes,resizable=yes");
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

