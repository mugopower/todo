<?php
	$host = "localhost"; // Enter your database host/server
	$db_name = ""; // Enter your database name
	$db_user = ""; // Enter your username
	$db_pass = ""; // Enter your password	
	try {
		$conn = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);
	} catch (Exception $e) {
		echo $e->getMessage();	
	}		
?>