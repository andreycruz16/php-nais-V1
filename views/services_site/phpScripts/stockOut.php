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

        $customerName = $_POST['customerName'];
        $customerName = mysqli_real_escape_string($conn, $customerName);
        $customerName = trim($customerName);

        $model = $_POST['model'];
        $model = mysqli_real_escape_string($conn, $model);
        $model = trim($model);

        $serialNumber = $_POST['serialNumber'];
        $serialNumber = mysqli_real_escape_string($conn, $serialNumber);
        $serialNumber = trim($serialNumber);                        

        $quantity = $_POST['quantity'];
        $quantity = mysqli_real_escape_string($conn, $quantity);
        $quantity = trim($quantity);

        $sql = "SELECT stock_id, quantity FROM tbl_service;";
        $service_result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($service_result) > 0) {
            while($service_row = mysqli_fetch_array($service_result, MYSQL_NUM)) { 
                if($service_row[0] == $stock_id) {
                    if($quantity <= $service_row[1] && $quantity > 0){
                        $newQuantity = $service_row[1] - $quantity;  
                    } else {
                        echo "<script>alert('PLEASE ENTER A VALID QUANTITY.'); window.location.href = '../index.php'</script>";
                        mysqli_close($conn);
                    }
                }
            }
        }        

        $transferType_id = $_POST['transferType_id'];
        $transferType_id = mysqli_real_escape_string($conn, $transferType_id);
        $transferType_id = trim($transferType_id);

        $sql = "UPDATE tbl_service SET date ='".$date."',
                                         reference_id =".$reference_id.",   
                                         referenceNumber ='".$referenceNumber."',   
                                         customerName ='".$customerName."',   
                                         model ='".$model."',   
                                         serialNumber ='".$serialNumber."',   
                                         quantity =".$newQuantity." ,
                                         transferType_id =".$transferType_id."
                WHERE  stock_id = ".$stock_id.";";

	    $retval = mysqli_query($conn, $sql); 

        if ($retval) {
            $sql = "INSERT INTO tbl_service_history VALUES(NULL,
                                                     ".$stock_id.",
                                                     now(),
                                                     '".$date."',
                                                     '".$reference_id."',
                                                     '".$referenceNumber."',
                                                     '".$newQuantity."',
                                                     '".$customerName."',
                                                     '".$model."',
                                                     '".$serialNumber."',
                                                     ".$transferType_id.",
                                                     ".$quantity.",
                                                     0,
                                                     'N/A',
                                                     ".$_SESSION['user_id'].");";
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

            /*ACTIVITY LOG*/
            $sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
                                                     '".$_SESSION['user_id']."',
                                                     now(),
                                                     3,
                                                     '".$quantity." stocks deducted on \"".$description."\" with part number of \"".$partNumber."\"'
                                                     );";    
            mysqli_query($conn, $sql);
                     
            echo "<script>alert('ITEM UPDATED SUCCESSFULLY.'); window.location.href = '../moreDetails.php?stock_id=".$stock_id."'</script>";
        } else {
            echo "<script>alert('AN ERROR OCCURED. UPDATE NOT SAVED. CHECK YOUR INPUTS. TRY AGAIN.'); window.location.href = '../index.php'</script>";
        }
        mysqli_close($conn);
    }
 ?>