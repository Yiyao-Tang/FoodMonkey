<?php
include "dbconnect.php";
if (isset($_POST['login'])) {
	if (empty($_POST['username']) || empty ($_POST['password'])) {
	echo "All records to be filled in";
	exit;}
	}   
$username = $_POST['username'];
$password = $_POST['password'];

$query ="SELECT * FROM user WHERE user_name='".$username."' AND password='".$password."'";
$result = $dbcnx->query($query);
if ($result!=0){
    while ($row = $result->fetch_assoc()){
        $dbusername=$row['user_name'];  
        $dbpassword=$row['password'];
        $dbuserID=$row['user_id'];
    }
    if($username == $dbusername && $password == $dbpassword)  
        {  
        session_start();  
        $_SESSION['sess_user']=$username;
        $_SESSION['sess_user_id']=$dbuserID;
        header("Location: index.php");  
        }
    else{
        header("Location:login-fail.html");
    }  
    } 
else {  
    header("Location:login-main.php");  
    }
?>