<?php
    include('session.php');
    require '../../database.php';
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

        <!-- WRAPPER START  -->
        <!-- WRAPPER START  -->
        <!-- WRAPPER START  -->

		<div id="page-wrapper">
            <div class="header"> 
                <h2 class="page-header">
                    <span class="text-success">USER ACTIVITY LOGS</span>
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
                                Recent Activity Logs
                            </div>
                            <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-condensed table-hover" id="activityLogsTable">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" bgcolor="#e5e5e5" width="155">TIMESTAMP</th> <!-- 2 -->
                                                    <th class="text-center" bgcolor="#f2ba7f" width="80">User</th> <!-- 1 -->
                                                    <th class="text-center" bgcolor="#f2ba7f" width="100">Activity&nbsp;Type</th> <!-- 3 -->
                                                    <th class="text-center" bgcolor="#f2ba7f">Details</th> <!-- 4 -->
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th bgcolor="#e5e5e5" width="155">TIMESTAMP</th> <!-- 2 -->
                                                    <th bgcolor="#f2ba7f" width="80">User</th> <!-- 1 -->
                                                    <th bgcolor="#f2ba7f" width="100">Activity&nbsp;Type</th> <!-- 3 -->
                                                    <td bgcolor="#f2ba7f"></td> <!-- 4 -->
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            <?php 
                                                require '../../database.php';
                                                $sql = "SELECT tbl_activity_logs.timestamp, 
                                                               tbl_users.username, 
                                                               tbl_activity_type.activityType, 
                                                               tbl_activity_logs.activityDetails 
                                                        FROM tbl_activity_logs 
                                                        INNER JOIN tbl_users
                                                        ON tbl_activity_logs.user_id = tbl_users.user_id
                                                        INNER JOIN tbl_activity_type
                                                        ON tbl_activity_logs.acitivityType_id = tbl_activity_type.activityType_id
                                                        ORDER BY activityLog_id 
                                                        DESC;";
                                                // echo $sql;
                                                $result = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($result) > 0) {
                                                    while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
                                                        $timestamp = $row[0];
                                                        $username = $row[1];
                                                        $activityType = $row[2];
                                                        $activityDetails = $row[3];
                                            ?>
                                                <tr>
                                                    <td class="text-center" title="<?php  echo date('h:i:s A', strtotime($timestamp)); ?>"><?php  echo date('m/d/Y', strtotime($timestamp)); ?></td>
                                                    <td class="text-center"><?php echo $username; ?></td>
                                                    <td class="text-center"><?php echo $activityType; ?></td>
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
                $('#activityLogsTable').dataTable({
                'iDisplayLength': 20, 
                'lengthMenu': [ [20, 50, 100, 350, -1], [20, 50, 100, 350, 'All'] ],
                'bSort': false
                 });
            });

            $(document).ready(function() {
                var table = $('#activityLogsTable').DataTable();
             
                $("#activityLogsTable tfoot th").each( function ( i ) {
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