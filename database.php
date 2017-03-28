<?php 
	// $conn = mysqli_connect('mysql13.000webhost.com', 'a1814542_nichiyu', 'mark123', 'a1814542_nichiyu') or die(mysql_error());
	$server_name   = "localhost";
	$username      = "root";
	$password      = "";
	$database_name = "db_nichiyu_new";

	$conn = mysqli_connect($server_name, $username, $password, $database_name) or die(mysql_error());
 ?>