<?php
    include('session.php');
    require '../../database.php'; 

    if($_GET['stock_id']) {
        $stock_id = $_GET['stock_id'];
    } 

    if($_GET['partNumber']) {
        $partNumber = $_GET['partNumber'];
    }    

    if($_GET['description']) {
        $description = $_GET['description'];
    }      

    if($_GET['quantity']) {
        $quantity = $_GET['quantity'];
    }      
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
                    <code class="text-success">Part Number: <?php echo $partNumber; ?></code>
                </h2>
                <ol class="breadcrumb">
                    <li class="active">Reports</li>
                    <li class="active">Generate</li>
                </ol>
            </div>
            <div id="page-inner">
                <div class="row">
                    <!-- SPECIFIC ITEM REPORTS -->
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Complete Report
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                    <a href="itemReport.php?stock_id=<?php echo $stock_id; ?>&amp;partNumber=<?php echo $partNumber; ?>&amp;description=<?php echo $description; ?>&amp;quantity=<?php echo $quantity; ?>" target="_blank" class="btn btn-success btn-block btn-md"><b>Print Complete Record</b>&nbsp;&nbsp;<span class="glyphicon glyphicon glyphicon-print"></span></a>
                                </div>                                
                            </div>
                        </div>
                    </div>                   
                    <!-- SPECIFIC ITEM REPORTS -->
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Custom Report
                            </div>
                            <div class="panel-body">
                                <div class="text-center">
                                    <form role="form" class="form-horizontal" target="_blank" action="itemCustomReport.php" method="post">
                                        <div class="input-group col-md-12">
                                            <span class="input-group-addon" id="basic-addon1"><label class="text-danger"></label> <b>From:</b></span>
                                            <div class="input-group date form_date col-md-12">
                                                <input id="date" name="dateFrom" class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" placeholder="mm/dd/yyyy" autocomplete="off" required>
                                            </div>
                                        </div><br>
                                        <div class="input-group col-md-12">
                                            <span class="input-group-addon" id="basic-addon1"><label class="text-danger"></label> <b>To:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span>
                                            <div class="input-group date form_date col-md-12">
                                                <input id="date" name="dateTo" class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" placeholder="mm/dd/yyyy" autocomplete="off" required>
                                            </div>
                                        </div><br>
                                        <input type="hidden" name="stock_id" value="<?php echo $stock_id; ?>">
                                        <input type="hidden" name="partNumber" value="<?php echo $partNumber; ?>">
                                        <input type="hidden" name="description" value="<?php echo $description; ?>">
                                        <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
                                        <button type="submit" class="btn btn-block btn-md btn-success"></span> <b>Print</b>&nbsp;&nbsp;<span class="glyphicon glyphicon glyphicon-print"></span></button>
                                    </form>
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

    <?php include("includes/scripts.php") ?>
    <script>
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
            
            $(document).ready(function () {
                $('#specificItemReport').dataTable({
                'iDisplayLength': 15, 
                'lengthMenu': [ [15, 25, 50, 100, -1], [15, 25, 50, 100, 'All'] ],
                'bSort': false
                 });
            });

            $(document).ready(function() {
                var table = $('#specificItemReport').DataTable();
             
                $("#specificItemReport tfoot th").each( function ( i ) {
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

            // $('.form_date').datetimepicker({
            //     // language:  'fr',
            //     format:'yyyy-mm-dd',
            //     weekStart: 1,
            //     todayBtn:  1,
            //     autoclose: 1,
            //     todayHighlight: 1,
            //     startView: 2,
            //     minView: 2,
            //     forceParse: 0
            // });


            function printTable() { 
                popupWindow = window.open('table-print/reportSummary.php',"_blank","directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=950, height=600,top=200,left=200");
            }                
    </script>
</body>
</html>