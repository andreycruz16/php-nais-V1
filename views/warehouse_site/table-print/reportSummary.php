<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />	
	<!-- Bootstrap Styles-->
	<link href="../assets/css/bootstrap.css" rel="stylesheet" />
	<!-- FontAwesome Styles-->
	<link href="../assets/css/font-awesome.css" rel="stylesheet" />
	<!-- Google Fonts-->
	<link href='../assets/css/opensans-font.css' rel='stylesheet' type='text/css' />
	<!-- <link href="../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" /> -->
	<link href="../../../assets/css/dataTables.bootstrap.min.css" rel="stylesheet" />
	<style type="text/css">
	td {
		font-size: .7em;
	}
	th {
		font-size: .7em;
	}
	</style>
</head>
<body onload=javascript:print();>
	<body>
		<span><strong>Warehouse Report Summary</strong> (<?php  echo date("F d, Y | l"); ?>)</span>
		<!-- PAGE CONTENT -->
		<div id="page-wrapper">           
			<div id="page-inner">
				<div class="row">
					<!-- CURRENT STOCK RECORDS (A-Z) -->
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-condensed table-hover">
										<thead>
											<tr>
												<th class="text-center" bgcolor="f2ba7f" width="">Date&nbsp;(M/D/Y)</th>
												<th class="text-center" bgcolor="f2ba7f" width="">Description</th>
												<th class="text-center" bgcolor="f2ba7f" width="">Reference&nbsp;Type</th>
												<th class="text-center" bgcolor="f2ba7f" width="">Reference&nbsp;#</th>
												<th class="text-center" bgcolor="f2ba7f" width="">Part&nbsp;#</th>
												<th class="text-center" bgcolor="f2ba7f" width="">Boxnumber</th>
												<th class="text-center" bgcolor="f2ba7f" width="">Quantity</th>
												<th class="text-center" bgcolor="f2ba7f" width="">Customer</th>
												<th class="text-center" bgcolor="f2ba7f" width="">Model</th>
												<th class="text-center" bgcolor="f2ba7f" width="">S/N</th>
												<th class="text-center" bgcolor="f2ba7f" width="">Min Stock Count</th>
												<th class="text-center" bgcolor="f2ba7f" width="">Transfer Type</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											require '../../../database.php';
											$sql = "SELECT tbl_warehouse.stock_id,
											tbl_warehouse.date,
											tbl_warehouse.description,
											tbl_reference.referenceType,
											tbl_warehouse.referenceNumber,
											tbl_warehouse.partNumber,
											tbl_warehouse.boxNumber,
											tbl_warehouse.quantity,
											tbl_warehouse.customerName,
											tbl_warehouse.model,
											tbl_warehouse.serialNumber,
											tbl_warehouse.minStockCount,
											tbl_transfer_type.transferType
											FROM tbl_warehouse
											INNER JOIN tbl_reference
											ON tbl_warehouse.reference_id = tbl_reference.reference_id
											INNER JOIN tbl_transfer_type
											ON tbl_warehouse.transferType_id = tbl_transfer_type.transferType_id;";
		                             // echo $sql;
											$result = mysqli_query($conn, $sql);
											if (mysqli_num_rows($result) > 0) {
												while($row = mysqli_fetch_array($result, MYSQL_NUM)) { 
													$stock_id = $row[0];
													$date = $row[1];
													$description = $row[2];
													$referenceType = $row[3];
													$referenceNumber = $row[4];
													$partNumber = $row[5];
													$boxNumber = $row[6];
													$quantity = $row[7];
													$customerName = $row[8];
													$model = $row[9];
													$serialNumber = $row[10];
													$minStockCount = $row[11];
													$transferType = $row[12];
													?>
													<tr class="<?php if($quantity <= $minStockCount) echo "danger"; else echo "success";?>">
														<td><?php  echo date('m/d/Y', strtotime($date)); ?></td>
														<td><?php  echo $description; ?></td>
														<td><?php  echo $referenceType; ?></td>
														<td><?php  echo $referenceNumber; ?></td>
														<td><?php  echo $partNumber; ?></td>
														<td><?php  echo $boxNumber; ?></td>
														<td><?php  echo $quantity; ?></td>
														<td><?php  echo $customerName; ?></td>
														<td><?php  echo $model; ?></td>
														<td><?php  echo $serialNumber; ?></td>
														<td><?php  echo $minStockCount; ?></td>
														<td><?php  echo $transferType; ?></td>
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
			</div>
		</div>
		<!-- PAGE CONTENT END -->
	</body>
	</html>

	<!-- JS SCRIPTS-->
	<script src="../assets/js/jquery-1.10.2.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<!-- Metis Menu Js -->
	<script src="../assets/js/jquery.metisMenu.js"></script>
	<!-- DATA TABLE SCRIPTS -->
	<script src="../assets/js/dataTables/jquery.dataTables.js"></script>
	<script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>

