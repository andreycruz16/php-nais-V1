<?php
    include('session.php');
    require '../../database.php';

    if (!empty($_GET['stock_id'])) {
        $stock_id = $_GET['stock_id'];

        $sql = "SELECT
                  tbl_warehouse.date,
                  tbl_warehouse.description,
                  tbl_reference.referenceType,
                  tbl_warehouse.referenceNumber,
                  tbl_warehouse.partNumber,
                  tbl_warehouse.boxNumber,
                  tbl_warehouse.quantity,
                  tbl_warehouse.customerName,
                  tbl_warehouse.model,
                  tbl_warehouse.serialNumber,
                  tbl_warehouse.minStockCount,
                  tbl_transfer_type.transferType
                FROM
                  tbl_warehouse
                INNER JOIN
                  tbl_reference ON tbl_warehouse.reference_id = tbl_reference.reference_id
                INNER JOIN
                  tbl_transfer_type ON tbl_warehouse.transferType_id = tbl_transfer_type.transferType_id
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
                    $boxNumber = $row[5];
                    $quantity = $row[6];
                    $customerName = $row[7];
                    $model = $row[8];
                    $serialNumber = $row[9];
                    $minStockCount = $row[10];
                    $transferType = $row[11];
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
<head>
<?php include("includes/header.php") ?>
</head>
<body>
    <div id="wrapper">
        <!-- TOP NAVIGATION -->
        <?php include("includes/topNavigation.php") ?>
        <!-- SIDE NAVIGATION -->
        <?php include("includes/sideNavigation.php") ?>
		    <div id="page-wrapper">
            <div class="header"> 
                <h2 class="page-header">
                    <span class="text-success"><?php echo $description; ?> - (<?php echo $partNumber; ?>)</span>
                </h2>
                <ol class="breadcrumb">
                    <li><a href="index.php">All Records</a></li>
                    <li class="active">Item Details (Warehouse)</li>
                </ol>
            </div>
            <div id="page-inner">
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Complete Details
                        </div>
                        <div class="panel-body">
                          <div class="tab-pane fade active in">
                              <br>
                              <div class="form-group">
                                      <div class="col-md-6">
                                          <label class="text-primary"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label><strong> Read-only</strong>
                                      </div>
                              </div><br>
                              <div class="form-group input-group">
                                   <div class="col-md-4">
                                      <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">Date:</span>
                                          <input type="text" name="date" id="date" class="form-control" value="<?php echo date('m/d/Y', strtotime($date)); ?>" aria-describedby="basic-addon1" disabled readonly>                                                                                           
                                      </div>                                                                                                                                               
                                   </div>
                                   <div class="col-md-4">
                                      <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">Description:</span>
                                          <input type="text" name="description" id="description" class="form-control" value="<?php echo $description; ?>" aria-describedby="basic-addon1" disabled readonly>                                                                                           
                                      </div>                                                                                                                                               
                                   </div>
                                   <div class="col-md-4">
                                      <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">Transfer Type:</span>
                                          <input type="text" name="transferType_id" id="transferType_id" class="form-control" value="<?php echo $transferType; ?>" aria-describedby="basic-addon1" disabled readonly>                                                                                           
                                      </div>                                                                                                                                               
                                   </div>
                              </div>
                              <div class="form-group input-group">
                                   <div class="col-md-4">
                                      <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">Reference Type:</span>
                                          <input type="text" name="reference_id" id="reference_id" class="form-control" value="<?php echo $referenceType; ?>" aria-describedby="basic-addon1" disabled readonly>                                                                                           
                                      </div>                                                                                                                                               
                                   </div>
                                   <div class="col-md-4">
                                      <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">Reference Number:</span>
                                          <input type="text" name="referenceNumber" id="referenceNumber" class="form-control" value="<?php echo $reference_number; ?>" aria-describedby="basic-addon1" disabled readonly>                                                                                           
                                      </div>                                                                                                                                               
                                   </div>
                                   <div class="col-md-4">
                                      <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">Part Number:</span>
                                          <input type="text" name="partNumber" id="partNumber" class="form-control" value="<?php echo $partNumber; ?>" aria-describedby="basic-addon1" disabled readonly>                                                                                           
                                      </div>                                                                                                                                               
                                   </div>
                              </div>
                              <div class="form-group input-group">
                                  <div class="col-md-4">
                                      <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">Box Number:</span>
                                          <input type="text" name="boxNum" id="boxNum" class="form-control" value="<?php echo $boxNumber; ?>" aria-describedby="basic-addon1" disabled readonly>                                                                                           
                                      </div>                                                                                                                                               
                                   </div>
                                  <div class="col-md-4">
                                      <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">Quantity:</span>
                                          <input type="text" name="quantity" id="quantity" class="form-control" value="<?php echo $quantity; ?>" aria-describedby="basic-addon1" disabled readonly>                                                                                           
                                      </div>                                                                                                                                               
                                   </div>
                                   <div class="col-md-4">
                                      <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">Minimum Stock Count:</span>
                                          <input type="text" name="minStockCount" id="minStockCount" class="form-control" value="<?php echo $minStockCount; ?>" aria-describedby="basic-addon1" disabled readonly>                                                                                           
                                      </div>                                                                                                                                               
                                   </div>
                              </div>
                              <div class="form-group input-group" id="forTransferTypeOut">
                                  <div class="col-md-4">
                                      <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">Customer Name:</span>
                                          <input type="text" name="customerName" id="customerName" class="form-control" value="<?php echo $customerName; ?>" aria-describedby="basic-addon1" disabled readonly>                                                                                           
                                      </div>                                                                                                                                               
                                   </div>
                                  <div class="col-md-4">
                                      <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">Model:</span>
                                          <input type="text" name="model" id="model" class="form-control" value="<?php echo $model; ?>" aria-describedby="basic-addon1" disabled readonly>                                                                                           
                                      </div>                                                                                                                                               
                                   </div>
                                   <div class="col-md-4">
                                      <div class="input-group">
                                          <span class="input-group-addon" id="basic-addon1">Serial Number:</span>
                                          <input type="text" name="serialNumber" id="serialNumber" class="form-control" value="<?php echo $serialNumber; ?>" aria-describedby="basic-addon1" disabled readonly>                                                                                           
                                      </div>                                                                                                                                               
                                   </div>
                              </div>                                                                          
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Record History
                            </div>
                            <div class="panel-body">
                                <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-condensed table-hover" id="recordHistory">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" bgcolor="#e5e5e5" width="">TIMESTAMP</th> <!-- 2 -->
                                                    <th class="text-center" bgcolor="#f2ba7f">Date&nbsp;(M/D/Y)</th> <!-- 3 -->
                                                    <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;Type</th> <!-- 4 -->
                                                    <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;#</th> <!-- 5 -->
                                                    <th class="text-center" bgcolor="#f2ba7f">Quantity</th> <!-- 6 -->
                                                    <th class="text-center" bgcolor="#f2ba7f"width="">+&nbsp;/&nbsp;−</th> <!-- 11 -->
                                                    <th class="text-center" bgcolor="#f2ba7f">Transfer&nbsp;Type</th> <!-- 10 -->
                                                    <th class="text-center" bgcolor="#f2ba7f">Update&nbsp;by</th> <!--  -->
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center" bgcolor="#e5e5e5" width="">TIMESTAMP</th> <!-- 2 -->
                                                    <th class="text-center" bgcolor="#f2ba7f">Date&nbsp;(M/D/Y)</th> <!-- 3 -->
                                                    <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;Type</th> <!-- 4 -->
                                                    <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;#</th> <!-- 5 -->
                                                    <th class="text-center" bgcolor="#f2ba7f">Quantity</th> <!-- 6 -->
                                                    <th class="text-center" bgcolor="#f2ba7f"width="">+&nbsp;/&nbsp;−</th> <!-- 11 -->
                                                    <th class="text-center" bgcolor="#f2ba7f">Transfer&nbsp;Type</th> <!-- 10 -->
                                                    <th class="text-center" bgcolor="#f2ba7f">Update&nbsp;by</th> <!--  -->
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            <?php 
                                                require '../../database.php';
                                                $sql = "SELECT 
                                                        tbl_warehouse_history.timestamp, 
                                                        tbl_warehouse_history.date,
                                                        tbl_reference.referenceType,
                                                        tbl_warehouse_history.referenceNumber,
                                                        tbl_warehouse_history.quantity,
                                                        tbl_warehouse_history.quantityChange,
                                                        tbl_transfer_type.transferType,
                                                        tbl_users.username
                                                        FROM tbl_warehouse_history 
                                                        INNER JOIN tbl_reference
                                                        ON tbl_warehouse_history.reference_id = tbl_reference.reference_id
                                                        INNER JOIN tbl_transfer_type
                                                        ON tbl_transfer_type.transferType_id = tbl_warehouse_history.transferType_id
                                                        INNER JOIN tbl_users
                                                        ON tbl_warehouse_history.user_id = tbl_users.user_id
                                                        WHERE tbl_warehouse_history.stock_id = ".$stock_id."
                                                        ORDER BY tbl_warehouse_history.history_id DESC;";
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
                                            ?>
                                                <tr>
                                                    <td class="text-center" title="<?php  echo date('h:i:s A', strtotime($timestamp)); ?>"><?php  echo date('m/d/Y', strtotime($timestamp)); ?></td>
                                                    <td class="text-center"><?php echo date('m/d/Y', strtotime($date)); ?></td>
                                                    <td class="text-center"><?php echo $referenceType; ?></td>
                                                    <td class="text-center"><?php echo $referenceNumber; ?></td>
                                                    <td class="text-center"><?php echo $quantity; ?></td>
                                                    <td class="text-center"><?php echo $quantityChange; ?></td>
                                                    <td class="text-center"><?php echo $transferType ?></td>
                                                    <td class="text-center"><?php echo $username ?></td>
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
                </div>
                <!-- /. ROW  -->                
				<?php include("includes/footer.php") ?>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
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
                $('#forTransferTypeOut').remove();
              }
    </script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    <script src="../../assets/js/notify.min.js"></script>
</body>
</html>