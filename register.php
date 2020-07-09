<html> 

<head>
<link rel="stylesheet" href="register.css" /> 
<style>

.bg {
	color : white;
	 background-color: rgb(0,0,0); 
  background-color: rgba(0,0,0, 0.4); 
  color: white;
  font-weight: bold;
  text-align: center;
  border: 3px solid #f1f1f1;
  position: absolute;
  top: 50%;
  left: 50%;
  z-index: 2;
  width: 80%;
  padding: 20px;
  transform: translate(-50%, -50%);
  
}
.ex{
	height:			40px;
	width:			100px;
	border:			none;
	font-size: 15px;
	background-color : #96c1f2;
}

</style>
</head>
<body>
<center>
<form method="post">
<div class="bg"> 
  <b> Username<b>
    <input type="text" placeholder="Enter Username" name="user" id="user" required>
	<br>
	<br>
	<br>
	<b>Email</b>
    <input type="text" placeholder="Enter Email" name="email" id="email" required>
<br><br>
	<br>
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" id="password" required>
<br><br>
	<br>
    <label for="psw-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="repassword" id="repassword" required>
	<br><br>
	<br>
	<label for="int_lat"><b>Initial Latitude</b></label>
    <input type="float" placeholder="Enter Initial Latitude" name="int_lat" id="int_lat" required>
	<br> <br>
	<br>
	<label for="int_lng"><b>Initial Longitude</b></label>
    
	<input type="float" placeholder="Enter Initial Longitude" name="int_lng" id="int_lng" required>
	<br><br>
	<br><label for="int_lng"><b>API 1</b></label>
    <input type="text" placeholder="API1" name="api1" id="api1" required>
	
	<br><br>
	<br><label for="int_lng"><b>API 2</b></label>
    <input type="text" placeholder="API2" name="api2" id="api2" required>
	<br><br>
	<br>


	
<input class="ex" type="submit" name="submit" value="submit"/>
</div>	
</form>
</center>
<body>
</html>

<?php
include ("db.php");
error_reporting(0);
session_start();
if(isset($_POST['submit'])){
	$name=$_POST['user'];
	$password=$_POST['password'];
	$repassword=$_POST['repassword'];
	$email=$_POST['email'];
	$lng=$_POST['int_lng'];
	$lat=$_POST['int_lat'];
	$api1= $_POST['api1'];
	$api2=$_POST['api2'];
	//echo $api2;
	$emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
	if($password != $repassword){
		
		echo " doesnt match";
	}
	if(!preg_match($emailValidation,$email)){
		echo " email doesnt match";
	}
	$sql = "SELECT user_id FROM users WHERE email = '$email' LIMIT 1" ;
	$check_query = mysqli_query($con,$sql);
	$count_email = mysqli_num_rows($check_query);
	if($count_email > 0){
		echo "
			<b>Email Address is already available Try Another email address</b>
			</div>
		";
		
	}
	
	else{
		
	$sql="INSERT INTO USERS ( username, password, email, initial_lat, initial_lng, api1,api2 )  
	values ('$name', '$password', '$email', '$lng', '$lat' , '\'$api1\'', '\'$api2\'')";
	$r=mysqli_query($con,$sql);
	if($r){
		$_SESSION['$user']=$name;
		header('location:registrationgf.php') ;
	}
	
}
}
?>