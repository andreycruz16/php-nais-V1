<?php 
    session_start();
	require '../../../database.php';

    if (!empty($_POST)) {
        $stock_id = $_POST['stock_id'];

        $description = $_POST['description'];
        $description = mysqli_real_escape_string($conn, $description);
        $description = trim($description);

        $partNumber = $_POST['partNumber'];
        $partNumber = mysqli_real_escape_string($conn, $partNumber);
        $partNumber = trim($partNumber);

        // DELETE RECORD QUERY
        $sql = "DELETE FROM tbl_warehouse WHERE stock_id = ".$stock_id.";";        
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM tbl_warehouse_history WHERE stock_id = ".$stock_id.";";        
        mysqli_query($conn, $sql);

        /*ACTIVITY LOG*/
        $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
                                                     '".$_SESSION['user_id']."',
                                                     now(),
                                                     4,
                                                     'Item \"".$description."\" with part number of \"".$partNumber."\"'
                                                     );";        
        mysqli_query($conn, $sql);

        echo "<script>alert('ITEM DELETED SUCCESSFULLY.'); window.location.href = '../index.php'</script>";
    } else {
           echo "<script>alert('AN ERROR OCCURED. ITEM NOT DELETED.'); window.location.href = '../index.php'</script>";
    }

    mysqli_close($conn);
 ?>