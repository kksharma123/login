<?php  session_start(); 

if(!$_SESSION['email'])  {    
    header("Location: login.php");
}  
include("database/db_conection.php");
$email= $_SESSION['email'];

if(isset($_POST["Export"])){
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=data.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('ID', 'Email', 'Profile Image', 'Full Name', 'Age', 'Gender', 'Address'));  
      $query = "SELECT * FROM user_data where user_email='$email'";  
      $result = mysqli_query($dbcon, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  

 ?>