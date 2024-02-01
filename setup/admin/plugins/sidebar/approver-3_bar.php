<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-gray elevation-4">
  <?php include 'brand_logo.php';?>

  <!-- Sidebar -->
  <div class="sidebar">
    <?php include 'user_panel.php';?>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="home.php" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>
              Home
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="admin-accounts.php" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>
              Account Management
            </p>
          </a>
        </li>
        <li class="nav-header">Machine Information</li>
        <li class="nav-item">
          <a href="machine-masterlist.php" class="nav-link">
            <i class="nav-icon fas fa-tools"></i>
            <p>
              Machine Masterlist
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="machine-history.php" class="nav-link">
            <i class="nav-icon fas fa-history"></i>
            <p>
              Machine History
            </p>
          </a>
        </li>
        <li class="nav-header">Machine Set Up Management</li>
        <li class="nav-item">
          <a href="setup-calendar.php" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Set Up Calendar
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="machine-checksheets.php" class="nav-link">
            <i class="nav-icon fas fa-tasks"></i>
            <p>
              Machine Checksheets
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="machine-checksheets-pm.php" class="nav-link">
            <i class="nav-icon fas fa-tasks"></i>
            <p>
              Machine Checksheets PM
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="unused-machines.php" class="nav-link">
            <i class="nav-icon fas fa-exclamation-circle"></i>
            <p>
              Unused Machines
            </p>
          </a>
        </li>
        <li class="nav-header">Approvers</li>
        <li class="nav-item">
          <a href="approver-1.php" class="nav-link">
            <i class="nav-icon fas fa-user-nurse"></i>
            <p>
              Approver 1
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="approver-2.php" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Approver 2
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="approver-3.php" class="nav-link active">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>
              Approver 3
            </p>
          </a>
        </li>
        <?php include 'logout.php';?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>