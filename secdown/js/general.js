      var XMLHttpRequestObject = false; 

      var XMLHttpRequestObject = false; 

      try { 
        XMLHttpRequestObject = new ActiveXObject("MSXML2.XMLHTTP"); 
         } catch (exception1) { 
         try { 
           XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP"); 
         } catch (exception2) { 
           XMLHttpRequestObject = false; 
       } 
     } 

     if (!XMLHttpRequestObject && window.XMLHttpRequest) { 
       XMLHttpRequestObject = new XMLHttpRequest(); 
     } 
     
     function updateReferer(obj){
	 securl = obj;
 	 var geturl = 	'setreferer.php?securl='+securl+'&currenturl='+document.URL;  
			 		  	
         	XMLHttpRequestObject.open("GET",geturl,false ); 
            XMLHttpRequestObject.onreadystatechange = function() 
          {  
            if (XMLHttpRequestObject.readyState == 4 && 
            XMLHttpRequestObject.status == 200) { 
              var response = XMLHttpRequestObject.responseText; 
              //alert(response);
            } 
          } 
          XMLHttpRequestObject.send(null); 
	 }
