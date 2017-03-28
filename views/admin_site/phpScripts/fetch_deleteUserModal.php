<?php
//Include database connection
require '../../../database.php';
if($_POST['user_id']) {
    $user_id = $_POST['user_id']; //escape string
    // Run the Query
    $sql = "SELECT user_id, username, userType_id FROM tbl_users WHERE user_id = ".$user_id.";";
    $result = mysqli_query($conn, $sql);
    // Fetch Records
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
            $user_id = $row[0];
			$username = $row[1];
            $userType_id = $row[2];

		}
	}

     $sql = "SELECT
          tbl_user_type.userType
        FROM
          tbl_user_type
        WHERE
          userType_id = ".$userType_id.";"; 

     $result = mysqli_query($conn, $sql);
     if (mysqli_num_rows($result) > 0) {
         while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
             $userType = $row[0];
         }
     }    
    // Echo the data you want to show in modal
 } else {
    header("Location: ../index.php"); // Redirecting to All Records Page
 }
?>

 <form role="form" class="form-horizontal" action="phpScripts/deleteUser.php" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-1"></div>                     
            <div class="col-sm-10">       
                <h4 class="text-danger">Are you sure you want to permanently delete <br>"<strong><?php echo $username; ?></strong>" (<?php echo $userType; ?>)&nbsp;?</h4>
                <strong>Warning</strong>: This action is <strong>irreversable</strong><br><br>
                <div class="col-md-12">
                    <div class="input-group">
                        <span for="password" class="input-group-addon" id="basic-addon1">Password:</span>
                        <input type="password" name="password" id="password" class="form-control" value="" aria-describedby="basic-addon1" autofocus required autocomplete="off">
                    </div>                                                                                                                                               
                </div>
            </div>
            <div class="col-sm-1"></div>                     
        </div>
    </div>
    <div class="modal-footer">
        <input type="hidden" name="user_id" value="<?php echo $user_id;?>"/>
        <input type="hidden" name="username" id="username" value="<?php echo $username; ?>"> 
        <input type="hidden" name="userType" id="userType" value="<?php echo $userType; ?>"> 
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cancel</button>
        <button type="submit" class="btn btn-danger" ><span class="glyphicon glyphicon-exclamation-sign"></span> Delete</button>                  
    </div>
</form>