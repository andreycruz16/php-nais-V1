<?php 
    session_start();
    require '../../../database.php';
	if (!empty($_POST)) {
        $username = $_POST['username'];
        $username = mysqli_real_escape_string($conn, $username);
        $username = trim($username);

        $password = $_POST['password'];
        $password = mysqli_real_escape_string($conn, $password);
        $password = trim($password);

        $userType_id = $_POST['userType_id'];
        $userType_id = mysqli_real_escape_string($conn, $userType_id);
        $userType_id = trim($userType_id);


        $sql = "INSERT INTO tbl_users VALUES(NULL,
                                            '".$username."',
                                            '".md5($password)."',
                                             ".$userType_id.",
                                             'N/A',
                                             'N/A',
                                             'N/A',
                                             'default.png');";
        $retval = mysqli_query($conn, $sql);

         $sql = "SELECT
			  tbl_user_type.userType
			FROM
			  tbl_user_type
			WHERE
			  userType_id = ".$userType_id.";";	

         $result = mysqli_query($conn, $sql);
         if (mysqli_num_rows($result) > 0) {
             while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
                 $userType = $row[0];
             }
         }

        if($retval) {
            $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
                                                     '".$_SESSION['user_id']."',
                                                     now(),
                                                     5,
                                                     'New User \"".$username."\" created. User Type: \"".$userType."\"'
                                                     );";                    
            mysqli_query($conn, $sql);
            echo "<script>alert('NEW USER ADDED SUCCESSFULLY.'); window.location.href = '../userManagement.php'</script>";
        } 
        mysqli_close($conn);
    } else {
        echo "<script>alert('AN ERROR OCCURED. USER ADD FAILED.'); window.location.href = '../userManagement.php'</script>";
    }
 ?>