<?php  

if ($id = $_GET["id"]) 
{
    include("events_desc_in.php");   
} 
else 
{
    include("events_reg_in.php");
}

?>


