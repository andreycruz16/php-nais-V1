<?php
    include('session.php');
    require '../../database.php';  
 ?>

<!DOCTYPE html>
<html lang="en">
<?php include("includes/header.php") ?>
<style>
 #recentStockDetails .modal-header {
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

        <!-- WRAPPER START  -->
        <!-- WRAPPER START  -->
        <!-- WRAPPER START  -->

		<div id="page-wrapper">
            <div class="header"> 
                <h2 class="page-header">
                    <code class="text-success">RECENT STOCK LOGS</code>
                </h2>
                <ol class="breadcrumb">
                    <li class="active">Recent Stock Logs</li>
                </ol>
            </div>
            <div id="page-inner">
                <div class="row">
                    <!-- Recent Stock Logs RECORD -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Recent Stock Logs
                            </div>
                            <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-condensed table-hover" id="recordHistory">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" bgcolor="#e5e5e5" width="155">TIMESTAMP</th>
                                                    <th class="text-center" bgcolor="#f2ba7f" width="">Date&nbsp;(M/D/Y)</th>
                                                    <th class="text-center" bgcolor="#f2ba7f" width="">Description</th>
                                                    <th class="text-center" bgcolor="#f2ba7f" width="">Reference&nbsp;Type</th>
                                                    <th class="text-center" bgcolor="#f2ba7f" width="">Reference&nbsp;#</th>
                                                    <th class="text-center" bgcolor="#f2ba7f" width="">Part&nbsp;#</th>
                                                    <th class="text-center" bgcolor="#f2ba7f" width="">Quantity</th>
                                                    <th class="text-center" bgcolor="#f2ba7f" width="">+&nbsp;/&nbsp;−</th>
                                                    <th class="text-center" bgcolor="#f2ba7f" width="5">Transfer&nbsp;Type</th>
                                                    <th class="text-center" bgcolor="#f2ba7f" width="5">Update&nbsp;By</th>
                                                    <th class="text-center" bgcolor="#f2ba7f" width="">Action</th> 
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th bgcolor="#e5e5e5" width="155">TIMESTAMP</th>
                                                    <th bgcolor="#f2ba7f" width="">Date&nbsp;(M/D/Y)</th>
                                                    <th bgcolor="#f2ba7f" width="">Description</th>
                                                    <th bgcolor="#f2ba7f" width="">Reference&nbsp;Type</th>
                                                    <th bgcolor="#f2ba7f" width="">Reference&nbsp;#</th>
                                                    <th bgcolor="#f2ba7f" width="">Part&nbsp;#</th>
                                                    <th bgcolor="#f2ba7f" width="">Quantity</th>
                                                    <th bgcolor="#f2ba7f" width="">+&nbsp;/&nbsp;−</th>
                                                    <th bgcolor="#f2ba7f" width="5">Transfer&nbsp;Type</th>
                                                    <th bgcolor="#f2ba7f" width="5">Update&nbsp;By</th>
                                                    <td bgcolor="#f2ba7f" width=""></td> 
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            <?php 
                                                require '../../database.php';
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
                                                          tbl_transfer_type.transferType,
                                                          tbl_users.username
                                                        FROM
                                                          tbl_warehouse_history
                                                        INNER JOIN
                                                          tbl_warehouse ON tbl_warehouse_history.stock_id = tbl_warehouse.stock_id
                                                        INNER JOIN
                                                          tbl_reference ON tbl_warehouse_history.reference_id = tbl_reference.reference_id
                                                        INNER JOIN
                                                          tbl_transfer_type ON tbl_warehouse_history.transferType_id = tbl_transfer_type.transferType_id
                                                        INNER JOIN
                                                          tbl_users ON tbl_warehouse_history.user_id = tbl_users.user_id
                                                        ORDER BY
                                                          tbl_warehouse_history.history_id DESC;";   
                                                // echo $sql;
                                                $result = mysqli_query($conn, $sql);
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
                                                        $transferType = $row[9];
                                                        $username = $row[10];
                                            ?>
                                                <tr>
                                                    <td class="text-center" title="<?php  echo date('h:i:s A', strtotime($timestamp)); ?>"><?php  echo date('m/d/Y', strtotime($timestamp)); ?></td>
                                                    <td><?php echo date('m/d/Y', strtotime($date)); ?></td>
                                                    <td><?php echo $description; ?></td>
                                                    <td><?php echo $referenceType; ?></td>
                                                    <td><?php echo $referenceNumber; ?></td>
                                                    <td><?php echo $partNumber; ?></td>
                                                    <td><?php echo $quantity; ?></td>
                                                    <td><?php echo $quantityChange; ?></td>
                                                    <td><?php echo $transferType; ?></td>
                                                    <td><?php echo $username; ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-info btn-xs" title="Details" data-toggle="modal" data-target="#recentStockDetails" data-id="<?php echo $history_id; ?>">Details <span class="glyphicon glyphicon-list-alt"></span></button>
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

        <!-- WRAPPER END  -->
        <!-- WRAPPER END  -->
        <!-- WRAPPER END  -->
    </div>

    <!-- RECENT STOCK DETAILS -->                                                     
    <div id="recentStockDetails" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="fetched-data-recentStockDetailsModal"></div>
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

            $(document).ready(function(){
                $('#recentStockDetails').on('show.bs.modal', function (e) {
                    var history_id = $(e.relatedTarget).data('id');
                    $.ajax({
                        type : 'post',
                        url : 'phpScripts/fetch_stockDetailsModal.php', //Here you will fetch records 
                        data :  'history_id=' + history_id, //Pass $id
                        success : function(data){
                        $('.fetched-data-recentStockDetailsModal').html(data);//Show fetched data from database
                        }
                    });
                 });
            });              
    </script>
</body>
</html>