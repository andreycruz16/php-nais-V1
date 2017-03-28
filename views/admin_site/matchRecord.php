<?php
    include('session.php');
    require '../../database.php';

    if(isset($_GET)) {

        $partNumber = $_GET['partNumber'];
        $partNumber = mysqli_real_escape_string($conn, $partNumber);
        $partNumber = trim($partNumber);
    }

    $sql = "SELECT tbl_service.stock_id, 
                    tbl_service.description
            FROM tbl_service 
            WHERE partNumber = '".$partNumber."';";

    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result, MYSQL_NUM);
        $stock_id = $row[0];
        $description = $row[1];
    } else {
        echo "<script>alert('PART NUMBER DOES NOT EXISTS. '); window.location.href = 'index.php'</script>";
    }
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
                    <code class="text-success">MATCH RECORD (<?php echo $partNumber; ?>)</code>
                </h2>
                <ol class="breadcrumb">
                    <li><a href="index.php">All Records </a></li>
                    <li class="active">Match Record </li>
                </ol>
            </div>
            <div id="page-inner">
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Service Record History - <i><?php echo $description; ?></i>
                        </div>
                        <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-condensed table-hover" id="recordHistory">
                                        <thead>
                                            <tr>
                                                <th class="text-center" bgcolor="#e5e5e5" width="255">TIMESTAMP</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Date&nbsp;(M/D/Y)</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;Type</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;#</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Receiving&nbsp;Report</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Cost</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Transfer&nbsp;Type</th>
                                                <th class="text-center" bgcolor="#f2ba7f" width="30">+&nbsp;/&nbsp;−</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center" bgcolor="#e5e5e5" width="255">TIMESTAMP</th> 
                                                <th class="text-center" bgcolor="#f2ba7f">Date&nbsp;(M/D/Y)</th> 
                                                <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;Type</th> 
                                                <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;#</th> 
                                                <th class="text-center" bgcolor="#f2ba7f">Receiving&nbsp;Report</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Cost</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Transfer&nbsp;Type</th> 
                                                <th class="text-center" bgcolor="#f2ba7f" width="30">+&nbsp;/&nbsp;−</th> 
                                                <th class="text-center" bgcolor="#f2ba7f">Quantity</th> 
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php 
                                            require '../../database.php';
                                            $sql = "SELECT 
                                                    tbl_service_history.timestamp, 
                                                    tbl_service_history.date,
                                                    tbl_reference.referenceType,
                                                    tbl_service_history.referenceNumber,
                                                    tbl_service_history.quantity,
                                                    tbl_service_history.quantityChange,
                                                    tbl_transfer_type.transferType,
                                                    tbl_users.username,
                                                    tbl_service_history.history_id,
                                                    tbl_service_history.cost,
                                                    tbl_service_history.receivingReport
                                                    FROM tbl_service_history 
                                                    INNER JOIN tbl_reference
                                                    ON tbl_service_history.reference_id = tbl_reference.reference_id
                                                    INNER JOIN tbl_transfer_type
                                                    ON tbl_transfer_type.transferType_id = tbl_service_history.transferType_id
                                                    INNER JOIN tbl_users
                                                    ON tbl_service_history.user_id = tbl_users.user_id
                                                    WHERE tbl_service_history.stock_id = ".$stock_id."
                                                    ORDER BY tbl_service_history.history_id DESC;";
                                            // echo $sql;
                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
                                                $timestamp = $row[0];
                                                $date = $row[1];
                                                $referenceType = $row[2];
                                                $referenceNumber = $row[3];
                                                $quantity = $row[4];
                                                $quantityChange = $row[5];
                                                $transferType = $row[6];
                                                $username = $row[7]; 
                                                $history_id = $row[8];                                                       
                                                $cost = $row[9];
                                                $receivingReport = $row[10];
                                        ?>
                                            <tr>
                                                <td class="text-center" title="Date & Time Updated"><?php  echo date('m/d/Y | h:i:s A', strtotime($timestamp)); ?></td>
                                                <td class="text-center"><?php echo date('m/d/Y', strtotime($date)); ?></td>
                                                <td><?php echo $referenceType; ?></td>
                                                <td><?php echo $referenceNumber; ?></td>
                                                <td><?php echo $receivingReport; ?></td>
                                                <td><?php if($transferType == 'IN') echo "₱ ".$cost; else echo "N/A"?></td>
                                                <td class="text-center"><?php echo $transferType ?></td>
                                                <td class="text-center"><?php echo $quantityChange; ?></td>
                                                <td class="text-center"><?php echo $quantity; ?></td>
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
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Warehouse Record History - <i><?php echo $description; ?></i>
                        </div>
                        <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-condensed table-hover" id="recordHistory">
                                        <thead>
                                            <tr>
                                                <th class="text-center" bgcolor="#e5e5e5" width="255">TIMESTAMP</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Date&nbsp;(M/D/Y)</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;Type</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;#</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Receiving&nbsp;Report</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Transfer&nbsp;Type</th>
                                                <th class="text-center" bgcolor="#f2ba7f"width="30">+&nbsp;/&nbsp;−</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center" bgcolor="#e5e5e5" width="255">TIMESTAMP</th> 
                                                <th class="text-center" bgcolor="#f2ba7f">Date&nbsp;(M/D/Y)</th> 
                                                <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;Type</th> 
                                                <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;#</th> 
                                                <th class="text-center" bgcolor="#f2ba7f">Receiving&nbsp;Report</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Transfer&nbsp;Type</th>
                                                <th class="text-center" bgcolor="#f2ba7f"width="30">+&nbsp;/&nbsp;−</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Quantity</th> 
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php 
                                            require '../../database.php';
                                            $sql = "SELECT 
                                                    tbl_warehouse_history.timestamp, 
                                                    tbl_warehouse_history.date,
                                                    tbl_reference.referenceType,
                                                    tbl_warehouse_history.referenceNumber,
                                                    tbl_warehouse_history.quantity,
                                                    tbl_warehouse_history.quantityChange,
                                                    tbl_transfer_type.transferType,
                                                    tbl_users.username,
                                                    tbl_warehouse_history.history_id,
                                                    tbl_warehouse_history.receivingReport
                                                    FROM tbl_warehouse_history 
                                                    INNER JOIN tbl_reference
                                                    ON tbl_warehouse_history.reference_id = tbl_reference.reference_id
                                                    INNER JOIN tbl_transfer_type
                                                    ON tbl_transfer_type.transferType_id = tbl_warehouse_history.transferType_id
                                                    INNER JOIN tbl_users
                                                    ON tbl_warehouse_history.user_id = tbl_users.user_id
                                                    WHERE tbl_warehouse_history.stock_id = ".$stock_id."
                                                    ORDER BY tbl_warehouse_history.history_id DESC;";
                                            // echo $sql;
                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
                                                $timestamp = $row[0];
                                                $date = $row[1];
                                                $referenceType = $row[2];
                                                $referenceNumber = $row[3];
                                                $quantity = $row[4];
                                                $quantityChange = $row[5];
                                                $transferType = $row[6];
                                                $username = $row[7];
                                                $history_id = $row[8];
                                                $receivingReport = $row[9];
                                        ?>
                                            <tr>
                                                <td class="text-center" title="Date & Time Updated"><?php  echo date('m/d/Y | h:i:s A', strtotime($timestamp)); ?></td>
                                                <td class="text-center"><?php echo date('m/d/Y', strtotime($date)); ?></td>
                                                <td><?php echo $referenceType; ?></td>
                                                <td><?php echo $referenceNumber; ?></td>
                                                <td><?php echo $receivingReport; ?></td>
                                                <td class="text-center"><?php echo $transferType ?></td>
                                                <td class="text-center"><?php echo $quantityChange; ?></td>
                                                <td class="text-center"><?php echo $quantity; ?></td>
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
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Combined - <i><?php echo $description; ?></i>
                        </div>
                        <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-condensed table-hover" id="recordHistory">
                                        <thead>
                                            <tr>
                                                <th class="text-center" bgcolor="#f2ba7f"></th>
                                                <th class="text-center" bgcolor="#e5e5e5" width="255">History&nbsp;ID</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Stock&nbsp;ID</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;#</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Transfer&nbsp;Type</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Quantity</th>
                                                <th class="text-center" bgcolor="#f2ba7f">User&nbsp;ID</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center" bgcolor="#f2ba7f"></th>
                                                <th class="text-center" bgcolor="#e5e5e5" width="255">History&nbsp;ID</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Stock&nbsp;ID</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;#</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Transfer&nbsp;Type</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Quantity</th>
                                                <th class="text-center" bgcolor="#f2ba7f">User&nbsp;ID</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php 
                                            require '../../database.php';
                                            $sql = "SELECT 
                                                    tbl_warehouse_history.history_id,
                                                    tbl_warehouse_history.stock_id,
                                                    tbl_warehouse_history.referenceNumber, 
                                                    tbl_warehouse_history.transferType_id, 
                                                    tbl_warehouse_history.quantity, 
                                                    tbl_warehouse_history.user_id
                                                    FROM tbl_warehouse_history
                                                    UNION
                                                    SELECT
                                                    tbl_service_history.history_id,
                                                    tbl_service_history.stock_id,
                                                    tbl_service_history.referenceNumber, 
                                                    tbl_service_history.transferType_id, 
                                                    tbl_service_history.quantity, 
                                                    tbl_service_history.user_id 
                                                    FROM tbl_service_history  
                                                    ORDER BY history_id desc";
                                            // echo $sql;
                                            $result = mysqli_query($conn, $sql);
                                            $cnt = 0;

                                            $history_id_temp;
                                            $stock_id_temp;
                                            $referenceNumber_temp;
                                            $transferType_id_temp;
                                            $quantity_temp;
                                            $user_id_temp;

                                            $isMatch = "";


                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
                                                $history_id = $row[0];
                                                $stock_id = $row[1];
                                                $referenceNumber = $row[2];
                                                $transferType_id = $row[3];
                                                $quantity = $row[4];
                                                $user_id = $row[5];

                                                if($cnt == 1){
                                                    $history_id_temp = $history_id;
                                                    $stock_id_temp = $stock_id;
                                                    $referenceNumber_temp = $referenceNumber;
                                                    $transferType_id_temp = $transferType_id;
                                                    $quantity_temp = $quantity;
                                                    $user_id_temp = $user_id;

                                                }

                                                if($cnt == 2) {
                                                    $cnt = 0;

                                                    if($referenceNumber_temp == $referenceNumber) {
                                                        $isMatch = "True";
                                                    } else {
                                                        $isMatch = "False";
                                                    }


                                        ?>  
                                            <!-- <tr>
                                                <td class="text-center">&nbsp;</td>
                                                <td class="text-center">&nbsp;</td>
                                                <td class="text-center">&nbsp;</td>
                                                <td class="text-center">&nbsp;</td>
                                                <td class="text-center">&nbsp;</td>
                                                <td class="text-center">&nbsp;</td>
                                                <td class="text-center">&nbsp;</td>
                                            </tr> -->
                                            <tr>
                                                <td class="text-center"><?php echo $isMatch; ?></td>
                                                <td class="text-center"><?php echo $referenceNumber_temp . " " . $referenceNumber; ?></td>
                                                <td class="text-center">&nbsp;</td>
                                                <td class="text-center">&nbsp;</td>
                                                <td class="text-center">&nbsp;</td>
                                                <td class="text-center">&nbsp;</td>
                                                <td class="text-center">&nbsp;</td>
                                            </tr>
                                        <?php 
                                                }
                                                $cnt++;
                                        ?>
                                            <tr>
                                                <td class="text-center"><?php echo ""; ?></td>
                                                <td class="text-center"><?php  echo $history_id; ?></td>
                                                <td class="text-center"><?php echo $stock_id; ?></td>
                                                <td class="text-center"><?php echo $referenceNumber; ?></td>
                                                <td class="text-center"><?php echo $transferType_id ?></td>
                                                <td class="text-center"><?php echo $quantity; ?></td>
                                                <td class="text-center"><?php echo $user_id; ?></td>
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
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Combined - <i><?php echo $description; ?></i>
                        </div>
                        <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-condensed table-hover" id="recordHistory">
                                        <thead>
                                            <tr>
                                                <th class="text-center" bgcolor="#f2ba7f"></th>
                                                <th class="text-center" bgcolor="#e5e5e5" width="255">History&nbsp;ID</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Stock&nbsp;ID</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;#</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Transfer&nbsp;Type</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Quantity</th>
                                                <th class="text-center" bgcolor="#f2ba7f">User&nbsp;ID</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center" bgcolor="#f2ba7f"></th>
                                                <th class="text-center" bgcolor="#e5e5e5" width="255">History&nbsp;ID</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Stock&nbsp;ID</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Reference&nbsp;#</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Transfer&nbsp;Type</th>
                                                <th class="text-center" bgcolor="#f2ba7f">Quantity</th>
                                                <th class="text-center" bgcolor="#f2ba7f">User&nbsp;ID</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php 
                                            require '../../database.php';
                                            $sql = "SELECT 
                                                    tbl_warehouse_history.history_id,
                                                    tbl_warehouse_history.stock_id,
                                                    tbl_warehouse_history.referenceNumber, 
                                                    tbl_warehouse_history.transferType_id, 
                                                    tbl_warehouse_history.quantity, 
                                                    tbl_warehouse_history.user_id,
                                                    
                                                    tbl_service_history.history_id,
                                                    tbl_service_history.stock_id,
                                                    tbl_service_history.referenceNumber, 
                                                    tbl_service_history.transferType_id, 
                                                    tbl_service_history.quantity, 
                                                    tbl_service_history.user_id 
                                                    FROM tbl_warehouse_history, tbl_service_history  
                                                    ORDER BY history_id desc";
                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
                                                $history_id = $row[0];
                                                $stock_id = $row[1];
                                                $referenceNumber = $row[2];
                                                $transferType_id = $row[3];
                                                $quantity = $row[4];
                                                $user_id = $row[5];
                                        ?>  
                                            <tr>
                                                <td class="text-center"><?php echo ""; ?></td>
                                                <td class="text-center"><?php  echo $history_id; ?></td>
                                                <td class="text-center"><?php echo $stock_id; ?></td>
                                                <td class="text-center"><?php echo $referenceNumber; ?></td>
                                                <td class="text-center"><?php echo $transferType_id ?></td>
                                                <td class="text-center"><?php echo $quantity; ?></td>
                                                <td class="text-center"><?php echo $user_id; ?></td>
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

				<?php include("includes/footer.php") ?>
            </div>
        </div>

        <!-- WRAPPER END  -->
        <!-- WRAPPER END  -->
        <!-- WRAPPER END  -->

    </div>
    <?php include("includes/scripts.php") ?>
    <script>

    </script>
</body>
</html>