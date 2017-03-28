<?php
    include('session.php');
?>
<!DOCTYPE html>
<html lang="en">
<?php include("includes/header.php") ?>
<style>
 #addNewItem .modal-header {
      background-color: #1b89ae;
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
                    <code class="text-success">SITE:WAREHOUSE&nbsp;DEPARTMENT</code>
                </h2>
                <ol class="breadcrumb">
                    <li class="active">All Records</li>
                </ol>                
            </div>            
            <div id="page-inner">
                <div class="row">
                        <!-- RECORDS COUNT BOX     -->
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <div class="panel panel-primary text-center no-boder blue">
<!--                                 <div class="panel-left pull-left blue">
                                    <i class="fa fa-list-alt fa-5x"></i>
                                </div> -->
                                <div class="panel-right">
                                    <?php 
                                        require '../../database.php';
                                        $sql = "SELECT COUNT(*) FROM tbl_item WHERE tbl_item.status = 0;";
                                        $row = mysqli_fetch_array(mysqli_query($conn, $sql), MYSQL_NUM); 
                                    ?>
                                    <h3><?php echo $row[0]; mysqli_close($conn); ?></h3>
                                   <div align="left" style="font-size:15px"><strong> Total number of items</strong></div><br>
                                </div>
                            </div>
                        </div>
                        <!-- LOW STOCKS     -->
                        <?php 
                            require '../../database.php';
                            $sql = "SELECT COUNT(*) FROM
                                    (
                                    SELECT
                                    COUNT(DISTINCT tbl_item.item_id)
                                    FROM tbl_item_history
                                    INNER JOIN tbl_item
                                    ON tbl_item_history.item_id = tbl_item_history.item_id
                                    WHERE tbl_item_history.history_id IN (SELECT MAX(tbl_item_history.history_id) FROM tbl_item_history
                                    GROUP BY tbl_item_history.item_id) AND tbl_item_history.quantity <= tbl_item.minStockCount
                                    AND tbl_item.status = 0
                                    GROUP BY tbl_item_history.item_id
                                    ) d1;";
                            $row = mysqli_fetch_array(mysqli_query($conn, $sql), MYSQL_NUM);
                        ?>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <div class="panel panel-primary text-center no-boder <?php if($row[0] > 0) echo "red"; else echo "blue"; ?>">
  <!--                               <div class="panel-left pull-left blue">
                                    <i class="fa fa-list-alt fa-5x"></i>
                                </div> -->
                                <div class="panel-right">
                                    <h3><?php echo $row[0]; mysqli_close($conn); ?></h3>
                                   <div align="left" style="font-size:15px"><strong> Number of Low Stocks</strong></div><br>
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
                    <!-- CURRENT STOCK RECORDS (A-Z) -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <button class="btn btn-success btn" data-toggle-tooltip="tooltip" data-placement="top" title="" data-toggle="modal" data-target="#addNewItem">
                                  <span class="glyphicon glyphicon-plus"></span> Add New
                                </button>
                                &nbsp;All Items (A-Z)
                            </div> 
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-condensed table-hover" id="recordsTable">
                                        <thead>
                                            <tr>
                                                <th class="text-center" bgcolor="e5e5e5" width="">ID</th>
                                                <th class="text-center" bgcolor="f2ba7f" width="">Description</th>
                                                <th class="text-center" bgcolor="f2ba7f" width="">Part&nbsp;#</th>
                                                <th class="text-center" bgcolor="f2ba7f" width="">Box&nbsp;#</th>
                                                <th class="text-center" bgcolor="f2ba7f" width="">Order Point</th>
                                                <th class="text-center" bgcolor="f2ba7f" width="">Stock&nbsp;On&nbsp;Hand</th>
                                                <th class="text-center" bgcolor="f2ba7f" width="">Status</th>
                                                <th class="text-center" bgcolor="f2ba7f" width="">View</th>
                                                <th class="text-center" bgcolor="f2ba7f" width="">Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center" bgcolor="e5e5e5" width="">&nbsp;</th>
                                                <th bgcolor="f2ba7f" width="">&nbsp;</th>
                                                <th bgcolor="f2ba7f" width="">&nbsp;</th>
                                                <th class="text-center" bgcolor="f2ba7f" width="">&nbsp;</th>
                                                <th class="text-center" bgcolor="f2ba7f" width="">&nbsp;</th>
                                                <th class="text-center" bgcolor="f2ba7f" width="">&nbsp;</th>
                                                <td bgcolor="f2ba7f" width="">&nbsp;</td>
                                                <td bgcolor="f2ba7f" width="">&nbsp;</td>
                                                <td bgcolor="f2ba7f" width="">&nbsp;</td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php 
                                            require '../../database.php';

                                            $sql = "SELECT 
                                                    tbl_item_history.item_id,
                                                    tbl_item.description,
                                                    tbl_item.partNumber,
                                                    tbl_item.boxNumber,
                                                    tbl_item.minStockCount,
                                                    tbl_item_history.quantity,
                                                    tbl_item_history.dept_id,
                                                    tbl_item_history.history_id
                                                    FROM tbl_item_history
                                                    INNER JOIN tbl_item
                                                    ON tbl_item_history.item_id = tbl_item.item_id
                                                    WHERE tbl_item_history.history_id IN (SELECT MAX(tbl_item_history.history_id) FROM tbl_item_history 
                                                    GROUP BY tbl_item_history.item_id) AND tbl_item.status = 0
                                                    GROUP BY tbl_item_history.item_id;";

                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
                                                    $item_id = $row[0];
                                                    $description = $row[1];
                                                    $partNumber = $row[2];
                                                    $boxNumber = $row[3];
                                                    $minStockCount = $row[4];
                                                    $quantity = $row[5];
                                        ?>
                                            <tr class="<?php if($quantity <= $minStockCount) echo "danger"; else echo "success";?>">
                                                <td class="text-center"><?php  echo $item_id; ?></td>
                                                <td><?php  echo $description; ?></td>
                                                <td><?php  echo $partNumber; ?></td>
                                                <td class="text-center"><?php  echo $boxNumber; ?></td>
                                                <td class="text-center"><?php  echo $minStockCount; ?></td>
                                                <td class="text-center">                                                    
                                                    <strong><?php echo $quantity; ?></strong>
                                                </td>
                                                <td class="text-center" >
                                                    <span class="label label-<?php if($quantity <= $minStockCount && $quantity > 0) echo "warning"; else if($quantity == 0) echo "danger"; else echo "success";?>"><?php if($quantity <= $minStockCount && $quantity > 0) echo "Low Stock"; else if($quantity == 0) echo "Out Of Stock"; else echo "Available";?></span>
                                                </td>
                                                <td class="text-center" >
                                                    <a href="moreDetails.php?item_id=<?php echo $item_id; ?>" class="btn btn-primary btn-xs">View Record <span class="glyphicon glyphicon-list-alt"></span></a>
                                                </td>
                                                <td class="text-center" >
                                                    <button data-toggle="modal" data-target="#stockIn" data-toggle-tooltip="tooltip" title="IN" class="btn btn-success btn-xs" data-id="<?php echo $item_id; ?>"><span class="glyphicon glyphicon-plus"></span></button>
                                                    <button data-toggle="modal" data-target="#stockOut" data-toggle-tooltip="tooltip" title="OUT" class="btn btn-danger btn-xs" data-id="<?php echo $item_id; ?>"><span class="glyphicon glyphicon-minus"></span></button> 
                                                    <button type="button" class="btn btn-danger btn-xs" title="Delete" data-toggle="modal" data-target="#stockDelete" data-id="<?php echo $item_id; ?>"><span class="glyphicon glyphicon-trash"></span></button>    
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

     <!--  ADD NEW ITEM MODAL -->
    <div class="modal fade" id="addNewItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title" id="myModalLabel">New Item</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-1"></div>                     
                        <div class="col-sm-10">       
                            <div><strong>ASK THE ADMINISTRATOR TO ADD A NEW ITEM</strong></div>
                        </div>
                        <div class="col-sm-1"></div>                     
                    </div>
                </div>
            </div>
        </div>
    </div>    

    <!-- STOCK OUT MODAL -->
    <div id="stockOut" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content text-center">
                <div class="fetched-data-stockOutModal"></div>
<!--                 <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div> -->
            </div>
        </div>
    </div>

    <!-- STOCK IN MODAL -->                                                     
    <div id="stockIn" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content text-center">
                <div class="fetched-data-stockInModal"></div>
<!--                 <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div> -->
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
<!--                 <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cancel</button>
                </div> -->
            </div>
        </div>
    </div>
    <?php include("includes/scripts.php") ?>
    <script>
        $(document).ready(function () {
                $('#recordsTable').dataTable({
                'iDisplayLength': 25, 
                'lengthMenu': [ [25, 50, 100, -1], [25, 50, 100, 'All'] ],
                // 'order': [ 0, 'asc' ],
                'bSort': true
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

        $(document).ready(function() {
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
        });


        $(document).ready(function(){
            $('#stockDelete').on('show.bs.modal', function (e) {
                var item_id = $(e.relatedTarget).data('id');
                $.ajax({
                    type : 'post',
                    url : 'phpScripts/fetch_deleteStockModal.php', //Here you will fetch records 
                    data :  'item_id=' + item_id, //Pass $id
                    success : function(data){
                    $('.fetched-data-deleteStockModal').html(data);//Show fetched data from database
                    }
                });
             });
        });

        $(document).ready(function(){
            $('#stockIn').on('show.bs.modal', function (e) {
                var item_id = $(e.relatedTarget).data('id');
                $.ajax({
                    type : 'post',
                    url : 'phpScripts/fetch_stockInModal.php', //Here you will fetch records 
                    data :  'item_id=' + item_id, //Pass $id
                    success : function(data){
                    $('.fetched-data-stockInModal').html(data);//Show fetched data from database
                    }
                });
             });
        });

        $(document).ready(function(){
            $('#stockOut').on('show.bs.modal', function (e) {
                var item_id = $(e.relatedTarget).data('id');
                $.ajax({
                    type : 'post',
                    url : 'phpScripts/fetch_stockOutModal.php', //Here you will fetch records 
                    data :  'item_id=' + item_id, //Pass $id
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
                            }, 1000);
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