<?php
	session_start();
	require '../../../database.php';

	$file = $_FILES['file']['tmp_name'];
	$filename = $_FILES['file']['name'];

	if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
	    echo "<script>alert('FILE NOT UPLOADED SUCCESSFULLY. PLEASE MAKE SURE YOU CHOOSE THE CORRECT FILE (.SQL)'); window.location.href = '../maintenance.php'</script>";
	    // die("Upload failed with error " . $_FILES['file']['error']);
	} else {
		echo "<script>alert('FILE UPLOADED SUCCESSFULLY.');</script>";
	}

	// Connect to MySQL server
	$conn = mysql_connect($server_name, $username, $password);
	$sql = "CREATE DATABASE IF NOT EXISTS ".$database_name."";
	mysql_query($sql, $conn);
	$sql = "USE ".$database_name."";
	mysql_query($sql, $conn);

	// Select database
	mysql_select_db($database_name) or die('Error selecting MySQL database: ' . mysql_error());

	// Temporary variable, used to store current query
	$templine = '';
	// Read in entire file
	$lines = file($file);
	// Loop through each line
	foreach ($lines as $line)
	{
	// Skip it if it's a comment
	if (substr($line, 0, 2) == '--' || $line == '')
	    continue;

	// Add this line to the current segment
	$templine .= $line;
	// If it has a semicolon at the end, it's the end of the query
	if (substr(trim($line), -1, 1) == ';')
	{
	    // Perform the query
	    mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
	    // Reset temp variable to empty
	    $templine = '';
	}
	}
	echo "<script>alert('DATABASE SUCCESSFULLY RESTORED'); window.location.href = '../maintenance.php'</script>";

	$sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
	                            ".$_SESSION['user_id'].",
	                            now(),
	                            5,
	                            'User has restored database: ".$file."'
	                            );";    
	mysqli_query($conn, $sql);
	mysqli_close($conn);
?>
