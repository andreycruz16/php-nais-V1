<?php
//Include database connection
require '../../../database.php';
if($_POST['history_id']) {
    $history_id = $_POST['history_id']; //escape string
    // Run the Query
    $sql = "SELECT
              tbl_warehouse_history.history_id,
              tbl_warehouse_history.timestamp,
              tbl_warehouse_history.date,
              tbl_warehouse.description,
              tbl_reference.referenceType,
              tbl_warehouse_history.referenceNumber,
              tbl_warehouse.partNumber,
              tbl_warehouse_history.quantity,
              tbl_warehouse_history.quantityChange,
              tbl_warehouse_history.customerName,
              tbl_warehouse_history.model,
              tbl_warehouse_history.serialNumber,
              tbl_transfer_type.transferType,
              tbl_users.username,
              tbl_warehouse_history.receivingReport
            FROM
              tbl_warehouse_history
            INNER JOIN
              tbl_reference ON tbl_warehouse_history.reference_id = tbl_reference.reference_id
            INNER JOIN
              tbl_transfer_type ON tbl_transfer_type.transferType_id = tbl_warehouse_history.transferType_id
            INNER JOIN
              tbl_users ON tbl_warehouse_history.user_id = tbl_users.user_id
            INNER JOIN
              tbl_warehouse ON tbl_warehouse.stock_id = tbl_warehouse_history.stock_id
            WHERE
              tbl_warehouse_history.history_id = ".$history_id."
            ORDER BY
              tbl_warehouse_history.history_id DESC;";
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
            $partNumber = $row[6];
            $quantity = $row[7];
            $quantityChange = $row[8];
            $customerName = $row[9];
            $model = $row[10];
            $serialNumber = $row[11];
            $transferType = $row[12];
            $username = $row[13];
            $receivingReport = $row[14];
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
              <strong>DATE:</strong> <?php echo date('m/d/Y', strtotime($timestamp)); ?><br>
              <strong>DESCRIPTION:</strong> <?php echo $description; ?><br>
              <strong>REFERENCE TYPE:</strong> <?php echo $referenceType; ?><br>
              <strong>REFERENCE #:</strong> <?php echo $referenceNumber; ?><br>
              <strong>RECEIVING REPORT:</strong> <?php echo $receivingReport; ?><br>
              <strong>PART #:</strong> <?php echo $partNumber; ?><br>
            </div>
            <div class="col-md-6">
              <br>                                 
              <strong>QUANTITY:</strong> <?php echo $quantity; ?><br>
              <strong>+/-:</strong> <?php echo $quantityChange; ?><br>
              <strong>TRANSFER TYPE:</strong> <?php echo $transferType; ?><br>
              <strong>CUSTOMER NAME:</strong> <?php echo $customerName; ?><br>
              <strong>MODEL:</strong> <?php echo $model; ?><br>
              <strong>SERIAL #:</strong> <?php echo $serialNumber; ?><br>
              <strong>UPDATE BY:</strong> <?php echo $username; ?><br>
            </div>
        </div>
      </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

