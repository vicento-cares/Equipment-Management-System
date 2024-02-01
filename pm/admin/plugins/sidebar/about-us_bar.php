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
        <li class="nav-header">PM Management</li>
        <li class="nav-item">
          <a href="pm-plan.php" class="nav-link">
            <i class="nav-icon fas fa-scroll"></i>
            <p>
              PM Plan
            </p>
          </a>
        </li>
        <li class="nav-item menu-close">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              PM Schedule
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="work-week.php" class="nav-link">
                <i class="fas fa-list-alt nav-icon"></i>
                <p>Work Week</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pm-sticker.php" class="nav-link">
                <i class="fas fa-sticky-note nav-icon"></i>
                <p>PM Sticker</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pm-concerns.php" class="nav-link">
                <i class="fas fa-exclamation-circle nav-icon"></i>
                <p>PM Concerns</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-header">PM Documentation</li>
        <li class="nav-item">
          <a href="machine-checksheets.php" class="nav-link">
            <i class="nav-icon fas fa-tasks"></i>
            <p>
              Machine Checksheets
            </p>
          </a>
        </li>
        <li class="nav-item menu-close">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-archive"></i>
            <p>
              Records
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="pm-records.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>PM Records</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pm-work-orders.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Work Orders</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-header">Miscellaneous</li>
        <li class="nav-item">
          <a href="about-us.php" class="nav-link active">
            <i class="nav-icon fas fa-question-circle"></i>
            <p>
              About Us
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