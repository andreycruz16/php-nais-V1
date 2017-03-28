<?php
     session_start();
     if(isset($_SESSION['username'])){ //Redirects to a site depending on what type of user logged in
          if ($_SESSION['userType_id'] == 1)
               header("location: views/admin_site");
          else if ($_SESSION['userType_id'] == 2)
               header("location: views/warehouse_site");
          else if ($_SESSION['userType_id'] == 3)
               header("location: views/services_site");
          else if ($_SESSION['userType_id'] == 4)
               header("location: views/manager_site");
          else if ($_SESSION['userType_id'] == 5)
               header("location: views/serviceView_site");
          else if ($_SESSION['userType_id'] == 6)
               header("location: views/warehouseView_site");                 
     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/nichiyu.ico">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Nichiyu Asialift Inventory System</title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   <div class="container">
    <br><br><br><br><br><br><br>
       <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
               <div class="login-panel panel panel-default">
                   <div class="panel-heading">
                      <h3 class="panel-title text-center">Nihiyu Asialift Inventory System</h3>
                   </div>
                   <div class="panel-body">
                       <form role="form" action="login.php" method="post">
                           <fieldset>
                               <div class="form-group">
                                   <input class="form-control" placeholder="Username" name="username" type="username" value="" autofocus>
                               </div>
                               <div class="form-group">
                                   <input class="form-control" placeholder="Password" name="password" type="password" value="" autofocus>
                               </div>
                               <button name="submit" type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-log-in"></span>&nbsp; Login</button>
                           </fieldset>
                       </form>
                   </div>
               </div>
            </div>
            <div class="col-md-4"></div>
       </div>
   </div>
   <!-- jQuery Version 1.11.0 -->
   <script src="assets/js/jquery.min.js"></script>
   <!-- Bootstrap Core JavaScript -->
   <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>