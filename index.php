<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="EMS - Home Page" />
  <meta name="keywords" content="EMS, Home Page" />

  <title>EMS | Home Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="preload" href="dist/css/font.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <!-- Font Awesome Icons -->
  <link rel="preload" href="plugins/fontawesome-free/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <!-- Theme style -->
  <link rel="preload" href="dist/css/adminlte.min.css" as="style" onload="this.rel='stylesheet'">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <style type="text/css">
    .preloader {
      width: 100%;
      background-image: url('dist/img/ems-bg-img-setup.webp');
      background-size: cover;
    }
    .dark-mode a:not(.btn):hover {
      color: #01ff70;
    }
    /* CUSTOM SWEETALERT COLOR */
    .swal-icon--success:before {
      background-color: rgba(52, 58, 64, 1);
    }
    .swal-icon--success__hide-corners {
      background-color: rgba(52, 58, 64, 1);
    }
    .swal-icon--success:after {
      background-color: rgba(52, 58, 64, 1);
    }
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
    <link rel="stylesheet" href="dist/css/font.min.css">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
  </noscript>

  <link rel="icon" type="image/x-icon" href="dist/img/ems-logo.ico">
</head>

<body class="hold-transition layout-top-nav dark-mode accent-lime">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble img-circle elevation-3 p-1 bg-white" src="dist/img/ems-logo.png" alt="EMS Logo" height="120" width="120">
    <noscript>
      <br>
      <span>We are facing <strong>Script</strong> issues. Kindly enable <strong>JavaScript</strong>!!!</span>
      <br>
      <span>Call IT Personnel Immediately!!! They will fix it right away.</span>
    </noscript>
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light bg-lime text-dark border-bottom-0 accent-gray">
    <!-- <a href="/ems/" class="navbar-brand ml-2">
      <img src="dist/img/ems-logo.png" alt="EMS Logo" class="brand-image img-circle elevation-3 p-1 bg-white" style="opacity: .8">
      <span class="brand-text font-weight-light"><b>EMS</b></span>
    </a> -->

    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="/ems/" class="nav-link active"><i class="fas fa-home"></i> Home Page</a>
        </li>
        <li class="nav-item dropdown">
          <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-tools"></i> Setup</a>
          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
            <li><a href="/ems/setup/" class="dropdown-item">Setup Home Page</a></li>
            <li><a href="setup/setup-calendar.php" class="dropdown-item">Set Up Calendar</a></li>
            <li><a href="setup/unused-machines.php" class="dropdown-item">Unused Machines</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-scroll"></i> PM</a>
          <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
            <li><a href="pm/work-week.php" class="dropdown-item">PM Schedule (Work Week) </a></li>
            <li><a href="/ems/pm/" class="dropdown-item">PM Concerns </a></li>
            <li><a href="pm/pm-records.php" class="dropdown-item">PM Records </a></li>
            <li><a href="pm/pm-work-orders.php" class="dropdown-item">PM Work Orders</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="/ems/login/" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a>
        </li>
      </ul>
    </div>

    <!-- Right navbar links -->
    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
      <div class="row d-flex no-block justify-content-center align-items-center vh-100">
        <img class="animation__wobble img-circle elevation-3 p-1 bg-white" src="dist/img/ems-logo.png" alt="EMS Logo" height="240" width="240">
        <h1 class="ml-5"><b>Equipment Management System</b></h1>
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <b>Version</b> 1.0.0
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023 Vince Dale Alcantara.</strong>
    All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- News Modal -->
<input type="hidden" id="modal_stat" value="Hide">
<div class="modal fade" id="news_window" data-backdrop="static" data-keyboard="false" style="z-index: 10000 !important;">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gray">
        <h4 class="modal-title" id="news_window_title">Reminders</h4>
        <button type="button" class="close" aria-label="Close" id="news_window_close" onclick="close_modal_news_window()">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="news_window_body">
        <!--  News and Updates Section  -->
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel" data-interval="10000" data-pause="false">
          <div class="carousel-inner">
            <div class="carousel-item active">
            <img class="d-block w-100" src="dist/img/HW_S/1.jpg"
              alt="slide1">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/HW_S/2.jpg"
              alt="slide2">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/HW_S/3.jpg"
              alt="slide3">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/HW_S/4.jpg"
              alt="slide4">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/HW_S/5.jpg"
              alt="slide5">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/HW_S/6.jpg"
              alt="slide6">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/HW_S/7.jpg"
              alt="slide7">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/HW_S/8.jpg"
              alt="slide8">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/HW_S/9.jpg"
              alt="slide9">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/HW_S/10.jpg"
              alt="slide10">
            </div>
            <!-- Valentines -->
            <!-- <div class="carousel-item active">
            <img class="d-block w-100" src="dist/img/feb/1.jpg"
              alt="slide1">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/feb/2.jpg"
              alt="slide2">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/feb/3.jpg"
              alt="slide3">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/feb/4.jpg"
              alt="slide4">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/feb/6.jpg"
              alt="slide6">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/feb/7.jpg"
              alt="slide7">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/feb/8.jpg"
              alt="slide8">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/feb/9.jpg"
              alt="slide9">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/feb/10.png"
              alt="slide10">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/feb/11.jpg"
              alt="slide11">
            </div> -->
            <!-- Christmas -->
            <!-- <div class="carousel-item active">
            <img class="d-block w-100" src="dist/img/1/christmas1.jpg"
              alt="slide1">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/1/christmas2.jpg"
              alt="slide2">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/1/christmas3.jpg"
              alt="slide3">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/1/christmas4.jpg"
              alt="slide4">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/1/christmas5.jpg"
              alt="slide5">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/1/christmas6.jpg"
              alt="slide6">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/1/christmas8.jpg"
              alt="slide7">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/1/christmas9.jpg"
              alt="slide8">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/1/christ1.jpg"
              alt="slide9">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/1/christ2.jpg"
              alt="slide10">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/1/christ3.jpg"
              alt="slide11">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/1/epiphany1.jpg"
              alt="slide12">
            </div>
            <div class="carousel-item">
            <img class="d-block w-100" src="dist/img/1/epiphany2.jpg"
              alt="slide13">
            </div> -->
          </div>
          <a class="carousel-control-prev text-dark" href="#carouselExampleFade" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon text-dark" aria-hidden="true"></span>
            <span class="sr-only text-dark">Previous</span>
          </a>
          <a class="carousel-control-next text-dark" href="#carouselExampleFade" role="button" data-slide="next">
            <span class="carousel-control-next-icon text-dark" aria-hidden="true"></span>
            <span class="sr-only text-dark">Next</span>
          </a>
        </div>
        <!--  End of News and Updates Section  -->
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script defer src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert --->
<script defer src="plugins/sweetalert/dist/sweetalert.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script type="text/javascript">
// DOMContentLoaded function
document.addEventListener("DOMContentLoaded", () => {
  activityWatcher();
});

const close_modal_news_window = () => {
  $('#news_window').modal('toggle');
  document.getElementById('modal_stat').value='Hide';
}

const activityWatcher = () => {
  var secondsSinceLastActivity = 0;
  // Maximum 30sec of inactivity
  var maxInactivity = 30;
  setInterval(() => {
      secondsSinceLastActivity++;
      if (secondsSinceLastActivity > maxInactivity) {
        var modal_stat = document.getElementById("modal_stat").value;

        if (modal_stat == "Hide") {
          $("#news_window").modal();
          document.getElementById("modal_stat").value="Show";
        }
      }
  }, 1000);

  const activity = () => {
    secondsSinceLastActivity = 0;
  }

  var activityEvents = ['mousedown', 'mousemove', 'keydown','scroll', 'touchstart'];
  
  activityEvents.forEach(eventName => {
    document.addEventListener(eventName, activity, true);
  });
}
</script>

<noscript>We are facing Script issues. Kindly enable JavaScript</noscript>

</body>
</html>
