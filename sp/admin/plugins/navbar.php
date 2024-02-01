<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light bg-lime text-dark border-bottom-0 accent-gray">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#" id="notif_badge">
        <i class="far fa-bell"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header text-white" id="notif_title">Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="approver-2.php" class="dropdown-item" id="notif_pending_mstprc">
          <i class="fas fa-spinner mr-2"></i> No new pending approval
          <span class="float-right text-muted text-sm"></span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="pm-concerns.php" class="dropdown-item" id="notif_new_pm_concerns">
          <i class="fas fa-exclamation-circle mr-2"></i> No new PM Concerns
          <span class="float-right text-muted text-sm"></span>
        </a>
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