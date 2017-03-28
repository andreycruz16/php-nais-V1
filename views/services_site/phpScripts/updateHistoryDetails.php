<?php 
    session_start();
	require '../../../database.php';
	if (!empty($_POST)) {
        $history_id = $_POST['history_id'];
        $history_id = mysqli_real_escape_string($conn, $history_id);
        $history_id = trim($history_id);

        $stock_id = $_POST['stock_id'];
        $stock_id = mysqli_real_escape_string($conn, $stock_id);
        $stock_id = trim($stock_id);        

        $partNumber = $_POST['partNumber'];
        $partNumber = mysqli_real_escape_string($conn, $partNumber);
        $partNumber = trim($partNumber);

        $date = $_POST['date'];
        $date = mysqli_real_escape_string($conn, $date);
        $date = trim($date);

        $transferType_id = $_POST['transferType_id'];
        $transferType_id = mysqli_real_escape_string($conn, $transferType_id);
        $transferType_id = trim($transferType_id);
        
        $reference_id = $_POST['reference_id'];
        $reference_id = mysqli_real_escape_string($conn, $reference_id);
        $reference_id = trim($reference_id);
        
        $referenceNumber = $_POST['referenceNumber'];
        $referenceNumber = mysqli_real_escape_string($conn, $referenceNumber);
        $referenceNumber = trim($referenceNumber);       
         
        $receivingReport = $_POST['receivingReport'];
        $receivingReport = mysqli_real_escape_string($conn, $receivingReport);
        $receivingReport = trim($receivingReport);

        $quantity = $_POST['quantity'];
        $quantity = mysqli_real_escape_string($conn, $quantity);
        $quantity = trim($quantity);

        $quantityChange = $_POST['quantityChange'];
        $quantityChange = mysqli_real_escape_string($conn, $quantityChange);
        $quantityChange = trim($quantityChange);

        $customerName = $_POST['customerName'];
        $customerName = mysqli_real_escape_string($conn, $customerName);
        $customerName = trim($customerName);

        $model = $_POST['model'];
        $model = mysqli_real_escape_string($conn, $model);
        $model = trim($model);

        $serialNumber = $_POST['serialNumber'];
        $serialNumber = mysqli_real_escape_string($conn, $serialNumber);
        $serialNumber = trim($serialNumber);

        $cost = $_POST['cost'];
        $cost = mysqli_real_escape_string($conn, $cost);
        $cost = trim($cost);            

        $sql = "SELECT history_id 
                FROM tbl_service 
                WHERE history_id = ".$history_id.";";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $sql = "UPDATE tbl_service 
                    SET date = '".$date."',
                        transferType_id = ".$transferType_id.",
                        reference_id = ".$reference_id.",
                        referenceNumber = '".$referenceNumber."',
                        receivingReport = '".$receivingReport."',
                        quantity = ".$quantity.",
                        customerName = '".$customerName."',
                        model = '".$model."',
                        serialNumber = '".$serialNumber."',
                        cost = ".$cost."
                    WHERE history_id = ".$history_id.";";
    	    mysqli_query($conn, $sql); 

            $sql = "UPDATE tbl_service_history 
                    SET date = '".$date."',
                        timestamp = now(),
                        transferType_id = ".$transferType_id.",
                        reference_id = ".$reference_id.",
                        referenceNumber = '".$referenceNumber."',
                        receivingReport = '".$receivingReport."',
                        quantity = ".$quantity.",
                        quantityChange = ".$quantityChange.",
                        customerName = '".$customerName."',
                        model = '".$model."',
                        serialNumber = '".$serialNumber."',
                        cost = ".$cost."
                    WHERE history_id = ".$history_id.";";

            $retval = mysqli_query($conn, $sql); 
            if ($retval) {
                /*ACTIVITY LOG*/
                $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
                                                         '".$_SESSION['user_id']."',
                                                         now(),
                                                         3,
                                                         'History Update:  Part Number: <i>".$partNumber."'
                                                         );";  /*3 is update for activity type*/
                mysqli_query($conn, $sql);
                echo "<script>alert('EDIT SUCCESSFUL.'); window.location.href = '../moreDetails.php?stock_id=".$stock_id."'</script>";
                                                                      
            } else {
                echo "<script>alert('AN ERROR OCCURED. UPDATE NOT SAVED. CHECK YOUR INPUTS. TRY AGAIN.'); window.location.href = '../moreDetails.php?stock_id=".$stock_id."'</script>";
            }

        } else {
            $sql = "UPDATE tbl_service_history 
                    SET date = '".$date."',
                        timestamp = now(),
                        transferType_id = ".$transferType_id.",
                        reference_id = ".$reference_id.",
                        referenceNumber = '".$referenceNumber."',
                        receivingReport = '".$receivingReport."',
                        quantity = ".$quantity.",
                        quantityChange = ".$quantityChange.",
                        customerName = '".$customerName."',
                        model = '".$model."',
                        serialNumber = '".$serialNumber."',
                        cost = ".$cost."
                    WHERE history_id = ".$history_id.";";

            $retval = mysqli_query($conn, $sql); 
            if ($retval) {
                /*ACTIVITY LOG*/
                $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
                                                         '".$_SESSION['user_id']."',
                                                         now(),
                                                         3,
                                                         'History Update:  Part Number: <i>".$partNumber."'
                                                         );";  /*3 is update for activity type*/
                mysqli_query($conn, $sql);
                echo "<script>alert('EDIT SUCCESSFUL.'); window.location.href = '../moreDetails.php?stock_id=".$stock_id."'</script>";
                                                                      
            } else {
                echo "<script>alert('AN ERROR OCCURED. UPDATE NOT SAVED. CHECK YOUR INPUTS. TRY AGAIN.'); window.location.href = '../moreDetails.php?stock_id=".$stock_id."'</script>";
            }  


        }         


        mysqli_close($conn);
    }
 ?>