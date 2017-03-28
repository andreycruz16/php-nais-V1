<?php
//Include database connection
require '../../../database.php';
if($_POST['history_id']) {
    $history_id = $_POST['history_id']; //escape string
    // Run the Query
    $sql = "SELECT 
        tbl_item_history.history_id,
                tbl_item_history.timestamp,
                tbl_item_history.date,
                tbl_item.description,
                tbl_reference.referenceType,
                tbl_item_history.referenceNumber,
                tbl_item_history.receivingReport,
                tbl_item.partNumber,
                tbl_item_history.quantity,
                tbl_item_history.quantityChange,
                tbl_item_history.customerName,
                tbl_item_history.model,
                tbl_item_history.serialNumber,
                tbl_item_history.transferType,
                tbl_users.firstName,
                tbl_users.lastName
                FROM tbl_item_history
                INNER JOIN tbl_item
                ON tbl_item_history.item_id = tbl_item.item_id
                INNER JOIN tbl_reference
                ON tbl_item_history.reference_id = tbl_reference.reference_id
                INNER JOIN tbl_users
                ON tbl_item_history.user_id = tbl_users.user_id
                WHERE  tbl_item_history.history_id = ".$history_id.";";
    $result = mysqli_query($conn, $sql);
    // Fetch Records
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
            $history_id = $row[0];
            $timestamp = $row[1];
            $date = $row[2];
            $description = $row[3];
            $referenceType = $row[4];
            $referenceNumber = $row[5];
            $receivingReport = $row[6];
            $partNumber = $row[7];
            $quantity = $row[8];
            $quantityChange = $row[9];
            $customerName = $row[10];
            $model = $row[11];
            $serialNumber = $row[12];
            $transferType = $row[13];
            $firstName = $row[14];
            $lastName = $row[15];
		}
	}
    // Echo the data you want to show in modal
 } else {
    header("Location: ../index.php"); // Redirecting to All Records Page
 }
?>
<!--  HISTORY DETAILS MODAL -->

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel"><?php echo $description; ?> (<?php echo $partNumber; ?>)</h4>
</div>
<div class="modal-body">
      <div class="container-fluid">
        <div class="row">
            <div class="text-center"><strong>TIMESTAMP:</strong> <?php echo date('m/d/Y | h:i:s A', strtotime($timestamp)); ?></div>
            <div class="col-md-6">
              <br>
              <strong>ID:</strong> <?php echo $history_id; ?><br>
              <strong>DATE:</strong> <?php echo date('m/d/Y', strtotime($timestamp)); ?><br>
              <strong>DESCRIPTION:</strong> <?php echo $description; ?><br>
              <strong>REFERENCE:</strong> <?php echo $referenceType; ?><br>
              <strong>REFERENCE #:</strong> <?php echo $referenceNumber; ?><br>
              <strong>RECEIVING REPORT:</strong> <?php echo $receivingReport; ?><br>
              <strong>PART #:</strong> <?php echo $partNumber; ?><br>
            </div>
            <div class="col-md-6">
              <br>                                 
              <strong>TRANSFER TYPE:</strong> <?php echo $transferType . ' (' . $quantityChange . ')';?><br>
              <!-- <strong>+/-:</strong> <?php echo $quantityChange; ?><br> -->
              <strong>STOCK ON HAND:</strong> <?php echo $quantity; ?><br>
              <strong>CUSTOMER NAME:</strong> <?php echo $customerName; ?><br>
              <strong>MODEL:</strong> <?php echo $model; ?><br>
              <strong>SERIAL #:</strong> <?php echo $serialNumber; ?><br>
              <strong>UPDATE BY:</strong> <?php echo $firstName . ' ' . $lastName; ?><br>
            </div>
        </div>
      </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

