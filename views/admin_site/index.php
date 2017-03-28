<?php
    include('session.php');
?>
<!DOCTYPE html>
<html lang="en">
<?php include("includes/header.php") ?>
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
                    <code class="text-success">SITE:ADMINISTRATOR</code>
                </h2>
                <ol class="breadcrumb">
                    <li class="active">All Records</li>
                </ol>                
            </div>            
            <div id="page-inner">              
                <div class="row">
                    <!-- RECORDS COUNT BOX -->
                    <div class="col-md-3 col-sm-4 col-xs-4">
                        <div class="panel panel-primary text-center no-boder blue">
                            <div class="panel-right">
                                <?php 
                                    // require '../../database.php';
                                    // $sql = "SELECT COUNT(*) FROM tbl_warehouse;";
                                    // $row = mysqli_fetch_array(mysqli_query($conn, $sql), MYSQL_NUM); 
                                ?>
                                <!-- <h3><strong><?php echo $row[0]; mysqli_close($conn); ?></strong></h3> -->
                               <strong> Warehouse Records</strong>
                            </div>
                        </div>
                    </div>                                                      
                    <div class="col-md-3 col-sm-4 col-xs-4">
                        <div class="panel panel-primary text-center no-boder blue">
                            <div class="panel-right">
                                <?php 
                                    // require '../../database.php';
                                    // $sql = "SELECT COUNT(*) FROM tbl_service;";
                                    // $row = mysqli_fetch_array(mysqli_query($conn, $sql), MYSQL_NUM); 
                                ?>
                                <!-- <h3><strong><?php echo $row[0]; mysqli_close($conn); ?></strong></h3> -->
                               <strong> Service Records</strong>
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
                                    <div align="left" style="font-size:15px"><strong> SERVER DATE &AMP; TIME</strong></div><br>
                                </div>
                        </div>
                    </div>                    
                </div> 

                <div class="row">
                    <!-- RECENT WAREHOUSE STOCK LOGS (A-Z) -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Manage Items
                            </div> 
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-condensed table-hover" id="warehouseTable">
                                        <thead>
                                            <tr>
                                                <th class="text-center" bgcolor="#fff" width=""><font color="#000">Description</font></th>
                                                <th class="text-center" bgcolor="#fff" width=""><font color="#000">Part&nbsp;#</font></th>
                                                <th class="text-center" bgcolor="#fff" width=""><font color="#000">Actions</font></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center" gcolor="#fff" width=""><font color="#000">Description</font></th>
                                                <th class="text-center" or="#fff" width=""><font color="#000">Part&nbsp;#</font></th>
                                                <td bgcolor="#fff" width=""></td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php 
                                            require '../../database.php';
                                            $sql = "SELECT DISTINCT 
                                                    tbl_item.description,
                                                    tbl_item.partNumber
                                                    FROM tbl_item 
                                                    WHERE tbl_item.status = 0
                                                    ORDER BY tbl_item.description;";
                                            // echo $sql;
                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
                                                    $description = $row[0];
                                                    $partNumber = $row[1];   
                                        ?>
                                            <tr>
                                                <td class="text-center"><?php  echo $description; ?></td>
                                                <td class="text-center"><?php  echo $partNumber; ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-xs" title="Delete" data-toggle="modal" data-target="#stockDelete" data-id="<?php echo $item_id; ?>">Delete <span class="glyphicon glyphicon-trash"></span></button>    
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
                $('#warehouseTable').dataTable({
                'iDisplayLength': 15, 
                'lengthMenu': [ [15, 50, 100, -1], [15, 50, 100, 'All'] ],
                'order': [ 0, 'desc' ],
                 });

                $('#serviceTable').dataTable({
                'iDisplayLength': 15, 
                'lengthMenu': [ [15, 50, 100, -1], [15, 50, 100, 'All'] ],
                'order': [ 0, 'desc' ],
                 });
            });

            $(document).ready(function() {
                var warehouse_table = $('#warehouseTable').DataTable();
             
                $("#warehouseTable tfoot th").each( function ( i ) {
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(this).empty() )
                        .on( 'change', function () {
                            warehouse_table.column( i )
                                .search( $(this).val() )
                                .draw();
                        } );
             
                    warehouse_table.column( i ).data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );

                var service_table = $('#serviceTable').DataTable();
             
                $("#serviceTable tfoot th").each( function ( i ) {
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(this).empty() )
                        .on( 'change', function () {
                            service_table.column( i )
                                .search( $(this).val() )
                                .draw();
                        } );
             
                    service_table.column( i ).data().unique().sort().each( function ( d, j ) {
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
                        url : 'fetch_deleteStockModal.php', //Here you will fetch records 
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
                        url : 'fetch_stockInModal.php', //Here you will fetch records 
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
                        url : 'fetch_stockOutModal.php', //Here you will fetch records 
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
    </script>
</body>
</html>