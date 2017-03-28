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

        $minStockCount = $_POST['minStockCount'];
        $minStockCount = mysqli_real_escape_string($conn, $minStockCount);
        $minStockCount = trim($minStockCount);

        $boxNumber = $_POST['boxNumber'];
        $boxNumber = mysqli_real_escape_string($conn, $boxNumber);
        $boxNumber = trim($boxNumber);       

        $partNumber = $_POST['partNumber'];
        $partNumber = mysqli_real_escape_string($conn, $partNumber);
        $partNumber = trim($partNumber);        

        $sql = "UPDATE tbl_warehouse
                SET minStockCount = ".$minStockCount.",
                    description = '".$description."',
                    partNumber = '".$partNumber."',
                    boxNumber = '".$boxNumber."'
                WHERE stock_id = ".$stock_id.";";

	    $retval = mysqli_query($conn, $sql); 
        if ($retval) {
            /*ACTIVITY LOG*/
            $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
                                                     '".$_SESSION['user_id']."',
                                                     now(),
                                                     3,
                                                     '<strong>".$description."</strong>: Minimum stock count: <i>".$minStockCount."</i> | Description: <i>".$description."</i> | Part Number: <i>".$partNumber."</i> | Box Number: <i>".$boxNumber."</i>'
                                                     );";  /*3 is update for activity type*/
            mysqli_query($conn, $sql);
            echo "<script>alert('EDIT SUCCESSFUL.'); window.location.href = '../moreDetails.php?stock_id=".$stock_id."'</script>";
                                                                  
        } else {
            echo "<script>alert('AN ERROR OCCURED. UPDATE NOT SAVED. CHECK YOUR INPUTS. TRY AGAIN.'); window.location.href = '../index.php'</script>";
        }
        mysqli_close($conn);
    }
 ?>