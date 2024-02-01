<?php
include('plugins/header.php');
include('plugins/css/machine-checksheets_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/machine-checksheets_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Machine Checksheets</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">EMS PM</a></li>
              <li class="breadcrumb-item"><a href="machine-checksheets.php">PM Documentation</a></li>
              <li class="breadcrumb-item active">Machine Checksheets</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner mb-3">
                <h4>RSIR</h4>
                <p>Regular / Special Inspection Record</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-list"></i>
              </div>
              <a data-toggle="modal" data-target="#RsirStep1Modal" class="small-box-footer" style="cursor:pointer;">Make RSIR Checksheet <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-maroon">
              <div class="inner mb-3">
                <h4>Work Order</h4>
                <p>Work Order (Machine & Facility)</p>
              </div>
              <div class="icon">
                <i class="ion ion-document-text"></i>
              </div>
              <a data-toggle="modal" data-target="#UploadWorkOrderModal" class="small-box-footer" style="cursor:pointer;">Upload Work Order <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-gray card-tabs">
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="machine-checksheets-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="machine-checksheets-1-tab" data-toggle="pill" href="#machine-checksheets-1" role="tab" aria-controls="machine-checksheets-1" aria-selected="true">Pending & Recent RSIR History</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="machine-checksheets-2-tab" data-toggle="pill" href="#machine-checksheets-2" role="tab" aria-controls="machine-checksheets-2" aria-selected="false">Returned RSIR</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="machine-checksheets-3-tab" data-toggle="pill" href="#machine-checksheets-3" role="tab" aria-controls="machine-checksheets-3" aria-selected="false">Machine Documents</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="machine-checksheets-tabContent">

                  <div class="tab-pane fade show active" id="machine-checksheets-1" role="tabpanel" aria-labelledby="machine-checksheets-1-tab">
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
                              <label id="counter_view_search"></label>
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
                              <label id="counter_view_search2"></label>
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

                  <div class="tab-pane fade" id="machine-checksheets-2" role="tabpanel" aria-labelledby="machine-checksheets-2-tab">
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

                  <div class="tab-pane fade" id="machine-checksheets-3" role="tabpanel" aria-labelledby="machine-checksheets-3-tab">
                    <div class="row mb-4">
                      <div class="col-sm-6">
                        <input type="text" class="form-control" id="i_search" placeholder="Search" maxlength="255">
                      </div>
                      <div class="col-sm-2">
                        <button type="button" class="btn bg-lime btn-block" onclick="load_machine_docs(3)"><i class="fas fa-search"></i> Search</button>
                      </div>
                      <div class="col-sm-2">
                        <button type="button" class="btn bg-lime btn-block" onclick="load_machine_docs(1)"><i class="fas fa-sync-alt"></i> Refresh Table</button>
                      </div>
                      <div class="col-sm-2">
                        <button type="button" class="btn bg-lime btn-block" id="btnGoAddMachineDocs" data-toggle="modal" data-target="#AddMachineDocsModal"><i class="fas fa-plus-circle"></i> Add Document</button>
                      </div>
                    </div>
                    <div class="d-flex justify-content-sm-start">
                      <label id="counter_view_search3"></label>
                    </div>
                    <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                      <table id="machineDocsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                        <thead style="text-align: center;">
                          <tr>
                            <th>No.</th>
                            <th>Machine Name</th>
                            <th>Type</th>
                            <th>Date Updated</th>
                          </tr>
                        </thead>
                        <tbody id="machineDocsData" style="text-align: center;">
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
                    <div class="d-flex justify-content-sm-end">
                      <input type="hidden" id="loader_count3">
                      <label id="counter_view3"></label>
                    </div>
                    <div class="d-flex justify-content-sm-center">
                      <button type="button" class="btn bg-lime" id="load_more_data3" style="display:none;" onclick="load_machine_docs(2)">Load more</button>
                      <button type="button" class="btn bg-lime" id="search_more_data3" style="display:none;" onclick="load_machine_docs(4)">Load more</button>
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
include('plugins/modals/rsir-step1_modal.php');
include('plugins/modals/rsir-step2_modal.php');
include('plugins/modals/pending-rsir_modal.php');
include('plugins/modals/rsir-history_modal.php');
include('plugins/modals/machine-docs_add.php');
include('plugins/modals/machine-docs_details.php');
include('plugins/modals/machine-docs_delete.php');
include('plugins/modals/upload-work-order_modal.php');
include('plugins/modals/returned-rsir_modal.php');
include('plugins/js/machine-checksheets_script.php');
?>
