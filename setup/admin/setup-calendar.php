<?php
include('plugins/header.php');
include('plugins/css/setup-calendar_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/setup-calendar_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Set Up Calendar</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">EMS Set Up</a></li>
              <li class="breadcrumb-item"><a href="setup-calendar.php">Machine Set Up Management</a></li>
              <li class="breadcrumb-item active">Set Up Calendar</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-4">
          <div class="col-sm-3 offset-sm-9">
            <button type="button" class="btn bg-lime btn-block" id="btnAddActSched" data-toggle="modal" data-target="#AddActSchedModal"><i class="fas fa-plus-circle"></i> Add Activity Schedule</button>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-lime card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tasks"></i> Set Up Activity Schedule Request Table</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="setupActReqTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>Activity Date</th>
                        <th>Car Model</th>
                        <th>Requestor Name</th>
                        <th>Detail of Request</th>
                        <th>Request Date & Time</th>
                      </tr>
                    </thead>
                    <tbody id="setupActReqData" style="text-align: center;">
                      <tr>
                        <td colspan="6" style="text-align:center;">
                          <div class="spinner-border text-dark" role="status">
                            <span class="sr-only">Loading...</span>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-lime card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-check"></i> Setup Activity Schedule Table</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row mb-4">
                  <div class="col-sm-4">
                    <label>Year</label>
                    <select class="form-control" id="search_year" style="width: 100%;" onchange="get_setup_activities()"></select>
                  </div>
                  <div class="col-sm-4">
                    <label>Month</label>
                    <select class="form-control" id="search_month" style="width: 100%;" onchange="get_setup_activities()"></select>
                  </div>
                  <div class="col-sm-4">
                    <label>Refresh</label>
                    <button type="button" class="btn bg-lime btn-block" onclick="get_setup_activities()"><i class="fas fa-sync-alt"></i> Refresh Table</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search2"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="setupActivityTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>Date</th>
                        <th>Setup Activity Details</th>
                      </tr>
                    </thead>
                    <tbody id="setupActivityData" style="text-align: center;"></tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include('plugins/footer.php');
include('plugins/modals/logout_modal.php');
include('plugins/modals/request-activity-schedule-details_modal.php');
include('plugins/modals/decline-activity-schedule_modal.php');
include('plugins/modals/add-activity-schedule_modal.php');
include('plugins/modals/activity-schedule-details_modal.php');
include('plugins/modals/delete-activity-schedule_modal.php');
include('plugins/js/setup-calendar_script.php');
?>
