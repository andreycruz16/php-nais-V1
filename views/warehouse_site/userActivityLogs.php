<?php
    include('session.php');
    require '../../database.php';   
 ?>
<!DOCTYPE html>
<html lang="en">
<?php include("includes/header.php") ?>
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
                    <code class="text-success">USER ACTIVITY LOGS</code>
                </h2>
                <ol class="breadcrumb">
                    <li class="active">User Activity Logs</li>
                </ol>
            </div>
            <div id="page-inner">
                <div class="row">
                    <!-- ACTIVITY LOGS RECORD -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                My Activity Logs (<?php echo $_SESSION['username']; ?>)
                            </div>
                            <div class="panel-body">
                                <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-condensed table-hover" id="recordHistory">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" bgcolor="#e5e5e5" width="155">TIMESTAMP</th>
                                                    <th class="text-center" bgcolor="#f2ba7f" width="100">Activity&nbsp;Type</th>
                                                    <th class="text-center" bgcolor="#f2ba7f">Details</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center" bgcolor="#e5e5e5" width="155">TIMESTAMP</th>
                                                    <th class="text-center" bgcolor="#f2ba7f" width="100">Activity&nbsp;Type</th>
                                                    <td class="text-center" bgcolor="#f2ba7f"></td>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            <?php 
                                                require '../../database.php';
                                                $sql = "SELECT
                                                          tbl_activity_logs.timestamp,
                                                          tbl_activity_type.activityType,
                                                          tbl_activity_logs.activityDetails
                                                        FROM
                                                          tbl_activity_logs
                                                        INNER JOIN
                                                          tbl_activity_type ON tbl_activity_logs.acitivityType_id = tbl_activity_type.activityType_id
                                                        WHERE
                                                          tbl_activity_logs.user_id = '".$_SESSION['user_id']."'
                                                        ORDER BY
                                                          activityLog_id DESC;";
                                                // echo $sql;
                                                $result = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($result) > 0) {
                                                    while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
                                                        $timestamp = $row[0];
                                                        $activityTypeName = $row[1];
                                                        $activityDetails = $row[2];
                                            ?>
                                                <tr>
                                                    <td class="text-center" title="<?php  echo date('h:i:s A', strtotime($timestamp)); ?>"><?php  echo date('m/d/Y', strtotime($timestamp)); ?></td>
                                                    <td class="text-center"><?php echo $activityTypeName; ?></td>
                                                    <td><?php echo $activityDetails; ?></td>
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
    <?php include("includes/scripts.php") ?>
    <script>
            $(document).ready(function () {
                $('#recordHistory').dataTable({
                'iDisplayLength': 20, 
                'lengthMenu': [ [20, 50, 100, 350, -1], [20, 50, 100, 350, 'All'] ],
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
    </script>
</body>
</html>