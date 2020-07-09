<?php
include ("db.php");
error_reporting(0);
session_start();


$profile=$_SESSION['$user'];
echo " welcome".$profile ;
$query = " SELECT * FROM USERS WHERE username='$profile'";
$data = mysqli_query($con , $query);
$result= mysqli_fetch_assoc($data);  
echo  $result['email'];
?>
<html>
<head>
<link rel="stylesheet" href="register.css" /> 
<style>

body{
	 background: linear-gradient(#141e30, #243b55, #141e30);
}
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

<div class="bg" >
<form method="post">
	<?php echo "<h2>For Geo-fence:</h2>" ?>
	
	<?php echo "<h2>Co-ordinate 1:</h2>" ?>
	<center>
	<table>
	
	<tr>
	<td>
	<label for="lat1"><b>Latitude :</b></label> 
   <input type="text" placeholder="Enter First Latitude" name="lat1" value="" required></td>
	 <td>
	<label for="lng1"><b>Longitude :</b></label> 
    <input type="text" placeholder="Enter First Longitude" name="lng1" value="" required> </td>
	</table>
	<?php echo "<h2>Co-ordinate 2:</h2>" ?>
	
	<label for="lat2"><b>Latitude :</b></label>
    <input type="text" placeholder="Enter Second Latitude" name="lat2" value="" required>
	
	<label for="lng2"><b>Longitude :</b></label>
    <input type="text" placeholder="Enter Second Longitude" name="lng2" value="" required>
	
	<?php echo "<h2>Co-ordinate 3:</h2>" ?>
	
	<label for="lat3"><b>Latitude :</b></label>
    <input type="text" placeholder="Enter Third Latitude" name="lat3" value="" required>
	
	<label for="lng3"><b>Longitude :</b></label>
    <input type="text" placeholder="Enter Third Longitude" name="lng3" value="" required>
	
	<?php echo "<h2>Co-ordinate 4:</h2>" ?>
	
	<label for="lat4"><b>Latitude :</b></label>
    <input type="text" placeholder="Enter Fourth Latitude" name="lat4" value="" required>
	
	<label for="lng4"><b>Longitude :</b></label>
    <input type="text" placeholder="Enter Fourth Longitude" name="lng4" value="" required>
	<br>
	<br>
	<br>
	
	<input class="ex" type="submit" name="submit" value="submit"/>
</form>
</div>
</center>
<body>
</html>
<?php
if (isset($_POST["submit"])) {
	$lat1 = $_POST['lat1'];
	$lat2= $_POST['lat2'];
	$lat3 = $_POST['lat3'];
	$lat4 = $_POST['lat4'];
	$lng1 = $_POST['lng1'];
	$lng2 = $_POST['lng2'];
	$lng3 = $_POST['lng3'];
	$lng4 = $_POST['lng4'];
	$sql="INSERT INTO GEOFENCE ( username, lat1, lat2, lat3, lat4, lng1, lng2, lng3, lng4 ) 
	values ('$profile', '$lat1','$lat2','$lat3','$lat4', '$lng1', '$lng2', '$lng3', '$lng4')";
	$r=mysqli_query($con,$sql);
	if($r){
		$_SESSION['$user']=$user;
		header('location:login.php') ;
		echo "LOGIN WITH YOUR USERNAME AND PASSWORD";
	}
}