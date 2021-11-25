<?php
session_start(); ?>
<html lang="en">  
<head>
  <title>Index</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head> 
<body>

<?php
if(isset($_SESSION["email"])) { ?>
Welcome <?php echo $_SESSION["email"]; ?>. Click here to <a href="logout.php" tite="Logout">Logout.
<?php
}else {
	echo "<h1>Please login first</h1>";
	echo "<a href='login.php'>Click here to Login</a>";
}?>
</body>
</html>