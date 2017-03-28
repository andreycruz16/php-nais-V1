<nav class="navbar-default navbar-side" role="navigation">
    <div id="sideNav" href=""><i class="fa fa-caret-right"></i></div>
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li>
                <a class="<?php if(basename($_SERVER['REQUEST_URI']) == 'index.php') echo 'active-menu'; else echo ''; ?>" href="index.php"><i class="glyphicon glyphicon-list"></i> All Records</a>
            </li>
            <li>
                <a class="<?php if(basename($_SERVER['REQUEST_URI']) == 'recentStockLogs.php') echo 'active-menu'; else echo ''; ?>" href="recentStockLogs.php"><i class="glyphicon glyphicon-dashboard"></i> Recent Stock Logs</a>
            </li>
            <li>
                <a class="<?php if(basename($_SERVER['REQUEST_URI']) == 'lowStocks.php') echo 'active-menu'; else echo ''; ?>" href="lowStocks.php"><i class="glyphicon glyphicon-minus"></i> Low Stocks</a>
            </li>
<!--             <li>
                <a class="<?php if(basename($_SERVER['REQUEST_URI']) == '#') echo 'active-menu'; else echo ''; ?>" href="#"><i class="glyphicon glyphicon-stats"></i> Stock Charts</a>
            </li> -->
            <li>
                <a class="<?php if(basename($_SERVER['REQUEST_URI']) == 'reports.php') echo 'active-menu'; else echo ''; ?>" href="reports.php"><i class="glyphicon glyphicon-print"></i> Reports</a>
            </li>
            <li>
                <a class="<?php if(basename($_SERVER['REQUEST_URI']) == 'userActivityLogs.php') echo 'active-menu'; else echo ''; ?>" href="userActivityLogs.php"><i class="glyphicon glyphicon-user"></i> User Activity Logs</a>
            </li>
            <li>
                <a class="<?php if(basename($_SERVER['REQUEST_URI']) == 'accountSettings.php') echo 'active-menu'; else echo ''; ?>"  href="accountSettings.php"><i class="glyphicon glyphicon-wrench"></i> Account Settings</a>
            </li>
        </ul>
    </div>
</nav>