<?php 
    session_start();
	require '../../../database.php';
	if (!empty($_POST)) {
        $stock_id = $_POST['stock_id'];
        $stock_id = mysqli_real_escape_string($conn, $stock_id);
        $stock_id = trim($stock_id);

        $description = $_POST['description'];
        $description = mysqli_real_escape_string($conn, $description);
        $description = trim($description);        

        $boxNumber = $_POST['boxNumber'];
        $boxNumber = mysqli_real_escape_string($conn, $boxNumber);
        $boxNumber = trim($boxNumber);                      

        $minStockCount = $_POST['minStockCount'];
        $minStockCount = mysqli_real_escape_string($conn, $minStockCount);
        $minStockCount = trim($minStockCount);

        $sql = "UPDATE tbl_warehouse SET boxNumber ='".$boxNumber."',   
                                         minStockCount =".$minStockCount."
                WHERE  stock_id = ".$stock_id.";";

	    $retval = mysqli_query($conn, $sql); 
        if ($retval) {
            /*ACTIVITY LOG*/
            $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
                                                     '".$_SESSION['user_id']."',
                                                     now(),
                                                     3,
                                                     '\"".$description."\" minimum stock count was changed to ".$minStockCount." and box number to ".$boxNumber."'
                                                     );";  /*3 is update for activity type*/
            mysqli_query($conn, $sql);
            echo "<script>alert('OPTIONAL DETAILS UPDATED SUCCESSFULLY.'); window.location.href = '../moreDetails.php?stock_id=".$stock_id."'</script>";
                                                                  
        } else {
            echo "<script>alert('AN ERROR OCCURED. UPDATE NOT SAVED. CHECK YOUR INPUTS. TRY AGAIN.'); window.location.href = '../index.php'</script>";
        }
        mysqli_close($conn);
    }
 ?>