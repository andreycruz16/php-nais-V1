<?php
//Include database connection
require '../../../database.php';
if($_POST['stock_id']) {
    $stock_id = $_POST['stock_id']; //escape string
    // Run the Query
    $sql = "SELECT stock_id, description, partNumber FROM tbl_service WHERE stock_id = ".$stock_id.";";
    $result = mysqli_query($conn, $sql);
    // Fetch Records
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
            $stock_id = $row[0];
			$description = $row[1];
            $partNumber = $row[2];

		}
	}
    // Echo the data you want to show in modal
 } else {
    header("Location: ../index.php"); // Redirecting to All Records Page
 }
?>

 <form role="form" class="form-horizontal" action="phpScripts/deleteItem.php" method="post">
    <input type="hidden" name="stock_id" value="<?php echo $stock_id;?>"/>
    <h4 class="text-danger">Are you sure you want to permanently delete <br>"<strong><?php echo $description; ?></strong>" (<?php echo $partNumber; ?>)&nbsp;?</h4>
    <strong>Warning</strong>: This action is <strong>irreversable</strong><br><br>
    <input type="hidden" name="description" id="description" value="<?php echo $description; ?>"> 
    <input type="hidden" name="partNumber" id="partNumber" value="<?php echo $partNumber; ?>"> 
    <button type="submit" class="btn btn-danger col-sm-8 col-sm-offset-2" ><span class="glyphicon glyphicon-exclamation-sign"></span> Delete</button>
</form>