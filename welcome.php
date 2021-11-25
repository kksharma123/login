<?php session_start(); 
if(!$_SESSION['email'])  {    
    header("Location: login.php");
} ?>  
<html lang="en">  
<head>
  <meta charset="utf-8">
  <title>Welcome</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head> 
<body> 
<div class="container"> 
		<h1>Welcome</h1>  
		<?php $email = $_SESSION['email'];
		include("database/db_conection.php");
		  $query=mysqli_query($dbcon,"SELECT * FROM user_data where user_email='$email'")or die(mysqli_error());
		  $row=mysqli_fetch_array($query);
			if(empty($row)){
					$full_name= '';
					$age= '';
					$address= '';
					$gender= '';
			}else{
					$id = $row['id'];
					$full_name= $row['full_name'];
					$age= $row['age'];;
					$gender= $row['gender'];;
					$address= $row['address'];
					$profileImage= $row['profile_image'];
				}
		?>
	 <form method="post" action="#" enctype="multipart/form-data" id="profileForm">
	 	<div class="form-group">
	        <label>Profile Picture</label>
	        <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" accept="image/png, image/jpeg" />
          </div>
          <?php if($profileImage):?>
         <img id="preview" src="<?= $profileImage ? 'profileImages/'.$profileImage : ''?>" style="width:100px;" >
     <?php else :?>
     	 <img id="preview" src="" style="width:100px;display: none" >
     <?php endif;?>
          <input type="hidden" value="<?= $email ;?>" name="email">
          <div class="form-group">
	        <label>Fullname</label>
	        <input type="text" class="form-control" name="fname" style="width:20em;" placeholder="Enter your Fullname" value="<?= $full_name ?>" required />
          </div>
          <div class="form-group">
            <label>Gender</label>
            <input type="text" class="form-control" name="gender" style="width:20em;" placeholder="Enter your Gender" required value="<?= $gender ?>" />
          </div>
          <div class="form-group">
            <label>Age</label>
            <input type="number" class="form-control" name="age" style="width:20em;" placeholder="Enter your Age" value="<?= $age ?>">
          </div>
          <div class="form-group">
            <label>Address</label>
            <input type="text" class="form-control" name="address" style="width:20em;" required placeholder="Enter your Address" value="<?= $address ?>"></textarea>
          </div>
          <div class="form-group">
          	 <input type="hidden" class="form-control" name="formsubmit" style="width:20em;" placeholder="Enter your Age" value="submit">
            <input type="submit" name="submit" class="btn btn-primary" style="width:20em; margin:0;"><br><br>
            <center>
             <a href="logout.php">Log out</a>
           </center>
          </div>
        </form>

		 <div class="panel-group">
	        <div class="panel panel-success custom_panel" style="display: none">
	    		  <div class="panel-heading">Profile Updated Successfully</div>
	    	</div>
		</div>
	<?php 
	//echo get_all_records();
	function get_all_records(){
		include("database/db_conection.php");
	    $email = $_SESSION['email'];
	    $sql = "SELECT * FROM user_data where user_email='$email'";
	    $result = mysqli_query($dbcon, $sql);  
	    if (mysqli_num_rows($result) > 0) {
	     echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
	             <thead>
		             <tr>
			              <th>User ID</th>
				          <th>Full Name</th>
				          <th>Age</th>
				          <th>Gender</th>
				          <th>Address</th>
		              </tr>
	              </thead>
	            <tbody>";
	     while($row = mysqli_fetch_assoc($result)) {
	         echo "<tr>
	         		   <td>" . $row['id']."</td>
	         		   <td>".$row['full_name']."</td>
	                   <td>" . $row['age']."</td>
	                   <td>" . $row['gender']."</td>
	                   <td>" . $row['address']."</td>
	              </tr>";        
	     }
	     echo "</tbody>
	     </table>
	    </div>";?>
	    <div>
		<form class="form-horizontal" action="export.php" method="post" name="upload_excel"   
		          enctype="multipart/form-data">
		      <div class="form-group">
		                <div class="col-md-4 col-md-offset-4">
		                    <input type="submit" name="Export" class="btn btn-success" value="Export to excel"/>
		                </div>
		       </div>                    
		</form>           
	 </div>
	<?php } else {
	     echo "you have no records";
		}
	} ?> 

	<div id="wrap">
        <div class="container">
            <div class="row">
                <form class="form-horizontal" action="import.php" method="post" name="upload_excel" enctype="multipart/form-data">
                    <fieldset>
                        <!-- Form Name -->
                        <legend>Import File</legend>
                        <!-- File Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="filebutton">Select File</label>
                            <div class="col-md-4">
                                <input type="file" name="file" id="file" class="input-large">
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                            <div class="col-md-4">
                                <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <?php
               get_all_records();
            ?>
        </div>
    </div>
</div>
		<script>
		$(document).ready(function() {
			 var input = document.querySelector('#fileToUpload');
		     var preview = document.querySelector('#preview');

		      input.addEventListener('change', function () {
		        	preview.src = URL.createObjectURL(this.files[0]);
		   	 });

		    preview.addEventListener('load', function () {
			        URL.revokeObjectURL(this.src);
			        preview.style.display ='block' ;
		     });

		   $('#profileForm').submit(function(e) {
		        e.preventDefault();
		        var formData = new FormData(this);
		        $.ajax({
		            type: "POST",
		            url: 'update_user_data.php',
		            data: formData,
		            cache: false,
			        contentType: false,
			        processData: false,
			        success: function(data) {
			           console.log(data);
			           	$('.custom_panel').css('display','block');
			           	setTimeout(function(){ location.reload() }, 3000);
			      },
			      error: function() {
			           alert('There was some error performing the AJAX call!');
			      }
			});
		});
		})

		</script>
</body>  
</html>