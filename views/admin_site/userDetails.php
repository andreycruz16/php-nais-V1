<?php
    include('session.php');
    require '../../database.php';

    $sql = "SELECT
              tbl_users.username,
              tbl_user_type.userType,
              tbl_users.firstName,
              tbl_users.lastName,
              tbl_users.contactNumber,
              tbl_users.userType_id,
              tbl_users.displayPicture
            FROM
              tbl_users
            INNER JOIN
              tbl_user_type ON tbl_users.userType_id = tbl_user_type.userType_id
            WHERE
              tbl_users.user_id = ".$_GET['user_id'].";";

    $result = mysqli_query($conn, $sql);
    // Fetch Records
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
            $username = $row[0];
            $userType = $row[1];
            $firstName = $row[2];
            $lastName = $row[3];
            $contactNumber = $row[4];
            $userType_id = $row[5];
            $displayPicture = $row[6];
        }
    }     
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include("includes/header.php") ?>
    <style>
/*     #addNewUser .modal-header {
          background-color: #5cb85c;
          color: #fff;
          font-weight: bold;
          text-align: center;
     }

     #userDelete .modal-header {
          background-color: #d9534f;
          color: #fff;
          font-weight: bold;
          text-align: center;
     } */    
    </style>     
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
                    <span class="text-success"><?php echo $_SESSION['username']; ?></span>
                </h2>
                <ol class="breadcrumb">
                    <li><a href="userManagement.php">User Management</a></li>
                    <li class="active">User Details</li>
                </ol>
            </div>
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Complete Details
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                      <div class="col-md-8 col-sm-8">
                                          <div class="form-group">
                                              <label for="recipient-name" class="control-label">Username:</label>
                                              <input type="text" class="form-control" value="<?php echo $username; ?>" name="username" id="username" autocomplete="off" readonly>
                                          </div>
                                          <div class="form-group">
                                              <label for="message-text" class="control-label">First Name</label>
                                              <input type="text" class="form-control" value="<?php echo $firstName; ?>"name="firstName" id="firstName" autocomplete="off" readonly>
                                          </div>   
                                          <div class="form-group">
                                              <label for="recipient-name" class="control-label">Last Name</label>
                                              <input type="text" class="form-control" value="<?php echo $lastName; ?>" name="lastName" id="lastName" autocomplete="off" readonly>
                                          </div>
                                          <div class="form-group">
                                              <label for="message-text" class="control-label">Contact #</label>
                                              <input type="text" class="form-control" value="<?php echo $contactNumber; ?>" name="contactNumber" id="contactNumber" readonly>
                                          </div>                                        
                                      </div>
                                      <div class="col-md-4 col-sm-4">
                                          <div class="form-group">
                                              <label for="message-text" class="control-label">User Type:</label> <?php echo $userType; ?>
                                          </div>
                                          <div class="form-group">
                                              <img class="img-thumbnail" src="../../assets/img/userProfile/<?php echo $displayPicture; ?>" alt="<?php echo $username; ?>" title="<?php echo $username; ?>">
                                          </div>
                                      </div>
                                    </div>                                
                                </div>                                                                                                       
                            </div>
                        </div>
                    </div>                 
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Change User Type
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" action="phpScripts/changeUserActivityType.php" method="post">
                                          <div class="form-group">
                                              <label for="userType"><label class="text-danger"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></label> User Type</label>
                                              <select class="form-control" name="userType_id" id="userType_id">
                                                  <!-- <option <?php if($userType_id == 1) echo "selected"; ?> value="1" disabled>Admnistrator</option> -->
                                                  <option <?php if($userType_id == 2) echo "selected"; ?> value="2">Warehouse User</option>
                                                  <option <?php if($userType_id == 6) echo "selected"; ?> value="6">Warehouse Viewer</option>
                                                  <option <?php if($userType_id == 3) echo "selected"; ?> value="3">Service User</option>
                                                  <option <?php if($userType_id == 5) echo "selected"; ?> value="5">Service Viewer</option>
                                                  <option <?php if($userType_id == 4) echo "selected"; ?> value="4">Manager</option>
                                              </select>
                                          </div>
                                          <input type="hidden" name="user_id" id="user_id" value="<?php echo $_GET['user_id']; ?>">
                                          <input type="hidden" name="username" id="username" value="<?php echo $username; ?>"> 
                                          <div class="form-group">
                                              <button type="submit" class="btn btn-block btn-success">Save</button>       
                                          </div>
                                        </form>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Remove User
                            </div>
                            <div class="panel-body">
                                <button class="btn btn-danger btn-md btn-block" data-toggle="modal" data-target="#removeUserModal">Remove</button>
                                <div class="modal fade" id="removeUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel">Remove User</h4>
                                            </div>
                                            <form action="phpScripts/deleteUser.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body text-center">
                                                    <h4 class="text-danger">Are you sure you want to permanently remove <br><strong><?php echo $username; ?>?</strong></h4>
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
                                                    <button name="truncate" type="submit" class="btn btn-danger">Remove</button>
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
            $('#usersTable').dataTable({
            'iDisplayLength': 15, 
            'lengthMenu': [ [15, 25, 50, 100, -1], [15, 25, 50, 100, 'All'] ],
            'bSort': false
             });
        });

        $(document).ready(function() {
            var usersTable = $('#usersTable').DataTable();
         
            $("#usersTable tfoot th").each( function ( i ) {
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(this).empty() )
                    .on( 'change', function () {
                        usersTable.column( i )
                            .search( $(this).val() )
                            .draw();
                    } );
         
                usersTable.column( i ).data().unique().sort().each( function ( d, j ) {
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