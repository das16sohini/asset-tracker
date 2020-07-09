<?php
include ("db.php");
error_reporting(0);
session_start();

//$_SESSION["username"]
//$query = "Select * FROM USERS WHERE   ";
?>
<html>
<head>
<title> Tracker </title>

<link rel="stylesheet" href="logincss.css"/>


</head>
<body>
<div class="login-box"><h2> LOGIN FORM </h2>
<div class="user-box">
<form action="" method="post">
<input type="text" name="user" value=""/><br><br> <label>Username</label>
    </div>
    <div class="user-box">
<input type="password" name="password" value=""/><br><br><label>Password</label>
    </div>
   <a>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
	  
      <input class="ex" type="submit" name="submit" value="login"/>
    </a>
	<a href="register.php"> NEW USER? </a>
  </form>
</div>
<?php
if(isset($_POST['submit']))
{
	$user =  $_POST["user"];
	$pwd = $_POST["password"];
	$query = " SELECT * FROM USERS WHERE username='$user' && password='$pwd' ";
	$data = mysqli_query($con , $query);
	$total = mysqli_num_rows($data);
	if($total)
	{
		$_SESSION['$user']=$user;
		header('location:with1.php') ;
	}
	else echo "login not ok";
}
?>
</div>
</body>
</html>