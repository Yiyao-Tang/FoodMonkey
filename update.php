<?php
include "dbconnect.php";
session_start();  
$userId = $_SESSION['sess_user_id'];
	
if (isset($_POST['submit'])) {
	if (empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['email']) || empty($_POST['username']) || empty ($_POST['password'])) {
	echo "All records to be filled in";
	exit;}
	}
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];    
$username = $_POST['username'];
$password = $_POST['password'];
$sql = "UPDATE user SET first_name='$firstName', last_name = '$lastName', user_name = '$username', email = '$email', password='$password' WHERE user_id=$userId;";

$result = $dbcnx->query($sql);
if (!$result) 
	echo "Your query failed.";
else
	echo "Welcome ". $username . ". You are now registered";
	session_start();  
    $_SESSION['sess_user']=$username;
	$user_query ="SELECT * FROM user WHERE user_name='".$username."' AND password='".$password."'";
	$user_result = $dbcnx->query($user_query);
	$row_user = $user_result->fetch_assoc();
	$_SESSION['sess_user_id']=$row_user['user_id'];
	header("location:index.php");
?>