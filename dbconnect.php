<?php
@$dbcnx = new mysqli('localhost','root','','FoodMonkey');
if ($dbcnx->connect_error){
	echo "Cannot connect to database"; 
	exit;
	}
if (!$dbcnx->select_db ("FoodMonkey"))
	exit("<p>Unable to locate the FoodMonkey database</p>");
?>	