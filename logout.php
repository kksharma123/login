<?php  
/** 
 * Created by Krishan Kant Sharma. 
 */  
session_start(); 
session_destroy();  
header("Location: login.php");
?> 