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
          <a href="admin-accounts.php" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>
              Account Management
            </p>
          </a>
        </li>
        <li class="nav-header">Setup Approver</li>
        <li class="nav-item">
          <a href="approver-2.php" class="nav-link active">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Approver 2
            </p>
          </a>
        </li>
        <li class="nav-header">PM Management</li>
        <li class="nav-item">
          <a href="pm-concerns.php" class="nav-link">
            <i class="nav-icon fas fa-exclamation-circle"></i>
            <p>
              PM Concerns
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