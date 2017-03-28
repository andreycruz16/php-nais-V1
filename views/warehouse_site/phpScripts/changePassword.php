<?php 
    session_start();
	require '../../../database.php';

	if (!empty($_POST)) {
        $oldPassword = $_POST['oldPassword'];
        $oldPassword = mysqli_real_escape_string($conn, $oldPassword);
        $oldPassword = trim($oldPassword);

        $newPassword1 = $_POST['newPassword1'];
        $newPassword1 = mysqli_real_escape_string($conn, $newPassword1);
        $newPassword1 = trim($newPassword1);        

        $newPassword2 = $_POST['newPassword2'];
        $newPassword2 = mysqli_real_escape_string($conn, $newPassword2);
        $newPassword2 = trim($newPassword2);     

        $sql = "SELECT username, password FROM tbl_users WHERE username = '".$_SESSION['username']."' AND password = '".md5($oldPassword)."';";
        // echo $sql;
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            if($newPassword1 == $newPassword2) {
                $sql = "UPDATE tbl_users SET password ='".md5($newPassword1)."' WHERE user_id = ".$_SESSION['user_id'].";";
                $retval = mysqli_query($conn, $sql); 

                if ($retval) {
                    /*ACTIVITY LOG*/
                    $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
                                                             '".$_SESSION['user_id']."',
                                                             now(),
                                                             5,
                                                             'Password Changed'
                                                             );";  /*5 is accountSettings activity type*/
                    mysqli_query($conn, $sql);
                    echo "<script>alert('PASSWORD CHANGED SUCCESSFULLY.'); window.location.href = '../accountSettings.php'</script>";
                                                                          
                } 
            } else {
                    echo "<script>alert('NEW PASSWORD DOES NOT MATCH.'); window.location.href = '../accountSettings.php'</script>";
            }
        } else {
             echo "<script>alert('INCORRECT CURRENT PASSWORD.'); window.location.href = '../accountSettings.php'</script>";
        } 
    } else {
        echo "<script>alert('AN ERROR OCCURED. DATABASE RECORDS NOT CLEARED.'); window.location.href = '../accountSettings.php'</script>";
    }

    mysqli_close($conn);

 ?>