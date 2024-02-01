<?php
include('plugins/header.php');
include('plugins/css/pm-concerns_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/pm-concerns_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>PM Concerns</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">EMS PM</a></li>
              <li class="breadcrumb-item"><a href="pm-concerns.php">PM Management</a></li>
              <li class="breadcrumb-item active">PM Concerns</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-lime card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-exclamation-circle"></i> PM Concerns Table</h3>
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
                  <table id="pmConcernsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>PM Concern ID</th>
                        <th>Machine Line</th>
                        <th>Problem</th>
                        <th>Request By</th>
                        <th>Confirm By</th>
                        <th>Comment</th>
                        <th>Date & Time</th>
                      </tr>
                    </thead>
                    <tbody id="pmConcernsData" style="text-align: center;">
                      <tr>
                        <td colspan="8" style="text-align:center;">
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
                <h3 class="card-title"><i class="fas fa-spinner"></i> Pending PM Concerns Table</h3>
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
                  <table id="pendingPmConcernsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>PM Concern ID</th>
                        <th>Machine Line</th>
                        <th>Problem</th>
                        <th>Request By</th>
                        <th>Confirm By</th>
                        <th>Comment</th>
                        <th>Date & Time</th>
                      </tr>
                    </thead>
                    <tbody id="pendingPmConcernsData" style="text-align: center;">
                      <tr>
                        <td colspan="8" style="text-align:center;">
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
                <h3 class="card-title"><i class="fas fa-tools"></i> No Spare PM Concerns Table</h3>
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
                  <label id="counter_view_search3"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="noSparePmConcernsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>PM Concern ID</th>
                        <th>Machine Line</th>
                        <th>Problem</th>
                        <th>Request By</th>
                        <th>Confirm By</th>
                        <th>Comment</th>
                        <th>No. of Parts</th>
                        <th>Date & Time</th>
                      </tr>
                    </thead>
                    <tbody id="noSparePmConcernsData" style="text-align: center;">
                      <tr>
                        <td colspan="9" style="text-align:center;">
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
            <div class="card card-lime card-outline collapsed-card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history"></i> PM Concerns History Table</h3>
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
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>Concern Date From</label>
                    <input type="datetime-local" class="form-control" id="history_concern_date_from">
                  </div>
                  <div class="col-sm-3">
                    <label>Concern Date To</label>
                    <input type="datetime-local" class="form-control" id="history_concern_date_to">
                  </div>
                  <div class="col-sm-6">
                    <label>Machine Name</label>
                    <input list="history_machines" class="form-control" id="history_machine_name" maxlength="255">
                    <datalist id="history_machines"></datalist>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>PM Concern ID</label>
                    <input type="text" class="form-control" id="history_pm_concern_id" maxlength="255">
                  </div>
                  <div class="col-sm-3">
                    <label>Car Model</label>
                    <input list="history_car_models" class="form-control" id="history_car_model" maxlength="255">
                    <datalist id="history_car_models"></datalist>
                  </div>
                  <div class="col-sm-3">
                    <label>Search</label>
                    <button type="button" class="btn bg-lime btn-block" onclick="get_pm_concerns_history(1)"><i class="fas fa-search"></i> Search</button>
                  </div>
                  <div class="col-sm-3">
                    <label>Export</label>
                    <button type="button" class="btn bg-lime btn-block" id="btnExportPmConcernHistory" onclick="export_pm_concerns_history()"><i class="fas fa-download"></i> Export</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search4"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="pmConcernsHistoryTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>PM Concern ID</th>
                        <th>Machine Line</th>
                        <th>Problem</th>
                        <th>Request By</th>
                        <th>Confirm By</th>
                        <th>Comment</th>
                        <th>No. of Parts</th>
                        <th>Date & Time</th>
                      </tr>
                    </thead>
                    <tbody id="pmConcernsHistoryData" style="text-align: center;"></tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count4">
                  <label id="counter_view4"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lime" id="search_more_data4" style="display:none;" onclick="get_pm_concerns_history(2)">Load more</button>
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
include('plugins/modals/pm-concern_details.php');
include('plugins/modals/pending-no-spare-pm-concern_modal.php');
include('plugins/modals/no-spare-pm-concern_modal.php');
include('plugins/modals/pending-pm-concern_modal.php');
include('plugins/modals/pending-pm-concern_details.php');
include('plugins/js/pm-concerns_script.php');
?>
