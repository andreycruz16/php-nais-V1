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
              tbl_warehouse_history.receivingReport,
              tbl_warehouse.partNumber,
              tbl_warehouse_history.quantity,
              tbl_warehouse_history.quantityChange,
              tbl_warehouse_history.customerName,
              tbl_warehouse_history.model,
              tbl_warehouse_history.serialNumber,
              tbl_transfer_type.transferType,
              tbl_users.username,
              tbl_warehouse_history.stock_id
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
            $receivingReport = $row[6];
            $partNumber = $row[7];
            $quantity = $row[8];
            $quantityChange = $row[9];
            $customerName = $row[10];
            $model = $row[11];
            $serialNumber = $row[12];
            $transferType = $row[13];
            $username = $row[14];
            $stock_id = $row[15];
		}
	}
    // Echo the data you want to show in modal
 } else {
    header("Location: ../index.php"); // Redirecting to All Records Page
 }
?>

 <script> //php variables to javascript variables
    var customerName = "<?php echo $customerName; ?>";
    var model = "<?php echo $model; ?>";
    var serialNumber = "<?php echo $serialNumber; ?>";
    var receivingReport = "<?php echo $receivingReport; ?>";
 </script>
<!--  EDIT HISTORY DETAILS MODAL -->

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel"><?php echo $description; ?> (<?php echo $partNumber; ?>)</h4>
</div>
<form role="form" class="form-horizontal" action="phpScripts/updateHistoryDetails.php" method="post">  
  <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="input-group col-md-12">
                <div class="text-center"><strong>TIMESTAMP:</strong> <?php echo date('m/d/Y | h:i:s A', strtotime($timestamp)); ?></div><br>
                <div class=""><strong>ID:</strong> <i><?php echo $history_id; ?></i></div><br>
              </div>
              <div class="col-md-6">
                <div class="input-group col-md-12">
                    <span class="input-group-addon" id="basic-addon1"><label class="text-danger"></label> Date:</span>
                    <div class="input-group date form_date col-md-12">
                        <input id="date" name="date" class="form-control" type="date" value="<?php echo date('Y-m-d', strtotime($timestamp)); ?>" placeholder="mm/dd/yyyy" autocomplete="off" required>
                    </div>
                </div><br>
                <div class="input-group col-md-12">
                    <span class="input-group-addon" id="basic-addon1">Transfer Type:</span>
                    <select class="form-control" name="transferType_id" id="transferType_id">
                        <option value="1" <?php if($transferType == 'OUT') echo "selected"; ?>>OUT</option>
                        <option value="2" <?php if($transferType == 'IN') echo "selected"; ?>>IN</option>
                    </select> 
                </div><br> 
                <div class="input-group col-md-12">
                  <span class="input-group-addon" id="basic-addon1"><label class="text-danger"></label> Reference:</span>
                  <select class="form-control" name="reference_id" id="reference_idModal">
                    <option value="1" <?php if($referenceType == 'Purchase Order (Unit)') echo "selected"; ?>>Purchase Order (Unit)</option>
                    <option value="2" <?php if($referenceType == 'Purchase Order (Parts)') echo "selected"; ?>>Purchase Order (Parts)</option>
                    <option value="3" <?php if($referenceType == 'Transfer Ticket') echo "selected"; ?>>Transfer Ticket</option>
                    <option value="4" <?php if($referenceType == 'Pick-Up Order') echo "selected"; ?>>Pick-Up Order</option>
                    <option value="5" <?php if($referenceType == 'Invoice') echo "selected"; ?>>Invoice</option>
                    <option value="6" <?php if($referenceType == 'Delivery Receipt') echo "selected"; ?>>Delivery Receipt</option>
                  </select>
                </div><br>
                <div class="input-group col-md-12">
                  <span class="input-group-addon" id="basic-addon1"><label class="text-danger"></label> Reference #:</span>
                  <input type="text" name="referenceNumber" value="<?php echo $referenceNumber; ?>" class="form-control" id="referenceNumberModal" placeholder="Reference Number" aria-describedby="basic-addon1" required autofocus autocomplete="off">
                </div><br>
                <div class="input-group col-md-12" id="receivingReportModal">
                  <span class="input-group-addon" id="basic-addon1"><label class="text-danger"></label> Receiving Report:</span>
                  <input type="text" name="receivingReport" value="<?php echo $receivingReport; ?>" class="form-control" id="receivingReportModal" placeholder="Receiving Report" aria-describedby="basic-addon1" autofocus autocomplete="off">
                </div><br>
              </div>
              <div class="col-md-6">
                <div class="input-group col-md-12">
                    <span class="input-group-addon" id="basic-addon1"><label class="text-danger"></label> + / − :</span>
                    <input type="number" name="quantityChange" value="<?php echo $quantityChange; ?>" class="form-control" id="quantityChange" placeholder="0" aria-describedby="basic-addon1" required autofocus autocomplete="off">
                </div><br>
                <div class="input-group col-md-12">
                    <span class="input-group-addon" id="basic-addon1"><label class="text-danger"></label> Quantity:</span>
                    <input type="number" name="quantity" value="<?php echo $quantity; ?>" class="form-control" id="quantity" placeholder="0" aria-describedby="basic-addon1" required autofocus autocomplete="off">
                </div><br>
                <div id="forTransferTypeOut">                                        
                    <div class="input-group col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Customer Name:</span>
                            <input type="text" name="customerName" value="<?php echo $customerName; ?>" id="customerName" placeholder="Customer Name (Optional)" class="form-control" value="<?php echo $customerName; ?>" aria-describedby="basic-addon1">                                                                                           
                        </div>                                                                                                                                               
                     </div><br>
                     <div class="input-group col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Model:</span>
                            <input type="text" name="model" value="<?php echo $model; ?>" id="model" placeholder="Model (Optional)" class="form-control" value="<?php echo $model; ?>" aria-describedby="basic-addon1">                                                                                           
                        </div>                                                                                                                                               
                      </div><br>
                      <div class="input-group col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Serial Number:</span>
                            <input type="text" name="serialNumber" value="<?php echo $serialNumber; ?>" id="serialNumber" placeholder="Serial Number (Optional)" class="form-control" value="<?php echo $serialNumber; ?>" aria-describedby="basic-addon1">                                                                                           
                        </div>                                                                                                                                               
                      </div>
                </div>                
                      <input type="hidden" name="history_id" id="history_id" value="<?php echo $history_id; ?>">
                      <input type="hidden" name="partNumber" id="partNumber" value="<?php echo $partNumber; ?>">
                      <input type="hidden" name="stock_id" id="stock_id" value="<?php echo $stock_id; ?>">
              </div>         
            </div>
          </div>
        </div>
  </div>
  <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
  </div>
</form>

<script>
          $(document).ready(function() {
            if($('#reference_idModal').val() != '1' && $('#reference_idModal').val() != '2') {
                  $('#receivingReportModal').fadeOut('fast');
                  $('#receivingReportModal #receivingReportModal').val("N/A");
            }
           
              $('#reference_idModal').change(function(event) {
                  if($(this).val() == '1' || $(this).val() == '2') {
                      $('#receivingReportModal').fadeIn('fast');
                      $('#receivingReportModal #receivingReportModal').val(receivingReport);
                  } else {
                      $('#receivingReportModal').fadeOut('fast');
                      $('#receivingReportModal #receivingReportModal').val("N/A");
                  }
              });
          });   

          $(document).ready(function() {
            if($('#transferType_id').val() != '1') {
                  $('#forTransferTypeOut').fadeOut('fast');
                  $('#customerName').val("N/A");
                  $('#model').val("N/A");
                  $('#serialNumber').val("N/A");  
            }

              $('#transferType_id').change(function(event) {
                  if($(this).val() == '1') {
                      $('#forTransferTypeOut').fadeIn('fast');
                      $('#customerName').val("");
                      $('#model').val("");
                      $('#serialNumber').val("");
                  } else {
                      $('#forTransferTypeOut').fadeOut('fast');
                      $('#customerName').val(customerName);
                      $('#model').val(model);
                      $('#serialNumber').val(serialNumber);                      
                  }
              });
          });   
</script>