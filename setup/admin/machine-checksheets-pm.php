<?php
include('plugins/header.php');
include('plugins/css/machine-checksheets-pm_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/machine-checksheets-pm_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Machine Checksheets PM (New & Unused Machines)</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">EMS Set Up</a></li>
              <li class="breadcrumb-item"><a href="machine-checksheets-pm.php">Machine Setup Management</a></li>
              <li class="breadcrumb-item active">Machine Checksheets PM</li>
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
            <div class="card card-gray card-tabs">
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="machine-checksheets-pm-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="machine-checksheets-pm-1-tab" data-toggle="pill" href="#machine-checksheets-pm-1" role="tab" aria-controls="machine-checksheets-pm-1" aria-selected="true">Need RSIR + PM Sticker Machine Checksheet</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="machine-checksheets-pm-2-tab" data-toggle="pill" href="#machine-checksheets-pm-2" role="tab" aria-controls="machine-checksheets-pm-2" aria-selected="false">Pending & Recent RSIR History</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="machine-checksheets-pm-3-tab" data-toggle="pill" href="#machine-checksheets-pm-3" role="tab" aria-controls="machine-checksheets-pm-3" aria-selected="false">Returned RSIR</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="machine-checksheets-pm-tabContent">

                  <div class="tab-pane fade show active" id="machine-checksheets-pm-1" role="tabpanel" aria-labelledby="machine-checksheets-pm-1-tab">
                    <div class="row mb-4">
                      <div class="col-sm-3">
                        <label>History Option</label>
                        <select class="form-control" id="history_option" style="width: 100%;" onchange="get_need_rsir_machine_checksheets()">
                          <option selected value="1">Pending / Partially Approved</option>
                          <option value="2">Fully Approved</option>
                        </select>
                      </div>
                    </div>
                    <div class="d-flex justify-content-sm-start">
                      <label id="counter_view_search"></label>
                    </div>
                    <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                      <table id="machineChecksheetPendingTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                        <thead style="text-align: center;">
                          <tr>
                            <th>No.</th>
                            <th>MSTPRC No.</th>
                            <th>Machine Name</th>
                            <th>Machine No.</th>
                            <th>Equipment No.</th>
                            <th>Car Model</th>
                            <th>Checksheet Type</th>
                            <th>MSTPRC Date</th>
                          </tr>
                        </thead>
                        <tbody id="machineChecksheetPendingData" style="text-align: center;">
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

                  <div class="tab-pane fade" id="machine-checksheets-pm-2" role="tabpanel" aria-labelledby="machine-checksheets-pm-2-tab">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="card card-lime card-outline">
                          <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-spinner"></i> Pending RSIR Approval Table</h3>
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
                            <div id="accordion_pending_rsir_legend">
                              <div class="card shadow">
                                <div class="card-header">
                                  <h4 class="card-title w-100">
                                    <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseOnePendingRsirLegend">
                                      Pending RSIR Legend
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapseOnePendingRsirLegend" class="collapse" data-parent="#accordion_pending_rsir_legend">
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-sm-4 col-lg-4 p-1 bg-lime"><center>Unread</center></div>
                                      <div class="col-sm-4 col-lg-4 p-1 bg-yellow"><center>Need Confirmation</center></div>
                                      <div class="col-sm-4 col-lg-4 p-1 bg-orange"><center>Confirmed - Waiting for approval</center></div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="d-flex justify-content-sm-start">
                              <label id="counter_view_search2"></label>
                            </div>
                            <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                              <table id="pendingPmRecordsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                                <thead style="text-align: center;">
                                  <tr>
                                    <th>No.</th>
                                    <th>RSIR No.</th>
                                    <th>Machine Name</th>
                                    <th>Machine No.</th>
                                    <th>Equipment No.</th>
                                    <th>Kind of Inspection</th>
                                    <th>RSIR Date</th>
                                  </tr>
                                </thead>
                                <tbody id="pendingPmRecordsData" style="text-align: center;">
                                  <tr>
                                    <td colspan="7" style="text-align:center;">
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
                            <h3 class="card-title"><i class="fas fa-history"></i> Recent RSIR History Table</h3>
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
                            <div id="accordion_recent_rsir_legend">
                              <div class="card shadow">
                                <div class="card-header">
                                  <h4 class="card-title w-100">
                                    <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseOneRecentRsirLegend">
                                      Recent RSIR History Legend
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapseOneRecentRsirLegend" class="collapse" data-parent="#accordion_recent_rsir_legend">
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-sm-4 col-lg-4 p-1 bg-lime"><center>Unread</center></div>
                                      <div class="col-sm-4 col-lg-4 p-1 bg-danger"><center>Disapproved</center></div>
                                      <div class="col-sm-4 col-lg-4 p-1 bg-success"><center>Approved</center></div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="d-flex justify-content-sm-start">
                              <label id="counter_view_search3"></label>
                            </div>
                            <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                              <table id="recentPmRecordsHistoryTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                                <thead style="text-align: center;">
                                  <tr>
                                    <th>No.</th>
                                    <th>RSIR No.</th>
                                    <th>Machine Name</th>
                                    <th>Machine No.</th>
                                    <th>Equipment No.</th>
                                    <th>Kind of Inspection</th>
                                    <th>RSIR Date</th>
                                  </tr>
                                </thead>
                                <tbody id="recentPmRecordsHistoryData" style="text-align: center;">
                                  <tr>
                                    <td colspan="7" style="text-align:center;">
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
                  </div>

                  <div class="tab-pane fade" id="machine-checksheets-pm-3" role="tabpanel" aria-labelledby="machine-checksheets-pm-3-tab">
                    <div id="accordion_returned_rsir_legend">
                      <div class="card shadow">
                        <div class="card-header">
                          <h4 class="card-title w-100">
                            <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseOneReturnedRsirLegend">
                              Returned RSIR Legend
                            </a>
                          </h4>
                        </div>
                        <div id="collapseOneReturnedRsirLegend" class="collapse" data-parent="#accordion_returned_rsir_legend">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-sm-6 col-lg-6 p-1 bg-lime"><center>Unread</center></div>
                              <div class="col-sm-6 col-lg-6 p-1 bg-yellow"><center>Need Resubmit</center></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-sm-start">
                      <label id="counter_view_search4"></label>
                    </div>
                    <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                      <table id="returnedPmRecordsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                        <thead style="text-align: center;">
                          <tr>
                            <th>No.</th>
                            <th>RSIR No.</th>
                            <th>Machine Name</th>
                            <th>Machine No.</th>
                            <th>Equipment No.</th>
                            <th>Kind of Inspection</th>
                            <th>RSIR Date</th>
                            <th>Returned By</th>
                            <th>Returned Date & Time</th>
                          </tr>
                        </thead>
                        <tbody id="returnedPmRecordsData" style="text-align: center;">
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

                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include('plugins/footer.php');
include('plugins/modals/logout_modal.php');
include('plugins/modals/need-rsir-mstprc_modal.php');
include('plugins/modals/rsir-step1_modal.php');
include('plugins/modals/rsir-step2_modal.php');
include('plugins/modals/pm-sticker_details.php');
include('plugins/modals/pending-rsir_modal.php');
include('plugins/modals/rsir-history_modal.php');
include('plugins/modals/returned-rsir_modal.php');
include('plugins/js/machine-checksheets-pm_script.php');
?>
