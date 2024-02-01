<?php
include('plugins/header.php');
include('plugins/css/setup-calendar_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar/setup-calendar_navbar.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row mb-2 ml-1 mr-1">
        <div class="col-sm-6">
          <h1 class="m-0"> Set Up Calendar</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/ems/setup/">EMS Set Up</a></li>
            <li class="breadcrumb-item active">Set Up Calendar</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="row ml-1 mr-1 mb-4">
        <div class="col-sm-3 offset-sm-9">
          <button type="button" class="btn bg-lime btn-block" id="btnReqActSched" data-toggle="modal" data-target="#ReqActSchedModal"><i class="fas fa-plus-circle"></i> Request Activity Schedule</button>
        </div>
      </div>
      <div class="row ml-1 mr-1">
        <div class="col-sm-12">
          <div class="card card-lime card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-tasks"></i> Requested Set Up Activity Schedule Table</h3>
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
      <div class="row ml-1 mr-1">
        <div class="col-sm-12">
          <div class="card card-lime card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-history"></i> Recent Set Up Activity Schedule History Table</h3>
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
                <label id="counter_view_search2"></label>
              </div>
              <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                <table id="recentSetupActHistoryTable" class="table table-sm table-head-fixed text-nowrap table-hover">
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
                  <tbody id="recentSetupActHistoryData" style="text-align: center;">
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
      <div class="row ml-1 mr-1">
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
                <label id="counter_view_search3"></label>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include('plugins/footer.php');
include('plugins/modals/request-activity-schedule-details_modal.php');
include('plugins/modals/recent-activity-schedule-history_modal.php');
include('plugins/modals/activity-schedule-details_modal.php');
include('plugins/modals/request-activity-schedule_modal.php');
include('plugins/js/setup-calendar_script.php');
?>
