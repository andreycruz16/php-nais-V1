<?php
	session_start();
	require '../../database.php';
	
	/*ACTIVITY LOG*/
	$sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
	                                           '".$_SESSION['user_id']."',
	                                           now(),
	                                           1,
	                                           'User has logged out'
	                                           );";        
	mysqli_query($conn, $sql);
	mysqli_close($conn);

	if(session_destroy()) { // Destroying All Sessions
		header("Location: .../../index.php"); // Redirecting to Login Page
	}
?>