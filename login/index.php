<?php 
//session_set_cookie_params(0, "/ems/setup");
//session_set_cookie_params(0, "/ems/pm");
//session_set_cookie_params(0, "/ems/sp");
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();

if (isset($_SESSION['setup_username'])) {
  if ($_SESSION['setup_approver_role'] == "1") {
    header('location:../setup/approver1/home.php');
    exit;
  } else if ($_SESSION['setup_approver_role'] == "2") {
    header('location:../setup/approver2/home.php');
    exit;
  } else if ($_SESSION['setup_approver_role'] == "3") {
    header('location:../setup/approver3/home.php');
    exit;
  } else if ($_SESSION['setup_approver_role'] == "N/A") {
    header('location:../setup/admin/home.php');
    exit;
  }
} else if (isset($_SESSION['pm_username'])) {
  if ($_SESSION['pm_role'] == "Prod") {
    header('location:../pm/prod/home.php');
    exit;
  } else if ($_SESSION['pm_role'] == "QA") {
    header('location:../pm/qa/home.php');
    exit;
  } else if ($_SESSION['pm_role'] == "Admin" || $_SESSION['pm_role'] == "PM") {
    header('location:../pm/admin/home.php');
    exit;
  }
} else if (isset($_SESSION['sp_username'])) {
  header('location:../sp/admin/approver-2.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="EMS - Login" />
  <meta name="keywords" content="Login, EMS" />

  <title>EMS | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="preload" href="../dist/css/font.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <!-- Font Awesome -->
  <link rel="preload" href="../plugins/fontawesome-free/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <!-- Theme style -->
  <link rel="preload" href="../dist/css/adminlte.min.css" as="style" onload="this.rel='stylesheet'">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <style type="text/css">
    /* CUSTOM FOCUS CSS */
    .login-card-body .input-group .form-control:focus ~ .input-group-prepend .input-group-text,
    .login-card-body .input-group .form-control:focus ~ .input-group-append .input-group-text,
    .register-card-body .input-group .form-control:focus ~ .input-group-prepend .input-group-text,
    .register-card-body .input-group .form-control:focus ~ .input-group-append .input-group-text {
      border-color: #81ffb8;
    }
    .login-card-body .input-group .form-control.is-invalid ~ .input-group-append .input-group-text,
    .register-card-body .input-group .form-control.is-invalid ~ .input-group-append .input-group-text {
      border-color: #dc3545;
    }
    .login-page {
      width: 100%;
      background-image: url('../dist/img/ems-bg-img-setup.webp');
      background-size: cover;
    }
    /* CUSTOM SWEETALERT COLOR */
    .swal-modal {
      background-color: rgba(52, 58, 64, 1);
    }
    .swal-title {
      color: rgba(255, 255, 255, 1);
    }
    .swal-text {
      color: rgba(255, 255, 255, 1);
    }
    .swal-button {
      background: #01ff70;
      color: #343a40;
    }
    .swal-button:not([disabled]):hover {
      background-color: #00cd5a;
    }
  </style>

  <noscript>
    <link rel="stylesheet" href="../dist/css/font.min.css">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  </noscript>

  <link rel="icon" type="image/x-icon" href="../dist/img/ems-logo.png">
</head>
<body class="hold-transition login-page dark-mode accent-lime">
  <div class="login-box">
    <div class="login-logo">
      <img class="animation__wobble img-circle elevation-3 p-1 bg-white" src="../dist/img/ems-logo.png" alt="EMS Logo" height="120" width="120">
    </div>
    <!-- /.login-logo -->
    <div class="card card-outline card-lime">
      <div class="card-header text-center">
        <h2><b>EMS</b></h2>
        <p class="login-box-msg py-0">Sign in to start your session</p>
      </div>
      <div class="card-body login-card-body">
        <form id="quickForm" action="javascript:void(0)">
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="username" class="form-control" id="username" placeholder="Username" maxlength="255" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user-alt"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <select class="form-control" id="account_type" name="account_type" required>
                <option disabled selected value="">Select Account Type</option>
                <option value="Setup">Setup</option>
                <option value="PM">PM</option>
                <option value="SP">Spare Parts</option>
              </select>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-tasks"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col">
              <button type="submit" class="btn bg-lime btn-block" id="login">Login</button>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col">
              <button type="button" href="#" target="_blank" class="btn bg-gray btn-block" id="wi">Work Instruction</button>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <center>
                <a href="/ems/">Go Back to Home Page</a>
              </center>
            </div>
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script defer src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- jquery-validation -->
  <script defer src="../plugins/jquery-validation/jquery.validate.min.js"></script>
  <script defer src="../plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- SweetAlert --->
  <script defer src="../plugins/sweetalert/dist/sweetalert.min.js"></script>
  <!-- Script -->
  <script defer src="../dist/js/src/cookie.js"></script>
  <script defer src="../dist/js/login/index.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>

  <noscript>
    <br>
    <span>We are facing <strong>Script</strong> issues. Kindly enable <strong>JavaScript</strong>!!!</span>
    <br>
    <span>Call IT Personnel Immediately!!! They will fix it right away.</span>
  </noscript>

</body>
</html>