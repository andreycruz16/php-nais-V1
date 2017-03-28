<?php
	session_start();
	require '../../../database.php';
	if (!empty($_POST)) {
		$password = $_POST['password'];
		$password = mysqli_real_escape_string($conn, $password);
		$password = trim($password);

		$sql = "SELECT user_id, username, password FROM tbl_users WHERE username = '".$_SESSION['username']."' AND password = '".md5($password)."';";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// Truncate Tables
			$sql = "DROP DATABASE ".$database_name.";";        
			mysqli_query($conn, $sql);
			$sql = "CREATE DATABASE db_nichiyu;";
			mysqli_query($conn, $sql);

			$sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
	                            ".$_SESSION['user_id'].",
	                            now(),
	                            5,
	                            'User has cleared the database.'
	                            );";    
			mysqli_query($conn, $sql);
			echo "<script>alert('DATABASE RECORDS SUCCESSFULLY CLEARED. '); window.location.href = '../maintenance.php'</script>";
		} else {
	  		echo "<script>alert('INCORRECT PASSWORD. TRY AGAIN.'); window.location.href = '../maintenance.php'</script>";
		}		
	} else {
	     echo "<script>alert('AN ERROR OCCURED. DATABASE RECORDS NOT CLEARED.'); window.location.href = '../maintenance.php'</script>";
	}
	mysqli_close($conn);

?>