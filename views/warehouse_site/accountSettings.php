<?php
    include('session.php');
    require '../../database.php';

    $sql = "SELECT
              tbl_users.user_id,
              tbl_users.username,
              tbl_user_type.userType,
              tbl_users.firstName,
              tbl_users.lastName,
              tbl_users.contactNumber,
              tbl_users.displayPicture
            FROM
              tbl_users
            INNER JOIN
              tbl_user_type ON tbl_users.userType_id = tbl_user_type.userType_id
            WHERE
              tbl_users.user_id = ".$_SESSION['user_id'].";";

    $result = mysqli_query($conn, $sql);
    // Fetch Records
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
            $user_id = $row[0];
            $username = $row[1];
            $userType = $row[2];
            $firstName = $row[3];
            $lastName = $row[4];
            $contactNumber = $row[5];
            $displayPicture = $row[6];
        }
    }    


 ?>
<!DOCTYPE html>
<html lang="en">
<?php include("includes/header.php") ?>
<style>
 #changeDPModal .modal-header {
      background-color: #337ab7;
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
		<div id="page-wrapper">
            <div class="header"> 
                <h2 class="page-header">
                    <code class="text-success">ACCOUNT SETTINGS</code>
                </h2>
                <ol class="breadcrumb">
                    <li class="active">Account Settings</li>
                </ol>
            </div>
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Your Profile
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="phpScripts/updateUserDetails.php" method="POST" enctype="multipart/form-data">
                                            <div class="col-md-7 col-sm-7">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Username:</label>
                                                    <input type="text" class="form-control" value="<?php echo $username; ?>" name="username" id="username" autocomplete="off" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="message-text" class="control-label">First Name</label>
                                                    <input type="text" class="form-control" value="<?php echo $firstName; ?>"name="firstName" id="firstName" autocomplete="off" required>
                                                </div>   
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Last Name</label>
                                                    <input type="text" class="form-control" value="<?php echo $lastName; ?>" name="lastName" id="lastName" autocomplete="off" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="message-text" class="control-label">Contact #</label>
                                                    <input type="text" class="form-control" value="<?php echo $contactNumber; ?>" name="contactNumber" id="contactNumber" autocomplete="off">
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-block btn-success">Save</button>       
                                                </div>
                                            </div>
                                        </form>
                                        <div class="col-md-5 col-sm-5">
                                            <div class="form-group">
                                                <label for="message-text" class="control-label">User Type:</label>
                                                <input type="text" class="form-control" value="<?php echo $userType; ?>" name="userType" id="userType" autocomplete="off" readonly>
                                            </div>
                                            <div class="form-group">
                                                <img class="img-thumbnail" src="../../assets/img/userProfile/<?php echo $displayPicture; ?>" alt="<?php echo $_SESSION['username']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-default btn-md btn-block" data-toggle="modal" data-target="#changeDPModal">Change Display Picture</button>
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
                                Change Password
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form role="form" action="phpScripts/changePassword.php" method="post">
                                            <div class="form-group">
                                                <label class="control-label" for="inputWarning">Current password:</label>
                                                <input type="password" class="form-control" name="oldPassword" autocomplete="off" required placeholder="●●●●●●●●●●">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="inputError">New password:</label>
                                                <input type="password" class="form-control" name="newPassword1" autocomplete="off" required placeholder="●●●●●●●●●●">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="inputSuccess">Confirm password:</label>
                                                <input type="password" class="form-control" name="newPassword2" autocomplete="off" required placeholder="●●●●●●●●●●">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-block btn-success">Save</button>       
                                            </div>
                                        </form>
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
    
    <!-- CHAGE DIAPLAY PICTURE MODAL -->
    <div class="modal fade" id="changeDPModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Change Display Picture</h4>
                </div>
                <form action="phpScripts/changeDP.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="MAX_FILE_SIZE" value="512000" />
                            <label>Image to use from: </label><input type="file" name="userPicture">
                        </div>
                        <div class="form-group">
                            <strong>OR</strong>
                        </div>
                        <div class="form-group">
                            <a href="phpScripts/useBlankImage.php" class="btn btn-default"><span class="glyphicon glyphicon-user"></span> Use Blank Image</span></a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button name="restore" type="submit" class="btn btn-primary">Change Picture</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include("includes/scripts.php") ?>
</body>
</html>