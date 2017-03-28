<?php
    include('session.php');   
?>
<!DOCTYPE html>
<html lang="en">
<?php include("includes/header.php") ?>
<style>
 #addNewItem .modal-header {
      background-color: #5cb85c;
      color: #fff;
      font-weight: bold;
      text-align: center;
 }

 #stockIn .modal-header {
      background-color: #5cb85c;
      color: #fff;
      font-weight: bold;
      text-align: center;
 } 

 #stockOut .modal-header {
      background-color: #d9534f;
      color: #fff;
      font-weight: bold;
      text-align: center;
 }     

#stockDelete .modal-header {
      background-color: #d9534f;
      color: #fff;
      font-weight: bold;
      text-align: center;
 }
</style>
<body onload="startTime()">
    <!-- WRAPPER START-->
    <!-- WRAPPER START-->
    <!-- WRAPPER START-->
    <div id="wrapper">
        <!-- TOP NAVIGATION -->
        <?php include("includes/topNavigation.php") ?>
        <!-- SIDE NAVIGATION -->
        <?php include("includes/sideNavigation.php") ?>
        <!-- PAGE CONTENT -->
		<div id="page-wrapper">
            <div class="header"> 
                <h2 class="page-header">
                    <code class="text-success">SITE:SERVICE&nbsp;DEPARTMENT</code>
                </h2>
                <ol class="breadcrumb">
                    <li class="active">All Records</li>
                </ol>                
            </div>            
            <div id="page-inner">
                <div class="row">
                        <!-- RECORDS COUNT BOX     -->
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="panel panel-primary text-center no-boder blue">
                                <div class="panel-left pull-left blue">
                                    <i class="fa fa-list-alt fa-5x"></i>
                                    
                                </div>
                                <div class="panel-right">
                                    <?php 
                                        require '../../database.php';
                                        $sql = "SELECT COUNT(*) FROM tbl_service;";
                                        $row = mysqli_fetch_array(mysqli_query($conn, $sql), MYSQL_NUM); 
                                    ?>
                                    <h3><?php echo $row[0]; mysqli_close($conn); ?></h3>
                                   <div align="left" style="font-size:15px"><strong> Total number of items</strong></div><br>
                                </div>
                            </div>
                        </div>
                        <!-- SERVER DATE & TIME BOX -->
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="panel panel-primary text-center no-boder blue">
                                    <div class="panel-left pull-left blue">
                                        <i class="fa fa-clock-o fa-5x"></i>
                                        <i class="fa fa-calendar fa-5x"></i>
                                    </div>
                                    <div class="panel-right">
                                        <br>
                                        <div align="left" style="font-size:25px" id="time"></div>
                                        <div align="left" style="font-size:18px"><?php  echo date("F d, Y | l"); ?></div>
                                        <div align="left" style="font-size:15px"><strong> Server Date & Time</strong></div><br>
                                    </div>
                            </div>
                        </div>                    
                </div>  
                <div class="row">
                     <!--  ADD NEW ITEM MODAL -->
                    <div class="modal fade" id="addNewItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h3 class="modal-title" id="myModalLabel"><strong>IN</strong></h3>
                                    <h4 class="modal-title" id="myModalLabel"><strong>Add New Stock Item</strong></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-1"></div>                     
                                        <div class="col-sm-10">               
                                            <form role="form" class="form-horizontal" action="phpScripts/addNewItem.php" method="post">
                                                <div class="form-group">
                                                    <label class="text-danger"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label><strong>Required</strong>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="date"><label class="text-danger"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label> Date: (Click to change)</label>
                                                            <div class="input-group date form_date col-md-12">
                                                                <input id="date" name="date" class="form-control" type="text" value="<?php echo date('Y-m-d'); ?>" placeholder="YEAR-MONTH-DAY" required  readonly>
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-6">
                                                                <label for="description"><label class="text-danger"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label> Description:</label>
                                                                <input type="text" name="description" class="form-control" id="description" placeholder="Description" required autofocus autocomplete="off">                                                                                                                 
                                                         </div>
                                                    </div>
                                                </div>                                                    
                                                <div class="form-group">
                                                    <div class="row">
                                                         <div class="col-md-4">
                                                            <label for="reference_id"><label class="text-danger"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label> Reference Type</label>
                                                                <select class="form-control" name="reference_id" id="reference_id">
                                                                    <option value="1">Purchase Order (Unit)</option>
                                                                    <option value="2">Purchase Order (Parts)</option>
                                                                    <option value="3">Transfer Ticket</option>
                                                                    <option value="4">Pick-Up Order</option>
                                                                    <option value="6">Delivery Receipt</option>
                                                                </select>        
                                                         </div>
                                                         <div class="col-md-4">
                                                            <label for="referenceNumber"><label class="text-danger"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label> Reference Number</label>
                                                            <input type="text" name="referenceNumber" class="form-control" id="referenceNumber" placeholder="Reference Number" required autocomplete="off"> 
                                                         </div>
                                                        <div class="col-md-4" id="receivingReport">
                                                            <label for="receivingReport"><label class="text-danger"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label> Receiving Report</label>
                                                            <input type="text" name="receivingReport" class="form-control" id="receivingReport" placeholder="Receiving Report" autocomplete="off"> 
                                                         </div>                                                             
                                                    </div>
                                                </div>                                                    
                                                <div class="form-group">
                                                    <div class="row">                                                       
                                                        <div class="col-md-4">
                                                                <label for="partNumber"><label class="text-danger"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label> Part Number:</label>
                                                                <input type="text" name="partNumber" class="form-control" id="partNumber" placeholder="Part Number" required autocomplete="off">                                                     
                                                        </div>    
                                                        <div class="col-md-4">
                                                            <label for="quantity"><label class="text-danger"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label> Quantity:</label>
                                                            <input type="number" name="quantity" class="form-control" id="quantity" placeholder="Quantity" required autocomplete="off"> 
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="minStockCount"><label class="text-danger"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label> Min Stock Count:</label>
                                                            <input type="number" name="minStockCount" class="form-control" id="minStockCount" placeholder="Minimum Stock" required autocomplete="off"> 
                                                        </div>
                                                        <input type="hidden" name="transferType_id" id="transferType_id" value="2">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">                                                       
                                                        <div class="col-md-4">
                                                            <label for="cost"><label class="text-danger"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label> Cost (₱ 000.00):</label>
                                                            <input type="text" name="cost" class="form-control" id="cost" placeholder="Unit Price (₱ 000.00)" required autocomplete="off">                                                     
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="unitPrice"><label class="text-danger"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label> Unit Price (₱ 000.00):</label>
                                                            <input type="text" name="unitPrice" class="form-control" id="unitPrice" placeholder="Unit Price (₱ 000.00)" required autocomplete="off">                                                     
                                                        </div>
                                                    </div>
                                                </div>          
                                                <div class="form-group">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-6">
                                                        <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                                                    </div>
                                                    <div class="col-md-3"></div>
                                                </div>                                                                                                                                                           
                                            </form>   
                                        </div>
                                        <div class="col-sm-1"></div>                     
                                    </div>    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <!-- <button type="button" class="btn btn-primary">Save</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- CURRENT STOCK RECORDS (A-Z) -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <button class="btn btn-success btn" data-toggle-tooltip="tooltip" data-placement="top" title="" data-toggle="modal" data-target="#addNewItem">
                                  <span class="glyphicon glyphicon-plus"></span> New Item
                                </button>
                                &nbsp;&nbsp;&nbsp;Current Stock Records (A-Z)
                            </div> 
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-condensed table-hover" id="recordsTable">
                                        <thead>
                                            <tr>
                                                <th class="text-center" bgcolor="f2ba7f" width="">Date&nbsp;(M/D/Y)</th> <!-- 1 -->
                                                <th class="text-center" bgcolor="f2ba7f" width="">Description</th> <!-- 2 --> 
                                                <th class="text-center" bgcolor="f2ba7f" width="">Reference&nbsp;Type</th><!--  3 -->
                                                <th class="text-center" bgcolor="f2ba7f" width="">Reference&nbsp;#</th> <!-- 4 -->
                                                <th class="text-center" bgcolor="f2ba7f" width="">Part&nbsp;#</th> <!-- 5 -->
                                                <th class="text-center" bgcolor="f2ba7f" width="">Cost</th> <!-- 6 -->
                                                <th class="text-center" bgcolor="f2ba7f" width="">−</th>
                                                <th class="text-center" bgcolor="f2ba7f" width="">Stock Count</th> <!-- 8 -->
                                                <th class="text-center" bgcolor="f2ba7f" width="">+</th>
                                                <th class="text-center" bgcolor="f2ba7f" width="">Actions</th> <!-- none -->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th bgcolor="f2ba7f" width="">Date&nbsp;(M/D/Y)</th> <!-- 1 -->
                                                <th bgcolor="f2ba7f" width="">Description</th> <!-- 2 --> 
                                                <th bgcolor="f2ba7f" width="">Reference&nbsp;Type</th><!--  3 -->
                                                <th bgcolor="f2ba7f" width="">Reference&nbsp;#</th> <!-- 4 -->
                                                <th bgcolor="f2ba7f" width="">Part&nbsp;#</th> <!-- 5 -->
                                                <td bgcolor="f2ba7f" width=""></td>
                                                <td bgcolor="f2ba7f" width=""></td>
                                                <td bgcolor="f2ba7f" width=""></td>
                                                <td bgcolor="f2ba7f" width=""></td>
                                                <td bgcolor="f2ba7f" width=""></td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php 
                                            require '../../database.php';
                                            $sql = "SELECT tbl_service.stock_id,
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
                                                           tbl_service.cost
                                                    FROM tbl_service
                                                    INNER JOIN tbl_reference
                                                    ON tbl_service.reference_id = tbl_reference.reference_id
                                                    INNER JOIN tbl_transfer_type
                                                    ON tbl_service.transferType_id = tbl_transfer_type.transferType_id;";
                                            // echo $sql;
                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
                                                    $stock_id = $row[0];
                                                    $date = $row[1];
                                                    $description = $row[2];
                                                    $referenceType = $row[3];
                                                    $referenceNumber = $row[4];
                                                    $partNumber = $row[5];
                                                    $quantity = $row[6];
                                                    $customerName = $row[7];
                                                    $model = $row[8];
                                                    $serialNumber = $row[9];
                                                    $minStockCount = $row[10];
                                                    $transferType = $row[11];
                                                    $unitPrice = $row[12];
                                                    $cost = $row[13];
                                        ?>
                                            <tr class="<?php if($quantity <= $minStockCount) echo "danger"; else echo "success";?>">
                                                <td><?php  echo date('m/d/Y', strtotime($date)); ?></td>
                                                <td><?php  echo $description; ?></td>
                                                <td><?php  echo $referenceType; ?></td>
                                                <td><?php  echo $referenceNumber; ?></td>
                                                <td><?php  echo $partNumber; ?></td>
                                                <td class="text-center"><?php  echo "₱ " . $cost; ?></td>
                                                <!-- <td class="text-center"><?php  echo "₱ ". ($unitPrice * $quantity); ?></td> -->
                                                <td class="text-center">
                                                    <button data-toggle="modal" data-target="#stockOut" data-toggle-tooltip="tooltip" title="OUT" class="btn btn-danger btn-xs" data-id="<?php echo $row[0]; ?>"><span class="glyphicon glyphicon-minus"></span></button>                                                     
                                                </td>
                                                <td class="text-center">
                                                    <strong><?php echo $quantity; ?></strong>
                                                </td>
                                                <td class="text-center">
                                                    <button data-toggle="modal" data-target="#stockIn" data-toggle-tooltip="tooltip" title="IN" class="btn btn-success btn-xs" data-id="<?php echo $row[0]; ?>"><span class="glyphicon glyphicon-plus"></span></button>
                                                </td>
                                                <td class="text-center">
                                                    <a href="moreDetails.php?stock_id=<?php echo $stock_id; ?>" class="btn btn-info btn-xs">Details <span class="glyphicon glyphicon-list-alt"></span></a>
                                                    <button type="button" class="btn btn-danger btn-xs" title="Delete" data-toggle="modal" data-target="#stockDelete" data-id="<?php echo $stock_id; ?>"><span class="glyphicon glyphicon-trash"></span></button>    
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
                </div>
				<?php include("includes/footer.php") ?>
            </div>
        </div>
        <!-- PAGE CONTENT END -->
    </div>
    <!-- WRAPPER END  -->
    <!-- WRAPPER END  -->
    <!-- WRAPPER END  -->

    <!-- STOCK OUT MODAL -->
    <div id="stockOut" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-center">
                <div class="fetched-data-stockOutModal"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- STOCK IN MODAL -->                                                     
    <div id="stockIn" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-center">
                <div class="fetched-data-stockInModal"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>          

    <!-- DELETE ITEM MODAL-->
    <div id="stockDelete" class="modal fade" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header modal-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><strong>Delete Item?</strong></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-1"></div>                     
                        <div class="col-sm-10">       
                            <div class="fetched-data-deleteStockModal"></div>        
                        </div>
                        <div class="col-sm-1"></div>                     
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <?php include("includes/scripts.php") ?>    
    <script>
        $(document).ready(function () {
                $('#recordsTable').dataTable({
                'iDisplayLength': 25, 
                'lengthMenu': [ [25, 50, 100, -1], [25, 50, 100, 'All'] ],
                'order': [ 0, 'desc' ],
                 });
            });

            $(document).ready(function() {
                var table = $('#recordsTable').DataTable();
             
                $("#recordsTable tfoot th").each( function ( i ) {
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

            $(document).ready(function(){
                $('#stockDelete').on('show.bs.modal', function (e) {
                    var stock_id = $(e.relatedTarget).data('id');
                    $.ajax({
                        type : 'post',
                        url : 'phpScripts/fetch_deleteStockModal.php', //Here you will fetch records 
                        data :  'stock_id=' + stock_id, //Pass $id
                        success : function(data){
                        $('.fetched-data-deleteStockModal').html(data);//Show fetched data from database
                        }
                    });
                 });
            });

            $(document).ready(function(){
                $('#stockIn').on('show.bs.modal', function (e) {
                    var stock_id = $(e.relatedTarget).data('id');
                    $.ajax({
                        type : 'post',
                        url : 'phpScripts/fetch_stockInModal.php', //Here you will fetch records 
                        data :  'stock_id=' + stock_id, //Pass $id
                        success : function(data){
                        $('.fetched-data-stockInModal').html(data);//Show fetched data from database
                        }
                    });
                 });
            });

            $(document).ready(function(){
                $('#stockOut').on('show.bs.modal', function (e) {
                    var stock_id = $(e.relatedTarget).data('id');
                    $.ajax({
                        type : 'post',
                        url : 'phpScripts/fetch_stockOutModal.php', //Here you will fetch records 
                        data :  'stock_id=' + stock_id, //Pass $id
                        success : function(data){
                        $('.fetched-data-stockOutModal').html(data);//Show fetched data from database
                        }
                    });
                 });
            });     
            
            if (<?php echo $_SESSION['isFirstLogin']; ?>) {
                $(document).ready(function() {
                    BootstrapDialog.show({
                        type: BootstrapDialog.TYPE_WARNING,
                        title: 'Warning',
                        message: '<strong>Important:</strong> Make sure that the server\'s date and time is correct to avoid errors.',
                        onshow: function(dialogRef){
                                dialogRef.enableButtons(false);
                                dialogRef.setClosable(false);
                                setTimeout(function(){
                                    dialogRef.close();
                                }, 3000);
                        }

                    });              
                });      
                <?php $_SESSION['isFirstLogin'] = "false"; ?>      
            }; 

            $(document).ready(function() {
                $('#reference_id').change(function(event) {
                    if($(this).val() == '1' || $(this).val() == '2') {
                        $('#receivingReport').fadeIn();
                        $('#receivingReport #receivingReport').val("");
                    } else {
                        $('#receivingReport').fadeOut();
                        $('#receivingReport #receivingReport').val("N/A");
                    }
                });
            });                                           
    </script>
</body>
</html>