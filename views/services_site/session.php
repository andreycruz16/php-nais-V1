<?php
	require '../../database.php';
	session_start();// Starting Session
	$username = $_SESSION['username'];
	$userType = $_SESSION['userType_id'];
	// SQL Query To Fetch Complete Information Of User
	
	if(!isset($username)){
		mysqli_close($conn); // Closing Connection
		header('Location: ../../index.php'); // Redirecting To Home Page
	}
	if($userType != 3) {
		mysqli_close($conn); // Closing Connection
		header('Location: ../../index.php'); // Redirecting To Home Page
	}
?>