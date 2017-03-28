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
        <div id="page-wrapper">
            <div class="header"> 
                <h2 class="page-header">
                    <span class="text-success">MAINTENANCE</span>
                </h2>
                <ol class="breadcrumb">
                    <li class="active">Maintenance</li>
                </ol>
            </div>
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Change Password
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" action="phpScripts/changePassword.php" method="post">
                                            <div class="form-group">
                                                <label class="control-label" for="inputWarning">Current password:</label>
                                                <input type="text" class="form-control" name="oldPassword" placeholder="●●●●●●●●●●" autocomplete="off" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="inputError">New password:</label>
                                                <input type="text" class="form-control" name="newPassword1" placeholder="●●●●●●●●●●" autocomplete="off" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="inputSuccess">Confirm password:</label>
                                                <input type="text" class="form-control" name="newPassword2" placeholder="●●●●●●●●●●" autocomplete="off" required>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-block btn-primary">Save</button>       
                                            </div>
                                        </form>
                                    </div>
                                </div>                                
                                <br>
                            </div>
                        </div>
                    </div>                    
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Database Options
                            </div>
                            <div class="panel-body">
                                <button class="btn btn-primary btn-md btn-block" data-toggle="modal" data-target="#backupModal">Backup Database</button>
                                <div class="modal fade" id="backupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel">Backup Database</h4>
                                            </div>
                                            <div class="modal-body">
                                                <h5><button href="#" class="btn btn-xs btn-primary" disabled>Backup to server <span class="glyphicon glyphicon-hdd"></span></button> will backup database to <code><font color="green">C:\NichiyuAsialiftBackups\</font></code> of local server.</h5>
                                                <h5><button href="#" class="btn btn-xs btn-success" disabled>Download Backup <span class="glyphicon glyphicon-download-alt"></span></button> will download the database.</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                                                <a href="phpScripts/dbBackup.php" class="btn btn-primary">Backup to server <span class="glyphicon glyphicon-hdd"></span></a>
                                                <a href="phpScripts/dbBackupDownload.php" class="btn btn-success">Download Backup <span class="glyphicon glyphicon-download-alt"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-primary btn-md btn-block" data-toggle="modal" data-target="#restoreModal">Restore Database</button>
                                <div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel">Restore Database</h4>
                                            </div>
                                            <form action="phpScripts/dbRestore.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                            <label>File to Restore from: </label><input type="file" name="file">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button name="restore" type="submit" class="btn btn-primary">Restore</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-danger btn-md btn-block" data-toggle="modal" data-target="#clearModal">Clear Database</button>
                                <div class="modal fade" id="clearModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel">Clear Database</h4>
                                            </div>
                                            <form action="phpScripts/dbClear.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body text-center">
                                                    <h4 class="text-danger">Are you sure you want to permanently clear <br><strong>ALL DATABASE RECORDS?</strong></h4>
                                                    <strong>Warning</strong>: This action is <strong>irreversable</strong><br><br>    
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <span for="password" class="input-group-addon" id="basic-addon1">Password:</span>
                                                            <input type="password" name="password" id="password" class="form-control" value="" aria-describedby="basic-addon1" autofocus required autocomplete="off">
                                                        </div>                                                                                                                                               
                                                     </div>
                                                     <br><br>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button name="truncate" type="submit" class="btn btn-danger">Clear All Records</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php include("includes/footer.php") ?>
            </div>
        </div>
    </div>
    <?php include("includes/scripts.php") ?>
    <script>
            $(document).ready(function () {
                $('#recordHistory').dataTable({
                'iDisplayLength': 15, 
                'lengthMenu': [ [15, 25, 50, 100, -1], [15, 25, 50, 100, 'All'] ],
                'order': [ 0, 'desc' ],
                 });
            });

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