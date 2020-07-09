<?php
include ("db.php");
error_reporting(0);
session_start();
$query = " SELECT * FROM location WHERE user='$profile'";
$data = mysqli_query($con , $query);
$result= unserialize($data);  
echo $result;

$profile=$_SESSION['$user'];

//unset($_SESSION['$user']);

//unset($_SESSION["name"]);

//header("location:login.php");

?>