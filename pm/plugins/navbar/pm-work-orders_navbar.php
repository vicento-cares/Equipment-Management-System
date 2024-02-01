<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light bg-lime text-dark border-bottom-0 accent-gray">
  <a href="/ems/" class="navbar-brand ml-2">
    <img src="../dist/img/ems-logo.png" alt="EMS Logo" class="brand-image img-circle elevation-3 p-1 bg-white" style="opacity: .8">
    <span class="brand-text font-weight-light"><b>EMS</b> PM - Public Page</span>
  </a>

  <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse order-3" id="navbarCollapse">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a href="/ems/" class="nav-link"><i class="fas fa-home"></i> Home Page</a>
      </li>
      <li class="nav-item dropdown">
        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-tools"></i> Setup</a>
        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
          <li><a href="/ems/setup/" class="dropdown-item">Setup Home Page</a></li>
          <li><a href="../setup/setup-calendar.php" class="dropdown-item">Set Up Calendar</a></li>
          <li><a href="../setup/unused-machines.php" class="dropdown-item">Unused Machines</a></li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle active"><i class="fas fa-scroll"></i> PM</a>
        <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
          <li><a href="work-week.php" class="dropdown-item">PM Schedule (Work Week) </a></li>
          <li><a href="/ems/pm/" class="dropdown-item">PM Concerns </a></li>
          <li><a href="pm-records.php" class="dropdown-item">PM Records </a></li>
          <li><a href="pm-work-orders.php" class="dropdown-item active">PM Work Orders</a></li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="/ems/pm/admin" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a>
      </li>
    </ul>
  </div>

  <!-- Right navbar links -->
  <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#" id="notif_badge">
        <i class="far fa-bell"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header text-white" id="notif_title">Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="/ems/pm/" class="dropdown-item" id="notif_done_pm_concerns">
          <i class="fas fa-check mr-2"></i> No new Done PM Concerns
          <span class="float-right text-muted text-sm"></span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="/ems/pm/" class="dropdown-item" id="notif_pending_pm_concerns">
          <i class="fas fa-spinner mr-2"></i> No new Pending PM Concerns
          <span class="float-right text-muted text-sm"></span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="/ems/pm/" class="dropdown-item dropdown-footer">See All PM Concerns</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->
