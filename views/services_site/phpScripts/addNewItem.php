<?php 
    session_start();
    require '../../../database.php';
	if (!empty($_POST)) {
        $date = $_POST['date'];
        $date = mysqli_real_escape_string($conn, $date);
        $date = trim($date);

        $description = $_POST['description'];
        $description = mysqli_real_escape_string($conn, $description);
        $description = trim($description);

        $reference_id = $_POST['reference_id'];
        $reference_id = mysqli_real_escape_string($conn, $reference_id);
        $reference_id = trim($reference_id);

        $referenceNumber = $_POST['referenceNumber'];
        $referenceNumber = mysqli_real_escape_string($conn, $referenceNumber);
        $referenceNumber = trim($referenceNumber);

        $partNumber = $_POST['partNumber'];
        $partNumber = mysqli_real_escape_string($conn, $partNumber);
        $partNumber = trim($partNumber);       

        $quantity = $_POST['quantity'];
        $quantity = mysqli_real_escape_string($conn, $quantity);
        $quantity = trim($quantity); 

        $minStockCount = $_POST['minStockCount'];
        $minStockCount = mysqli_real_escape_string($conn, $minStockCount);
        $minStockCount = trim($minStockCount);

        $transferType_id = $_POST['transferType_id'];
        $transferType_id = mysqli_real_escape_string($conn, $transferType_id);
        $transferType_id = trim($transferType_id);

        $receivingReport = $_POST['receivingReport'];
        $receivingReport = mysqli_real_escape_string($conn, $receivingReport);
        $receivingReport = trim($receivingReport); 

        $unitPrice = $_POST['unitPrice'];
        $unitPrice = mysqli_real_escape_string($conn, $unitPrice);
        $unitPrice = trim($unitPrice);     

        $cost = $_POST['cost'];
        $cost = mysqli_real_escape_string($conn, $cost);
        $cost = trim($cost);           

        $sql = "INSERT INTO tbl_service VALUES(NULL,
                                                 '".$date."',
                                                 '".$description."',
                                                 '".$reference_id."',
                                                 '".$referenceNumber."',
                                                 '".$partNumber."',
                                                 ".$quantity.",
                                                 'N/A', 
                                                 'N/A',
                                                 'N/A',
                                                  ".$minStockCount.",
                                                  ".$transferType_id.",
                                                  ".$unitPrice.",
                                                  '".$receivingReport."',
                                                  0,
                                                  ".$cost."
                                                  );";
       $retval = mysqli_query($conn, $sql); 

        if($retval) {
            $sql = "SELECT stock_id FROM tbl_service WHERE partNumber = '".$partNumber."';"; //fetches the partNumber of the item from tba_service
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result, MYSQL_NUM);  
            $stock_id = $row[0];
            $sql = "INSERT INTO tbl_service_history VALUES(NULL,
                                                     ".$stock_id.",
                                                     now(),
                                                     '".$date."',
                                                     '".$reference_id."',
                                                     '".$referenceNumber."',
                                                     ".$quantity.",
                                                     'N/A',
                                                     'N/A',
                                                     'N/A',
                                                     ".$transferType_id.",
                                                     ".$quantity.",
                                                     ".$cost.",
                                                     '".$receivingReport."',
                                                     ".$_SESSION['user_id']."
                                                     );";
            mysqli_query($conn, $sql);

            $sql = "SELECT tbl_service_history.history_id 
                    FROM tbl_service_history 
                    WHERE stock_id = ".$stock_id." 
                    ORDER BY history_id DESC LIMIT 1;";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result, MYSQL_NUM);
            $history_id = $row[0];

            $sql = "UPDATE tbl_service SET history_id = ".$history_id."
                     WHERE  stock_id = ".$stock_id.";";

            mysqli_query($conn, $sql);

            $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
                                                     '".$_SESSION['user_id']."',
                                                     now(),
                                                     2,
                                                     'New item \"".$description."\" with part number of \"".$partNumber."\"'
                                                     );";                    
            mysqli_query($conn, $sql);
            echo "<script>alert('NEW ITEM ADDED SUCCESSFULLY.'); window.location.href = '../moreDetails.php?stock_id=".$row[0]."'</script>";
        } else {
            echo "<script>alert('PART NUMBER ALREADY EXISTS.'); window.location.href = '../index.php'</script>";
        }
        mysqli_close($conn);
    }
 ?>