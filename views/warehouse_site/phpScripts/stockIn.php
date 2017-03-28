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

        $partNumber = $_POST['partNumber'];
        $partNumber = mysqli_real_escape_string($conn, $partNumber);
        $partNumber = trim($partNumber);        

        $date = $_POST['date'];
        $date = mysqli_real_escape_string($conn, $date);
        $date = trim($date);

        $reference_id = $_POST['reference_id'];
        $reference_id = mysqli_real_escape_string($conn, $reference_id);
        $reference_id = trim($reference_id);

        $referenceNumber = $_POST['referenceNumber'];
        $referenceNumber = mysqli_real_escape_string($conn, $referenceNumber);
        $referenceNumber = trim($referenceNumber);                      

        $quantity = $_POST['quantity'];
        $quantity = mysqli_real_escape_string($conn, $quantity);
        $quantity = trim($quantity);      

        $sql = "SELECT stock_id, quantity FROM tbl_warehouse;";
        $warehouse_result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($warehouse_result) > 0) {
            while($warehouse_row = mysqli_fetch_array($warehouse_result, MYSQL_NUM)) { 
                if($warehouse_row[0] == $stock_id) {
                    if($quantity > 0){
                        $newQuantity = $warehouse_row[1] + $quantity; 
                    } else {
                        echo "<script>alert('PLEASE ENTER A VALID QUANTITY. TRY AGAIN'); window.location.href = '../index.php'</script>";
                        mysqli_close($conn);
                    }
                }
            }
        }        

        $transferType_id = $_POST['transferType_id'];
        $transferType_id = mysqli_real_escape_string($conn, $transferType_id);
        $transferType_id = trim($transferType_id);

        $receivingReport = $_POST['receivingReport'];
        $receivingReport = mysqli_real_escape_string($conn, $receivingReport);
        $receivingReport = trim($receivingReport);             

        $sql = "UPDATE tbl_warehouse SET date ='".$date."',
                                         reference_id =".$reference_id.",   
                                         referenceNumber ='".$referenceNumber."',   
                                         customerName ='N/A',   
                                         model ='N/A',   
                                         serialNumber ='N/A',   
                                         quantity =".$newQuantity." ,
                                         transferType_id =".$transferType_id.",
                                         receivingReport ='".$receivingReport."'
                WHERE  stock_id = ".$stock_id.";";

	    $retval = mysqli_query($conn, $sql); 
        if ($retval) {
            $sql = "INSERT INTO tbl_warehouse_history VALUES(NULL,
                                                     ".$stock_id.",
                                                     now(),
                                                     '".$date."',
                                                     '".$reference_id."',
                                                     '".$referenceNumber."',
                                                     '".$newQuantity."',
                                                     'N/A',
                                                     'N/A',
                                                     'N/A',
                                                     ".$transferType_id.",
                                                     ".$quantity.",
                                                     ".$_SESSION['user_id'].",
                                                     '".$receivingReport."');";                    
            mysqli_query($conn, $sql);

            /*ACTIVITY LOG*/
            $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
                                                     '".$_SESSION['user_id']."',
                                                     now(),
                                                     3,
                                                     '".$quantity." stocks added on \"".$description."\" with part number of \"".$partNumber."\"'
                                                     );";       
            mysqli_query($conn, $sql);                                                             

            echo "<script>alert('ITEM UPDATED SUCCESSFULLY.'); window.location.href = '../moreDetails.php?stock_id=".$stock_id."'</script>";
            /*Create a code that will redirect the  page to the updated details of the recent record*/
        } else {
            echo "<script>alert('AN ERROR OCCURED. UPDATED NOT SAVED. CHECK YOUT INPUTS. TRY AGAIN.'); window.location.href = '../index.php'</script>";
        }
        mysqli_close($conn);
    }
 ?>