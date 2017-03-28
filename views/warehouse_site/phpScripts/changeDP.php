<?php
    session_start();
    require '../../../database.php';

    if(isset($_POST)) {
		$uploaddir = '../../../assets/img/userProfile/';
		$uploadfile = $uploaddir . basename($_FILES['userPicture']['name']);

		if (move_uploaded_file($_FILES['userPicture']['tmp_name'], $uploadfile)) {
			// echo "<script>alert('FILE IS VALID, AND WAS SUCCESSFULLY UPLOADED.');</script>";
			$sql = "UPDATE tbl_users SET displayPicture = '".basename($_FILES['userPicture']['name'])."' WHERE user_id = ".$_SESSION['user_id'].";";
			// echo $sql;
			$retval = mysqli_query($conn, $sql); 

			if ($retval) {
			  /*ACTIVITY LOG*/
			  $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
			                                           ".$_SESSION['user_id'].",
			                                           now(),
			                                           7,
			                                           'Changed Display Picture'
			                                           );";  /*5 is maintenance activity type*/
			  mysqli_query($conn, $sql);
			  $_SESSION['displayPicture'] = basename($_FILES['userPicture']['name']);
			  // echo "<script>alert('DISPLAY PICTURE CHANGED SUCCESSFULLY.'); window.location.href = '../accountSettings.php'</script>";
			  echo "<script>window.location.href = '../accountSettings.php'</script>";
			} 
		} else {
		   	echo "<script>alert('UPLOAD FAILED. FILE IS NOT VALID.'); window.location.href = '../accountSettings.php'</script>";
		}
		//upload details
		// echo '<pre>';
		// echo 'Here is some more debugging info:';
		// print_r($_FILES);
		// print "</pre>";
		// echo basename($_FILES['userPicture']['name']);
	} else {
		echo "<script>alert('AN ERROR OCCURED. DISPLAY PICTURE NOT CHANGED.'); window.location.href = '../accountSettings.php'</script>";
	}	
	mysqli_close($conn);

?> 