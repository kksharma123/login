<?php session_start(); 
if(!$_SESSION['email'])  {    
    header("Location: login.php");
}  
include("database/db_conection.php");
$email= $_SESSION['email'];
 if(isset($_POST["Import"])){
    $filename=$_FILES["file"]["tmp_name"];    
     if($_FILES["file"]["size"] > 0)
     {
        $file = fopen($filename, "r");
          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
                  $query=mysqli_query($dbcon,"SELECT * FROM user_data where user_email='$email'")or die(mysqli_error());
                  $row=mysqli_fetch_array($query);
                 if(empty($row)){
                    $query = "INSERT INTO user_data (user_email, profile_image, full_name, age, gender,address)  VALUES ('".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."')";
                    //echo $query;
                     $result=  mysqli_query($dbcon,$query)or die ('Error in inserting into Database');
                    }else{
                      //print_r($getData);
                        $query = "UPDATE user_data SET 
                        profile_image ='$getData[2]',
                        full_name= '$getData[3]',
                        age='$getData[4]',
                        gender= '$getData[5]',
                        address='$getData[6]'
                        WHERE user_email='$email'";
                        }
                        echo $query;
                        $result = mysqli_query($dbcon,$query) or die ('Error in updating into Database');

                    }
        if(!isset($result)) {
          echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"welcome.php\"
              </script>";    
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"welcome.php\"
          </script>";
        }
     }
       fclose($file);  
     }
    

  ?>