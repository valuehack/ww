<?php 

include_once("functions.php");                      //including functions.php
dbconnect();                                        //database connection
startover();
                                       // Delete records older that no of days defined in settings file.
if((isset($_GET['dc']))&& (!empty($_GET['dc']))){   // Check if download code is set
    if(authenticate($_GET['dc'])){                    //Verify if download code is correct.
    $filename = getfile($_GET['dc']);           
    $fakename = fakefilename($_GET['dc']);
    $extension = fileexten($filename);
        if(($filename!= false)&&($fakename!=false&& @fopen($filename,'r')==true)){
        $mime = contenttype($extension);
        set_time_limit(0);
        header('Pragma: public');
        header('Expires: 0'); 
        header("Content-Type:".$mime);
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Disposition: attachment;filename='.$fakename.'.'.$extension);
        header("Content-Transfer-Encoding: binary");
          if (ob_get_length() > 0) {
 			ob_end_clean();
			}
        flush();
        @readfile($filename);
        }
        else{
    	$error = UNAUTHACCESSMESS. "<h3>We could not find this file</h3>";} // If the filename or fake filename could not be retrieved. 
        }  
    else{
    	$error =  UNAUTHACCESSMESS;             // If the download code  is not correct. 
    }
}
else{   
    $error =  UNAUTHACCESSMESS;                 // If the download code  is not set or empty. 
    }  

if(isset($error)){                              //show no permissions page.  
include('no-permissions.php');
}
#php end tag deleted