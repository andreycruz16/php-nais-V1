<!-- TOP NAVIGATION -->
<nav class="navbar navbar-default top-navbar" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"><strong>NICHIYU&nbsp;ASIALIFT&nbsp;INVENTORY&nbsp;SYSTEM</strong></a>
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <li>
                    <a href="lowStocks.php">
                        <div>
                            <?php 
                                
                                $sql = "SELECT COUNT(*) FROM tbl_warehouse WHERE tbl_warehouse.quantity <= tbl_warehouse.minStockCount;";
                                $row = mysqli_fetch_array(mysqli_query($conn, $sql), MYSQL_NUM); 
                            ?>
                            <i class="glyphicon glyphicon-minus"></i>&nbsp;&nbsp; Low Stocks 
                            <strong class="pull-right text-danger"><?php echo $row[0]; mysqli_close($conn); ?></strong>
                        </div>
                    </a>
                </li>
            </ul>
        </li>        
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                <img class="img-rounded" src="../../assets/img/userProfile/<?php echo $_SESSION['displayPicture']; ?>" height="25" width="25" alt="<?php echo $_SESSION['username']; ?>"> <?php echo $_SESSION['username']; ?>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="accountSettings.php"><img class="img-circle img-thumbnail img-responsive" src="../../assets/img/userProfile/<?php echo $_SESSION['displayPicture']; ?>" alt="<?php echo $_SESSION['username']; ?>"><br><i class="fa fa-user fa-fw"></i> Account Settings</a>
                </li>
                <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>