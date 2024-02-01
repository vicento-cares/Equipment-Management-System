<?php
include('plugins/header.php');
include('plugins/css/home_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/home_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Home</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">EMS Set Up</a></li>
              <li class="breadcrumb-item active">Home</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-8">
            <div class="card card-lime card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tasks"></i> Machine Checksheet Table</h3>
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
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="i_search" maxlength="255" placeholder="Search">
                  </div>
                  <div class="col-sm-4">
                    <button type="button" class="btn bg-lime btn-block" onclick="get_recent_machine_checksheets()"><i class="fas fa-search"></i> Search</button>
                  </div>
                </div>
                <div id="accordion_recent_mstprc_legend">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title w-100">
                        <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseOneRecentMstprcLegend">
                          Recent MSTPRC Legend
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOneRecentMstprcLegend" class="collapse" data-parent="#accordion_recent_mstprc_legend">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-4 col-lg-4 p-1 bg-gray-dark"><center>Pending</center></div>
                          <div class="col-sm-4 col-lg-4 p-1 bg-yellow"><center>Confirmed - Waiting for First Approval</center></div>
                          <div class="col-sm-4 col-lg-4 p-1 bg-success"><center>Approved - Waiting for Second Approval</center></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="machineChecksheetTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>MSTPRC No.</th>
                        <th>Machine No.</th>
                        <th>Equipment No.</th>
                        <th>Type</th>
                        <th>MSTPRC Date</th>
                      </tr>
                    </thead>
                    <tbody id="machineChecksheetData" style="text-align: center;"></tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count">
                  <label id="counter_view"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lime" id="search_more_data" style="display:none;" onclick="get_machine_checksheet(2)">Load more</button>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-sm-4">
            <div class="card card-lime card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-check"></i> Set Up Activity</h3>
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
                  <div class="col-sm-12 text-bold" id="setup_activity_date_now"></div>
                  <input type="hidden" id="setup_activity_date_now_hidden">
                </div>
                <div class="table-responsive" style="max-height: 200px; overflow: auto; display:inline-block;">
                  <table id="setupActivityTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <tbody id="setupActivityData" style="text-align: center;"></tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div class="d-flex justify-content-between">
                  <button type="button" class="btn bg-lime" onclick="get_previous_setup_activities()"><< Previous</button>
                  <button type="button" class="btn bg-lime" onclick="get_next_setup_activities()">Next >></button>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include('plugins/footer.php');
include('plugins/modals/logout_modal.php');
include('plugins/modals/recent-mstprc_modal.php');
include('plugins/js/home_script.php');
?>