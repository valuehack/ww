<?php
  // Stop page from being loaded directly. 
if (preg_match("/functions.php/i", $_SERVER['PHP_SELF'])){
echo "Please do not load this page directly. Thanks!";
exit;
}   
                                    
include_once("settings.php");                           //include settings file


/******************* Main Functions *******************/
function downloadcode($url, $pretendname = 'download' ){ // Function to generate download code   
$downloadpage = currentpageurl();
$uniquecode = generatecode();
$client_ip =   getip();
$query_urlchk = "SELECT * FROM ddown WHERE actuallink = '{$url}' LIMIT 1";
$result_urlchk = @mysql_query($query_urlchk);
//writedberror($result_urlchk);
    if(mysql_num_rows($result_urlchk)==0){
    addnewurltodb($url,$pretendname,$downloadpage);
    $file_id = getfileid($url);
    addnewcodedb($file_id,$client_ip,$uniquecode);
    }	
    else if(mysql_num_rows($result_urlchk)==1){
    $file_id = mysql_result($result_urlchk, 0,'id');
    $file_name = mysql_result($result_urlchk, 0,'pretendname');
    $pageurl = mysql_result($result_urlchk, 0,'whoreferred');  
        if($file_name!=trim($pretendname)){	
        changefakenamedb($pretendname, $file_id);
        }    
        if($pageurl!=trim($downloadpage)){
        $downloadpagestr =  $pageurl.','.$downloadpage;	
        addtowhoreferreddb($downloadpagestr, $file_id);
        }
        changecodedb($uniquecode,$client_ip,$file_id); 
    }
return 	$uniquecode;
}

function authenticate($code){                              //Verify IP address and downlaod code beofore a file download.
$client_ip = getip();
$query_urlverify = "SELECT * FROM ipmap WHERE dccode = '{$code}' and ipaddress='{$client_ip}' LIMIT 1";
$result_urlverify= @mysql_query($query_urlverify);
//writedberror($result_urlverify);
    if(mysql_numrows($result_urlverify)==0){
   	return false;
    }	
    elseif(mysql_numrows($result_urlverify)==1){ 
    $file_id = mysql_result($result_urlverify, 0, 'id_file');  
    $refererstr = whoreferredstr($file_id);
    $refererarr = explode(',',$refererstr);
       if(isset($_SERVER['HTTP_REFERER'])&& in_array($_SERVER['HTTP_REFERER'], $refererarr)!=FALSE){      
        return true;
        } 
        else if(in_array(getSReferer($code), $refererarr)!=FALSE){
         clearsReferer($code);
       	return true;
        }
        else{ return false;}
        }
    else {
    return false;
    }
}

function generatecode(){                                // Check Random Code for uniqueness and regenerate if required. 
$randcode = randomcode();
$count = 1;
    while($count>0){
    $query_unq = "SELECT id FROM ipmap WHERE dccode = '{$randcode}' LIMIT 1";	
    $result_unq = @mysql_query($query_unq);
    $count = @mysql_num_rows($result_unq);
    $randcode = randomcode();	
    }
return $randcode;
}

function downloadurl($url, $pretendname = 'download'){      //Function to print download URL in Download Page
$downloadcode = downloadcode($url, $pretendname);
echo URLTOFILES.'download.php?dc='.$downloadcode;
}

function getfile($code){                                    // Get File Url 
$client_ip = getip();
$query_i = "select id_file from ipmap where  dccode = '{$code}' and ipaddress = '{$client_ip}'LIMIT 1";
$result_i = @mysql_query($query_i);
//writedberror($result_i);
    if(mysql_numrows($result_i)==1){
    $file_id = mysql_result($result_i,0,'id_file');
    $query_f = "select actuallink from ddown where  id = '{$file_id}' LIMIT 1";
    $result_f = @mysql_query($query_f);
    return mysql_result($result_f,0,'actuallink');
    }
else {return false;}
}

/******************* Functions for Internal Use *******************/

function fakefilename($code){                           //Function to get pretended filename while downloading file. 
$client_ip =   getip();
$query_f = "select id_file from ipmap where dccode ='$code' and ipaddress = '$client_ip' LIMIT 1";
$result_f = @mysql_query($query_f);
//writedberror($result_f);
    if(mysql_numrows($result_f)==1){
    $file_id = mysql_result($result_f,0,'id_file');
    $query_pf = "select pretendname from ddown where id ='{$file_id}' LIMIT 1";
    $result_pf = @mysql_query($query_pf);
    //writedberror($result_pf);
        if(mysql_numrows($result_pf)==1){	
        $fakefname = mysql_result($result_pf,0,'pretendname');
        return $fakefname;
        }
        else {return false;}
        }
    else {return false;}	
}

function startover(){                                   //Function to cleanup database after defined number of days.
$days = STARTOVER;
$query_del = "delete from ipmap WHERE timestamp < (NOW() - INTERVAL {$days} DAY)";
$result_del = @mysql_query($query_del);
//writedberror($result_del);	
$query_deli = "delete from ipmap where not exists(select null FROM ddown d WHERE d.id = id_file)";
$result_deli = @mysql_query($query_deli);
//writedberror($result_deli);	
$query_deld = "delete from ddown where id NOT IN (SELECT i.id_file FROM ipmap i)";
$result_deld = @mysql_query($query_deld);
//writedberror($result_deld);	
}

/******************* Database Functions ************************/

function dbconnect(){	                              //function for database connection
mysql_connect(DBHOST, DBUSER, DBPASS) or die("MySQL Error: " . mysql_error());
mysql_select_db(DBNAME) or die("MySQL Error: " . mysql_error());
 createdbtables();
}

function createdbtables(){
$query_cr = "CREATE TABLE IF NOT EXISTS ddown (".
  "id int(10) NOT NULL AUTO_INCREMENT,".
  "actuallink varchar(300) COLLATE utf8_unicode_ci NOT NULL,".
  "pretendname varchar(100) COLLATE utf8_unicode_ci NOT NULL,".
  "whoreferred text COLLATE utf8_unicode_ci NOT NULL,".
  "PRIMARY KEY (id),".
  "UNIQUE KEY actuallink (actuallink)".
") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
$result_cr = mysql_query($query_cr);
writedberror($result_cr);
$query_cr1 = "CREATE TABLE IF NOT EXISTS ipmap (".
  "id int(10) NOT NULL AUTO_INCREMENT,".
  "id_file int(10) NOT NULL,".
  "ipaddress varchar(15) COLLATE utf8_unicode_ci NOT NULL,".
  "dccode varchar(30) COLLATE utf8_unicode_ci NOT NULL,".
  "timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,".
  "refer varchar(300) COLLATE utf8_unicode_ci NOT NULL,".
  "PRIMARY KEY (id),".
  "UNIQUE KEY dccode (dccode)".
") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
$result_cr1 = mysql_query($query_cr1);
writedberror($result_cr1);
}

function addnewurltodb($url,$pretendname,$downloadpage){
    $query_dcins = "INSERT INTO ddown (id,actuallink, pretendname, whoreferred) VALUES('','$url','$pretendname','$downloadpage')";
    $result_dcins	= @mysql_query($query_dcins);
    //writedberror($result_dcins);    
}

function addnewcodedb($file_id,$client_ip,$uniquecode){ //Generate new code on page reload
$query_ipmap = "INSERT INTO ipmap (id_file,ipaddress,dccode) VALUES($file_id,'$client_ip','$uniquecode')";
$result_ipmap	= @mysql_query($query_ipmap);
//writedberror($result_ipmap);   
}

function changecodedb($uniquecode,$client_ip,$file_id){ //Generate new code on page reload
$query_chngcode = "UPDATE ipmap SET dccode='{$uniquecode}',  ipaddress = '{$client_ip}' WHERE id_file = '{$file_id}'";
$result_chngcode = @mysql_query($query_chngcode);
//writedberror($result_chngcode);    
}

function changefakenamedb($pretendname, $file_id){      //Change fake filename for a file
$query_chngname = "UPDATE ddown SET pretendname='{$pretendname}' WHERE id = '{$file_id}'";
$result_chngname = @mysql_query($query_chngname);
//writedberror($query_chngname);
}

function addtowhoreferreddb($downloadpagestr, $file_id){  //Update Who Refered string in database.   
$query_chngurl = "UPDATE ddown SET whoreferred='{$downloadpagestr}' WHERE id = '{$file_id}'";
$result_chngurl = @mysql_query($query_chngurl);
//writedberror($result_chngurl);
}

function getfileid($url){                                 //Get File id from actual url
$query_id = "SELECT id FROM ddown WHERE actuallink = '{$url}' LIMIT 1";
$result_id = @mysql_query($query_id);
if(mysql_num_rows($result_id)==1){return mysql_result($result_id, 0, 'id');}
else return false;
}

function whoreferredstr($file_id){                       //Retrieve Who Refered string from database. 
$query_ref ="SELECT whoreferred FROM ddown WHERE id = '{$file_id}' LIMIT 1";
$result_ref = @mysql_query($query_ref);
//writedberror($result_ref);
$refererstr = mysql_result($result_ref, 0,'whoreferred');  
return  $refererstr;
}

function getSReferer($code){							//Retrieve Who Refered by AJAX from database. for blank/ invalid referer. 
$client_ip = getip();
$code = mysql_escape_string($code);
$query_ref = "SELECT refer FROM ipmap WHERE ipaddress = '{$client_ip}' and dccode='{$code}' limit 1";
$result_ref = mysql_query($query_ref) or die(mysql_error());	
return strip_tags(mysql_result($result_ref, 0, 'refer'));
}

function clearsReferer($code){							//Clear Who Refered by AJAX from database. blank/ invalid referer case.
$client_ip = getip();
$code = mysql_escape_string($code);
$query_rref = "update ipmap  set refer = '' WHERE ipaddress = '{$client_ip}' and dccode='{$code}' limit 1";
$result_rref = mysql_query($query_rref) or die(mysql_error());	
}

/* Function to give the error after databse operations.*/
 function writedberror($result){                        //show database error 
	if(!$result){die(mysql_error());}
}

/******************* Utility Functions ************************/

function getip(){                                        // Get IP address of current user
if (!empty($_SERVER['HTTP_CLIENT_IP'])){
$ip=$_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else{
$ip=$_SERVER['REMOTE_ADDR'];
}
return $ip;
}

function fileexten($filename){                          // Get File extension from filename string.
$filenamesplit =explode('.',$filename);
$extension = $filenamesplit[count($filenamesplit)-1];
return $extension;
}

function currentpageurl(){                               //Function to return current page url                        
return (!empty($_SERVER['HTTPS']) ? 'https://': 'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}

function randomcode(){	                                // Generate Random Code	 
if(NOOFFILES<10000){ $nofiles = 10000;} else{ $nofiles = NOOFFILES;	}
for($i=0; $i< strlen($nofiles)*2; $i++){
$randchars[] = chr(rand(97,122));
 }
$timestring = (string)time();
$code = '';	
$i = 0;
foreach($randchars as $randchar){
$code .= $randchar;
    if($i<strlen($timestring)){
    $code .= $timestring{$i};
    }
$i++;	
}
return $code;
}

function contenttype($ext){                                // Function returns Mime type depending
$mime_types=array();
$mime_types['ai']    ='application/postscript';
$mime_types['asx']   ='video/x-ms-asf';
$mime_types['au']    ='audio/basic';
$mime_types['avi']   ='video/x-msvideo';
$mime_types['bmp']   ='image/bmp';
$mime_types['css']   ='text/css';
$mime_types['doc']   ='application/msword';
$mime_types['eps']   ='application/postscript';
$mime_types['epub']  ='application/epub+zip'; //added
$mime_types['exe']   ='application/octet-stream';
$mime_types['gif']   ='image/gif';
$mime_types['htm']   ='text/html';
$mime_types['html']  ='text/html';
$mime_types['ico']   ='image/x-icon';
$mime_types['jpe']   ='image/jpeg';
$mime_types['jpeg']  ='image/jpeg';
$mime_types['jpg']   ='image/jpeg';
$mime_types['js']    ='application/x-javascript';
$mime_types['mid']   ='audio/mid';
$mime_types['mobi']  ='application/x-mobipocket-ebook'; //added
$mime_types['mov']   ='video/quicktime';
$mime_types['mp3']   ='audio/mpeg';
$mime_types['mpeg']  ='video/mpeg';
$mime_types['mpg']   ='video/mpeg';
$mime_types['pdf']   ='application/pdf';
$mime_types['pps']   ='application/vnd.ms-powerpoint';
$mime_types['ppt']   ='application/vnd.ms-powerpoint';
$mime_types['ps']    ='application/postscript';
$mime_types['pub']   ='application/x-mspublisher';
$mime_types['qt']    ='video/quicktime';
$mime_types['rtf']   ='application/rtf';
$mime_types['svg']   ='image/svg+xml';
$mime_types['swf']   ='application/x-shockwave-flash';
$mime_types['tif']   ='image/tiff';
$mime_types['tiff']  ='image/tiff';
$mime_types['txt']   ='text/plain';
$mime_types['wav']   ='audio/x-wav';
$mime_types['wmf']   ='application/x-msmetafile';
$mime_types['xls']   ='application/vnd.ms-excel';
$mime_types['zip']   ='application/zip';
	if(array_key_exists($ext,$mime_types)){
	$mimetype = $mime_types[$ext];
	}
    else{ $mimetype = 'application/force-download';}
return $mimetype;
}
?>
