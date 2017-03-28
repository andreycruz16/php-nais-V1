<?php    
	session_start();
	require '../../../database.php';

	define("BACKUP_PATH", "C:/NichiyuAsialiftBackups/");

	date_default_timezone_set('Asia/Manila');
	$date_string = date('m-d-Y_hisA', time());

	if (!is_dir('C:/NichiyuAsialiftBackups/')) {
    		mkdir('C:/NichiyuAsialiftBackups/', 0777, true);
	}

	$cmd = "C:/xampp/mysql/bin/mysqldump --routines -h {$server_name} -u {$username} {$database_name} > " . BACKUP_PATH . "{$date_string}_{$database_name}.sql";

	exec($cmd);
	
	echo "<script>alert('DATABASE BACKUP FINISHED'); window.location.href = '../maintenance.php'</script>";



	$sql = "INSERT INTO tbl_activity_logs VALUES(NULL,
	                                      ".$_SESSION['user_id'].",
	                                      now(),
	                                      5,
	                                      'User has backup database. Filename: \"".$date_string."_".$database_name.".".'sql'."\"'
	                                      );";    
	mysqli_query($conn, $sql);
?>