<?php
	session_start();
	require '../../../database.php';

	if(isset($_POST)) {

	$username = $_POST['username'];
	$username = mysqli_real_escape_string($conn, $username);
	$username = trim($username);

	$firstName = $_POST['firstName'];
	$firstName = mysqli_real_escape_string($conn, $firstName);
	$firstName = trim($firstName);

	$lastName = $_POST['lastName'];
	$lastName = mysqli_real_escape_string($conn, $lastName);
	$lastName = trim($lastName);

	$contactNumber = $_POST['contactNumber'];
	$contactNumber = mysqli_real_escape_string($conn, $contactNumber);
	$contactNumber = trim($contactNumber);		

	$sql = "UPDATE
			  tbl_users
			SET
			  tbl_users.username = '".$username."',
			  tbl_users.firstName = '".$firstName."',
			  tbl_users.lastName = '".$lastName."',
			  tbl_users.contactNumber = '".$contactNumber."'
			WHERE
			  user_id = ".$_SESSION['user_id'].";";

	$retval = mysqli_query($conn, $sql); 
	if ($retval) {
   	$_SESSION['username'] = $username;

	  /*ACTIVITY LOG*/
	  $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
	                                           '".$_SESSION['user_id']."',
	                                           now(),
	                                           7,
	                                           'Updated User Profile'
	                                           );";  /*3 is update for activity type*/
	  mysqli_query($conn, $sql);
	  echo "<script>alert('PROFILE DETAILS UPDATED SUCCESSFULLY.'); window.location.href = '../accountSettings.php'</script>";
	                                                        
	} else {
	  echo "<script>alert('AN ERROR OCCURED. UPDATE NOT SAVED. CHECK YOUR INPUTS. TRY AGAIN.'); window.location.href = '../accountSettings.php'</script>";
	}
	mysqli_close($conn);	

	}

?> 