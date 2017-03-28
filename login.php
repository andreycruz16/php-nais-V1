<?php
    session_start(); // Starting Session
    require 'database.php';
    if(!empty($_POST)) {
        if(empty($_POST['username']) || empty($_POST['password'])) { //checks if textfields is empty
            echo "<script>alert('ENTER A VALID PASSWORD'); window.location.href = 'index.php'</script>s";
        } else {
            // Define $username and $password
            $username = $_POST['username'];
            $password = $_POST['password'];

            // To protect MySQL injection for Security purpose
            $username = stripslashes($username);
            $username = mysqli_real_escape_string($conn, $username);

            $password = stripslashes($password);
            $password = mysqli_real_escape_string($conn, $password);

            //User Permissions
            $result = mysqli_query($conn, "SELECT * FROM tbl_users WHERE username='$username' AND password = '".md5($password)."';");

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result, MYSQL_NUM)) {   
                    $_SESSION['user_id'] = $row[0];
                    $_SESSION['userType_id'] = $row[1];
                    $_SESSION['username'] = $row[2];
                    $_SESSION['firstName'] = $row[4]; 
                    $_SESSION['lastName'] = $row[5];
                    $_SESSION['contactNumber'] = $row[6];
                    $_SESSION['displayPicture'] = $row[7];
                    $_SESSION['isFirstLogin'] = true;
                }
                $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
                                                               '".$_SESSION['user_id']."',
                                                               now(),
                                                               1,
                                                               'User has logged in'
                                                               );";
            } else {
                echo "<script>alert('Invalid login details'); window.location.href = 'index.php'</script>s";
            }                           
            mysqli_query($conn, $sql);
            mysqli_close($conn);
        }
    }
    header("location: index.php");
    exit();
?>