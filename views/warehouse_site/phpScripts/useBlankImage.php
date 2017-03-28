<?php
    session_start();
    require '../../../database.php';

    if(isset($_GET)) { 	
		$sql = "UPDATE tbl_users SET displayPicture = 'default.png' WHERE user_id = ".$_SESSION['user_id'].";";
		// echo $sql;
		$retval = mysqli_query($conn, $sql);         
		if ($retval) {
		/*ACTIVITY LOG*/
		$sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
			                                 ".$_SESSION['user_id'].",
			                                 now(),
			                                 7,
			                                 'Changed Display Picture'
			                                 );"; 
		mysqli_query($conn, $sql);
		$_SESSION['displayPicture'] = 'default.png';
		// echo "<script>alert('DISPLAY PICTURE CHANGED SUCCESSFULLY.'); window.location.href = '../accountSettings.php'</script>";
		echo "<script>window.location.href = '../accountSettings.php'</script>";
		} 
	} else {
		echo "<script>alert('AN ERROR OCCURED. DISPLAY PICTURE NOT CHANGED.'); window.location.href = '../accountSettings.php'</script>";
	}	
	mysqli_close($conn);

?> 