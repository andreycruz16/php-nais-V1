<?php 
    session_start();
	require '../../../database.php';

	if (!empty($_POST)) {
        $userType_id = $_POST['userType_id'];
        $userType_id = mysqli_real_escape_string($conn, $userType_id);
        $userType_id = trim($userType_id);

        $user_id = $_POST['user_id'];
        $user_id = mysqli_real_escape_string($conn, $user_id);
        $user_id = trim($user_id);

        $username = $_POST['username'];
        $username = mysqli_real_escape_string($conn, $username);
        $username = trim($username);            

        $sql = "UPDATE tbl_users SET userType_id ='".$userType_id."' WHERE user_id = ".$user_id.";";
        $retval = mysqli_query($conn, $sql); 

        if ($retval) {
            /*ACTIVITY LOG*/
            $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
                                                     ".$_SESSION['user_id'].",
                                                     now(),
                                                     5,
                                                     'User ".$username."'
                                                     );";  /*5 is maintenance activity type*/
            mysqli_query($conn, $sql);
            echo "<script>alert('USER TYPE CHANGED SUCCESSFULLY.'); window.location.href = '../userDetails.php?user_id=".$user_id."'</script>";
        } 
    } else {
        echo "<script>alert('AN ERROR OCCURED. USER TYPE NOT CHANGED.'); window.location.href = '../userDetails.php?user_id=".$user_id."'</script>";
    }
    mysqli_close($conn);

 ?>