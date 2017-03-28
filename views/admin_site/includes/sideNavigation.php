<nav class="navbar-default navbar-side" role="navigation">
    <div id="sideNav" href=""><i class="fa fa-caret-right" title="Hide / Show"></i></div>
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li>
                <a class="<?php if(basename($_SERVER['REQUEST_URI']) == 'index.php') echo 'active-menu'; else echo ''; ?>" href="index.php"><i class="glyphicon glyphicon-list"></i> All Records</a>
            </li>
            <li>
                <a class="<?php if(basename($_SERVER['REQUEST_URI']) == 'recentStockLogs.php') echo 'active-menu'; else echo ''; ?>" href="recentStockLogs.php"><i class="glyphicon glyphicon-time"></i> Recent Stock Logs</a>
            </li>
            <li>
                <a class="<?php if(basename($_SERVER['REQUEST_URI']) == 'userActivityLogs.php') echo 'active-menu'; else echo ''; ?>" href="userActivityLogs.php"><i class="glyphicon glyphicon-hdd"></i> User Activity Logs</a>
            </li>
            <li>
                <a class="<?php if(basename($_SERVER['REQUEST_URI']) == 'userManagement.php') echo 'active-menu'; else echo ''; ?>"  href="userManagement.php"><i class="glyphicon glyphicon-user"></i> User Management</a>
            </li>
            <li>
                <a class="<?php if(basename($_SERVER['REQUEST_URI']) == 'maintenance.php') echo 'active-menu'; else echo ''; ?>"  href="maintenance.php"><i class="glyphicon glyphicon-cog"></i> Maintenance</a>
            </li>
            <li>
                <a class="<?php if(basename($_SERVER['REQUEST_URI']) == 'accountSettings.php') echo 'active-menu'; else echo ''; ?>"  href="accountSettings.php"><i class="glyphicon glyphicon-wrench"></i> Account Settings</a>
            </li>            
        </ul>
    </div>
</nav>