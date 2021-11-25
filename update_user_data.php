<?php 
include("database/db_conection.php");
$target_dir = "profileImages/";

if(isset($_POST['formsubmit'])){
    $email = $_POST['email'];
    $full_name = $_POST['fname'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    //print_r($_POST);
    if($_FILES['fileToUpload']['name']){
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            
            $file_name = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
        } else {
            $result['result'] = "Sorry, there was an error uploading your file.";
        }
    }
    $query=mysqli_query($dbcon,"SELECT * FROM user_data where user_email='$email'")or die(mysqli_error());
    $row=mysqli_fetch_array($query);

     if(empty($row)){
        $query = "INSERT INTO user_data (user_email, profile_image, full_name, age, gender,address)  VALUES ('".$email."','".$file_name."','".$full_name."','".$age."','".$gender."','".$address."')";
        //echo $query;
         $result['result']=  mysqli_query($dbcon,$query)or die ('Error in inserting into Database');
        }else{
            if($file_name){
            $query = "UPDATE user_data SET 
            profile_image ='$file_name',
            full_name= '$full_name',
            gender= '$gender',
            age='$age',
            address='$address'
            WHERE user_email='$email'";
            }else{
            $query = "UPDATE user_data SET 
            full_name= '$full_name',
            gender= '$gender',
            age='$age',
            address='$address'
            WHERE user_email='$email'";
        }
            //echo $query;
            $result['result'] = mysqli_query($dbcon,$query) or die ('Error in updating into Database');

        }
        echo json_encode($result);
}
?>