<?php
    include('session.php');
    require '../../database.php';

    if (!empty($_GET['stock_id'])) {
        $stock_id = $_GET['stock_id'];

        $sql = "SELECT
                  tbl_service.date,
                  tbl_service.description,
                  tbl_reference.referenceType,
                  tbl_service.referenceNumber,
                  tbl_service.partNumber,
                  tbl_service.quantity,
                  tbl_service.customerName,
                  tbl_service.model,
                  tbl_service.serialNumber,
                  tbl_service.minStockCount,
                  tbl_transfer_type.transferType,
                  tbl_service.unitPrice,
                  tbl_service.receivingReport
                FROM
                  tbl_service
                INNER JOIN
                  tbl_reference ON tbl_service.reference_id = tbl_reference.reference_id
                INNER JOIN
                  tbl_transfer_type ON tbl_service.transferType_id = tbl_transfer_type.transferType_id
                WHERE
                  stock_id = ".$stock_id.";";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result, MYSQL_NUM)) {    
                    $date = $row[0];
                    $description = $row[1];
                    $referenceType = $row[2];
                    $reference_number = $row[3];
                    $partNumber = $row[4];
                    $quantity = $row[5];
                    $customerName = $row[6];
                    $model = $row[7];
                    $serialNumber = $row[8];
                    $minStockCount = $row[9];
                    $transferType = $row[10];
                    $unitPrice = $row[11];
                    $receivingReport = $row[12];
            }
        } else {
            header("location: index.php");    
        }

    } else {
        header("location: index.php");
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<?php include("includes/header.php") ?>
<style>
 #historyDetails .modal-header {
      background-color: #3c8dbc;
      color: #fff;
      font-weight: bold;
      text-align: center;      
 }    

  #editHistoryDetails .modal-header {
      background-color: #3c8dbc;
      color: #fff;
      font-weight: bold;
      text-align: center;      
 }    
</style>
<body>
    <div id="wrapper">
      <!-- TOP NAVIGATION -->
      <?php include("includes/topNavigation.php") ?>
      <!-- SIDE NAVIGATION -->
      <?php include("includes/sideNavigation.php") ?>
	    <div id="page-wrapper">
        <div class="header"> 
            <h2 class="page-header">
                <code class="text-primary"><?php echo $description; ?> (<?php echo $partNumber; ?>)</code>
            </h2>
            <ol class="breadcrumb">
                <li><a href="index.php">All Records</a></li>
                <li class="active">Item Details</li>
            </ol>
        </div>
        <div id="page-inner">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Item Information (<?php echo $partNumber; ?>)
                    </div>
                    <div class="panel-body">
                              <br>
                              <!-- <div class="form-group">
                                  <div class="col-md-6">
                                      <label class="text-primary"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label><strong> Read-only (Fixed Details)</strong>
                                  </div>
                              </div><br> -->
                              <form action="phpScripts/updateFixedDetails.php" method="post">
                                  <div class="form-group input-group col-md-12">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Part Number:</span>
                                            <input type="text" name="partNumber" id="partNumber" class="form-control" value="<?php echo $partNumber; ?>" aria-describedby="basic-addon1" required>                                                                                           
                                        </div>                                                                                                                                               
                                     </div>
                                     <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Description:</span>
                                            <input type="text" name="description" id="description" class="form-control" value="<?php echo $description; ?>" aria-describedby="basic-addon1" required>
                                        </div>                                                                                                                                               
                                     </div>
                                     <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Minimum Stock Count:</span>
                                            <input type="text" name="minStockCount" id="minStockCount" class="form-control" value="<?php echo $minStockCount; ?>" aria-describedby="basic-addon1" required>
                                        </div>                                                                                                                                               
                                     </div>         
                                  </div>
                                  <div class="form-group input-group col-md-12">
                                     <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><label class="text-danger"></label>Unit Price:</span><span class="input-group-addon" id="basic-addon1"><label class="text-danger"></label>₱</span>
                                            <input type="text" name="unitPrice" id="unitPrice" class="form-control"  placeholder="00.00" value="<?php echo $unitPrice; ?>" aria-describedby="basic-addon1" autocomplete="off" required>                                                                                           
                                        </div>                                                                                                                                               
                                     </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Quantity:</span>
                                            <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Quantity" value="<?php echo $quantity; ?>" aria-describedby="basic-addon1" disabled readonly>                                                                                           
                                        </div>                                                                                                                                               
                                     </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Total Amount:</span><span class="input-group-addon" id="basic-addon1"><label class="text-danger"></label>₱</span>
                                            <input type="text" name="totalAmount" id="totalAmount" class="form-control" value="<?php echo ($quantity * $unitPrice); ?>" aria-describedby="basic-addon1" disabled readonly>                                                                                           
                                        </div>                                                                                                                                               
                                     </div>       
                                  </div>
                                  <input type="hidden" name="stock_id" id="stock_id" value="<?php echo $stock_id; ?>">   
                                  <div class="form-group input-group col-md-12">
                                     <div class="col-md-12">
                                          <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                                          <a href="index.php" class="btn btn-default">Cancel</a>
                                     </div>                                    
                                  </div>
                              </form> 
                                                             
<!--                                 <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="text-danger"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label><strong> Editable&nbsp;(Latest Item Information)</strong>
                                    </div>
                                </div><br><br>  
                                <form action="phpScripts/updateOptionalDetails.php" method="post">                             
                                    <div class="form-group input-group col-md-6">
                                         <div class="col-md-12">
                                            <div class="input-group date form_date">
                                                <span class="input-group-addon" id="basic-addon1">Date:</span>
                                                <input id="date" name="date" class="form-control" type="text" value="<?php echo date('Y-m-d', strtotime($date)); ?>" placeholder="YEAR-MONTH-DAY" required  readonly>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>                                                                                                                                               
                                         </div>
                                    </div>
                                    <div class="form-group input-group col-md-6">
                                         <div class="col-md-12">
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1">Transfer Type:</span>
                                                <select class="form-control" name="transferType_id" id="transferType_id">
                                                    <option value="1" <?php if($transferType == 'OUT') echo "selected"; ?>>OUT</option>
                                                    <option value="2" <?php if($transferType == 'IN') echo "selected"; ?>>IN</option>
                                                </select> 
                                            </div>                                                                                                                                               
                                         </div>
                                    </div>
                                    <div class="form-group input-group col-md-6">
                                         <div class="col-md-12">
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1">Reference Type:</span>
                                                <select class="form-control" name="reference_id" id="reference_id">
                                                    <option value="1" <?php if($referenceType == 'Purchase Order (Unit)') echo "selected"; ?>>Purchase Order (Unit)</option>
                                                    <option value="2" <?php if($referenceType == 'Purchase Order (Parts)') echo "selected"; ?>>Purchase Order (Parts)</option>
                                                    <option value="3" <?php if($referenceType == 'Transfer Ticket') echo "selected"; ?>>Transfer Ticket</option>
                                                    <option value="4" <?php if($referenceType == 'Pick-Up Order') echo "selected"; ?>>Pick-Up Order</option>
                                                    <option value="5" <?php if($referenceType == 'Invoice') echo "selected"; ?>>Invoice</option>
                                                    <option value="6" <?php if($referenceType == 'Delivery Receipt') echo "selected"; ?>>Delivery Receipt</option>
                                                </select> 
                                            </div>                                                                                                                                               
                                         </div>
                                    </div>
                                    <div class="form-group input-group col-md-6">
                                         <div class="col-md-12">
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1">Reference Number:</span>
                                                <input type="text" name="referenceNumber" id="referenceNumber" placeholder="Reference Number" class="form-control" value="<?php echo $reference_number; ?>" aria-describedby="basic-addon1">
                                            </div>                                                                                                                                               
                                         </div>
                                    </div>
                                    <div class="form-group input-group col-md-6" id="receivingReport">
                                         <div class="col-md-12">
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1">Receiving Report:</span>
                                                <input type="text" name="receivingReport" id="receivingReport" placeholder="Receiving Report" class="form-control" value="<?php echo $receivingReport; ?>" aria-describedby="basic-addon1">                                                                                           
                                            </div>                                                                                                                                               
                                         </div>
                                    </div>
                                    <div class="form-group input-group col-md-6">                                                                             
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1">Quantity:</span>
                                                <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Quantity" value="<?php echo $quantity; ?>" aria-describedby="basic-addon1">                                                                                           
                                            </div>                                                                                                                                               
                                         </div>
                                    </div>    
                                    <div class="form-group input-group col-md-12" id="forTransferTypeOut">                                        
                                      <div class="form-group input-group col-md-6">
                                          <div class="col-md-12">
                                              <div class="input-group">
                                                  <span class="input-group-addon" id="basic-addon1">Customer Name:</span>
                                                  <input type="text" name="customerName" id="customerName" placeholder="Customer Name (Optional)" class="form-control" value="<?php echo $customerName; ?>" aria-describedby="basic-addon1">                                                                                           
                                              </div>                                                                                                                                               
                                           </div>
                                      </div>
                                      <div class="form-group input-group col-md-6">
                                          <div class="col-md-12">
                                              <div class="input-group">
                                                  <span class="input-group-addon" id="basic-addon1">Model:</span>
                                                  <input type="text" name="model" id="model" placeholder="Model (Optional)" class="form-control" value="<?php echo $model; ?>" aria-describedby="basic-addon1">                                                                                           
                                              </div>                                                                                                                                               
                                           </div>
                                      </div>
                                      <div class="form-group input-group col-md-6">
                                           <div class="col-md-12">
                                              <div class="input-group">
                                                  <span class="input-group-addon" id="basic-addon1">Serial Number:</span>
                                                  <input type="text" name="serialNumber" id="serialNumber" placeholder="Serial Number (Optional)" class="form-control" value="<?php echo $serialNumber; ?>" aria-describedby="basic-addon1">                                                                                           
                                              </div>                                                                                                                                               
                                           </div>
                                      </div>                                                                       
                                    </div>
                                    <div class="form-group input-group col-md-6">
                                         <div class="col-md-12">
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><label class="text-danger"></label>Minimum Stock Count:</span>
                                                <input type="text" name="minStockCount" id="minStockCount" class="form-control" placeholder="Minimum Stock Count" value="<?php echo $minStockCount; ?>" aria-describedby="basic-addon1" autocomplete="off">                                                                                           
                                            </div>                                                                                                                                               
                                         </div>
                                    </div>
                                    <input type="hidden" name="stock_id" id="stock_id" value="<?php echo $stock_id; ?>">   
                                    <input type="hidden" name="description" id="description" value="<?php echo $description; ?>"> 
                                    <button type="submit" class="btn btn-success col-sm-6 col-sm-offset-3"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>                                              
                                </form> -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Record History (<?php echo $partNumber; ?>)
                    </div>
                    <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed table-hover" id="recordHistory">
                                    <thead>
                                        <tr>
                                            <th class="text-center" bgcolor="#e5e5e5" width="155">TIMESTAMP</th>
                                            <th class="text-center" bgcolor="#f2ba7f">Date&nbsp;(M/D/Y)</th>
                                            <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;Type</th>
                                            <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;#</th>
                                            <th class="text-center" bgcolor="#f2ba7f">Receiving&nbsp;Report</th>
                                            <th class="text-center" bgcolor="#f2ba7f">Cost</th>
                                            <th class="text-center" bgcolor="#f2ba7f">Transfer&nbsp;Type</th>
                                            <th class="text-center" bgcolor="#f2ba7f" width="30">+&nbsp;/&nbsp;−</th>
                                            <th class="text-center" bgcolor="#f2ba7f">Stock Count</th>
                                            <th class="text-center" bgcolor="#f2ba7f">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center" bgcolor="#e5e5e5" width="155">TIMESTAMP</th> 
                                            <th class="text-center" bgcolor="#f2ba7f">Date&nbsp;(M/D/Y)</th> 
                                            <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;Type</th> 
                                            <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;#</th> 
                                            <th class="text-center" bgcolor="#f2ba7f">Receiving&nbsp;Report</th>
                                            <th class="text-center" bgcolor="#f2ba7f">Cost</th>
                                            <th class="text-center" bgcolor="#f2ba7f">Transfer&nbsp;Type</th> 
                                            <th class="text-center" bgcolor="#f2ba7f" width="30">+&nbsp;/&nbsp;−</th> 
                                            <th class="text-center" bgcolor="#f2ba7f">Stock Count</th> 
                                            <td class="text-center" bgcolor="#f2ba7f"></td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
                                        require '../../database.php';
                                        $sql = "SELECT 
                                                tbl_service_history.timestamp, 
                                                tbl_service_history.date,
                                                tbl_reference.referenceType,
                                                tbl_service_history.referenceNumber,
                                                tbl_service_history.quantity,
                                                tbl_service_history.quantityChange,
                                                tbl_transfer_type.transferType,
                                                tbl_users.username,
                                                tbl_service_history.history_id,
                                                tbl_service_history.cost,
                                                tbl_service_history.receivingReport
                                                FROM tbl_service_history 
                                                INNER JOIN tbl_reference
                                                ON tbl_service_history.reference_id = tbl_reference.reference_id
                                                INNER JOIN tbl_transfer_type
                                                ON tbl_transfer_type.transferType_id = tbl_service_history.transferType_id
                                                INNER JOIN tbl_users
                                                ON tbl_service_history.user_id = tbl_users.user_id
                                                WHERE tbl_service_history.stock_id = ".$stock_id."
                                                ORDER BY tbl_service_history.history_id DESC;";
                                        // echo $sql;
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
                                            $timestamp = $row[0];
                                            $date = $row[1];
                                            $referenceType = $row[2];
                                            $referenceNumber = $row[3];
                                            $quantity = $row[4];
                                            $quantityChange = $row[5];
                                            $transferType = $row[6];
                                            $username = $row[7]; 
                                            $history_id = $row[8];                                                       
                                            $cost = $row[9];
                                            $receivingReport = $row[10];
                                    ?>
                                        <tr>
                                            <td class="text-center" title="Date & Time Updated"><?php  echo date('m/d/Y | h:i:s A', strtotime($timestamp)); ?></td>
                                            <td class="text-center"><?php echo date('m/d/Y', strtotime($date)); ?></td>
                                            <td><?php echo $referenceType; ?></td>
                                            <td><?php echo $referenceNumber; ?></td>
                                            <td><?php echo $receivingReport; ?></td>
                                            <td><?php if($transferType == 'IN') echo "₱ ".$cost; else echo "N/A"?></td>
                                            <td class="text-center"><?php echo $transferType ?></td>
                                            <td class="text-center"><?php echo $quantityChange; ?></td>
                                            <td class="text-center"><?php echo $quantity; ?></td>
                                            <td class="text-center">
                                              <button type="button" class="btn btn-info btn-xs" title="Edit" data-toggle="modal" data-target="#editHistoryDetails" data-id="<?php echo $history_id; ?>">Edit <span class="glyphicon glyphicon-edit"></span></button>
                                              <button type="button" class="btn btn-primary btn-xs" title="Details" data-toggle="modal" data-target="#historyDetails" data-id="<?php echo $history_id; ?>">Details <span class="glyphicon glyphicon-list-alt"></span></button>
                                            </td>
                                        </tr>
                                    <?php 
                                            }
                                        }
                                            mysqli_close($conn);
                                    ?>                                          
                                    </tbody>                                            
                                </table>
                            </div>                                                
                    </div>
                </div>
            </div>
		    <?php include("includes/footer.php") ?>
        </div>
      </div>
    </div>

    <!-- EDIT HISTORY DETAILS -->                                                     
    <div id="editHistoryDetails" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="fetched-data-editHistoryDetailsModal"></div>
            </div>
        </div>
    </div>     

    <!-- HISTORY DETAILS -->                                                     
    <div id="historyDetails" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="fetched-data-historyDetailsModal"></div>
            </div>
        </div>
    </div> 


    <?php include("includes/scripts.php") ?>
    <script>
        $(document).ready(function () {
            $('#recordHistory').dataTable({
            'iDisplayLength': 15, 
            'lengthMenu': [ [15, 25, 50, 100, -1], [15, 25, 50, 100, 'All'] ],
            'bSort': false
             });
        });

        $(document).ready(function() {
            var table = $('#recordHistory').DataTable();
         
            $("#recordHistory tfoot th").each( function ( i ) {
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(this).empty() )
                    .on( 'change', function () {
                        table.column( i )
                            .search( $(this).val() )
                            .draw();
                    } );
         
                table.column( i ).data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );           
        } );            

        $('.form_date').datetimepicker({
            // language:  'fr',
            format:'yyyy-mm-dd',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        }); 

          if($('#transferType_id').val() == "IN") {
            $('#forTransferTypeOut').hide();
          }

          // HISTORY DETAILS
          $(document).ready(function(){
              $('#historyDetails').on('show.bs.modal', function (e) {
                  var history_id = $(e.relatedTarget).data('id');
                  $.ajax({
                      type : 'post',
                      url : 'phpScripts/fetch_stockDetailsModal.php', //Here you will fetch records 
                      data :  'history_id=' + history_id, //Pass $id
                      success : function(data){
                      $('.fetched-data-historyDetailsModal').html(data);//Show fetched data from database
                      }
                  });
               });
          });        

          // EDIT HISTORY DETAILS
          $(document).ready(function(){
              $('#editHistoryDetails').on('show.bs.modal', function (e) {
                  var history_id = $(e.relatedTarget).data('id');
                  $.ajax({
                      type : 'post',
                      url : 'phpScripts/fetch_stockHistoryDetailsModal.php', //Here you will fetch records 
                      data :  'history_id=' + history_id, //Pass $id
                      success : function(data){
                      $('.fetched-data-editHistoryDetailsModal').html(data);//Show fetched data from database
                      }
                  });
               });
          });

          $(document).ready(function() {
            if($('#reference_id').val() != '1' || $('#reference_id').val() != '2') {
                  $('#receivingReport').fadeOut('fast');
                  $('#receivingReport #receivingReport').val("N/A");
            }

              $('#reference_id').change(function(event) {
                  if($(this).val() == '1' || $(this).val() == '2') {
                      $('#receivingReport').fadeIn('fast');
                      $('#receivingReport #receivingReport').val(receivingReport);
                  } else {
                      $('#receivingReport').fadeOut('fast');
                      $('#receivingReport #receivingReport').val("N/A");
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
</body>
</html>