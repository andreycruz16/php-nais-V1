<?php 
    session_start();
	require '../../../database.php';

    if (!empty($_POST)) {
        $user_id = $_POST['user_id'];

        $username = $_POST['username'];
        $username = mysqli_real_escape_string($conn, $username);
        $username = trim($username);

        $userType = $_POST['userType'];
        $userType = mysqli_real_escape_string($conn, $userType);
        $userType = trim($userType);

        $password = $_POST['password'];
        $password = mysqli_real_escape_string($conn, $password);
        $password = trim($password);        

        $sql = "SELECT user_id, username, password FROM tbl_users WHERE user_id = '".$user_id."' AND password = '".md5($password)."';";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {

            // DELETE RECORD QUERY
            $sql = "DELETE FROM tbl_users WHERE user_id = ".$user_id.";";        
            mysqli_query($conn, $sql);

            /*ACTIVITY LOG*/
            $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
                                                         '".$_SESSION['user_id']."',
                                                         now(),
                                                         5,
                                                         'Removed user \"".$username."\". User Type: \"".$userType."\"'
                                                         );";        
            mysqli_query($conn, $sql);

            echo "<script>alert('USER DELETED SUCCESSFULLY.'); window.location.href = '../userManagement.php'</script>";
        } else {
            echo "<script>alert('PASSWORD INCORRECT. USER NOT DELETED.'); window.location.href = '../userManagement.php'</script>";
        }        



    } else {
           echo "<script>alert('AN ERROR OCCURED. USER NOT DELETED.'); window.location.href = '../userManagement.php'</script>";
    }

    mysqli_close($conn);
 ?>